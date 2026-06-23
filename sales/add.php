<?php
require '../config/db.php';
require '../config/auth.php';
require '../layout/header.php';

$products = $conn->query("SELECT * FROM products")->fetchAll();

if(isset($_POST['submit'])){

    $customer = trim($_POST['customer']);
    $total = 0;

    // 🔢 NUMÉRO FACTURE AUTOMATIQUE (DATE + COMPTEUR)
    $today = date("Ymd");
    $prefix = "FAC-VEN-$today-";

    $stmt = $conn->prepare("
        SELECT COUNT(*) as total
        FROM sales
        WHERE DATE(created_at) = CURDATE()
    ");
    $stmt->execute();
    $count = $stmt->fetch()['total'] + 1;

    $invoice_number = $prefix . str_pad($count, 4, "0", STR_PAD_LEFT);

    // INSERT VENTE
    $stmt = $conn->prepare("
        INSERT INTO sales (customer_name, total, user_id, invoice_number)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $customer,
        0,
        $_SESSION['user']['id'],
        $invoice_number
    ]);

    $sale_id = $conn->lastInsertId();

    // ITEMS
    foreach($_POST['product_id'] as $key => $product_id){

        $qty = (int) $_POST['qty'][$key];

        if($qty <= 0) continue;

        $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$product_id]);
        $p = $stmt->fetch();

        if(!$p) continue;

        $price = $p['price'] * $qty;
        $total += $price;

        $stmt = $conn->prepare("
            INSERT INTO sale_items (sale_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$sale_id, $product_id, $qty, $price]);

        // UPDATE STOCK
        $stmt = $conn->prepare("
            UPDATE products SET stock = stock - ?
            WHERE id = ?
        ");

        $stmt->execute([$qty, $product_id]);
    }

    // UPDATE TOTAL
    $stmt = $conn->prepare("
        UPDATE sales SET total = ?
        WHERE id = ?
    ");

    $stmt->execute([$total, $sale_id]);

    // REDIRECTION FACTURE
    header("Location: invoice.php?id=".$sale_id);
    exit;
}
?>

<h2>Nouvelle vente</h2>

<form method="POST">

    <input name="customer" placeholder="Client" required>

    <br><br>

    <div>
        <select name="product_id[]">
            <?php foreach($products as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= htmlspecialchars($p['name']) ?> (<?= $p['price'] ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="qty[]" min="1" placeholder="Quantité" required>
    </div>

    <br><br>

    <button type="submit" name="submit">
        Valider vente
    </button>
    

</form>
<?php require '../layout/footer.php'; ?>