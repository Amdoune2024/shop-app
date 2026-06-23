<?php

require '../config/db.php';
require '../layout/header.php';

// 🔐 Sécurité : utilisateur connecté obligatoire
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$products = $conn->query("SELECT * FROM products")->fetchAll();

if(isset($_POST['submit'])){

    $supplier = trim($_POST['supplier']);
    $total = 0;

    $invoice_number = "FAC-ACH-" . date("YmdHis");

    // INSERT avec user_id
    $stmt = $conn->prepare("
        INSERT INTO purchases (supplier_name, total, invoice_number, user_id)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $supplier,
        0,
        $invoice_number,
        $_SESSION['user']['id']
    ]);

    $id = $conn->lastInsertId();

    foreach($_POST['product_id'] as $k => $pid){

        $qty = (int)$_POST['qty'][$k];

        if($qty <= 0) continue;

        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$pid]);
        $p = $stmt->fetch();

        if(!$p) continue;

        $price = $p['price'] * $qty;
        $total += $price;

        $stmt = $conn->prepare("
            INSERT INTO purchase_items
            (purchase_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$id, $pid, $qty, $price]);

        $stmt = $conn->prepare("
            UPDATE products
            SET stock = stock + ?
            WHERE id = ?
        ");

        $stmt->execute([$qty, $pid]);
    }

    $stmt = $conn->prepare("
        UPDATE purchases
        SET total = ?
        WHERE id = ?
    ");

    $stmt->execute([$total, $id]);

    header("Location: invoice.php?id=".$id);
    exit;
}
?>

<h2>Achat</h2>

<form method="POST">

    <input type="text" name="supplier" placeholder="Fournisseur" required>

    <br><br>

    <select name="product_id[]">
        <?php foreach($products as $p): ?>
            <option value="<?= $p['id'] ?>">
                <?= htmlspecialchars($p['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="number" name="qty[]" min="1" placeholder="Quantité" required>

    <br><br>

    <button type="submit" name="submit">
        Valider
    </button>

</form>

<?php require '../layout/footer.php'; ?>

