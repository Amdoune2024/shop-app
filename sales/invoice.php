<?php
require '../config/db.php';
require '../layout/header.php';

$id = $_GET['id'];

// FACTURE
$stmt = $conn->prepare("SELECT * FROM sales WHERE id=?");
$stmt->execute([$id]);
$sale = $stmt->fetch();

// ITEMS
$stmt = $conn->prepare("
    SELECT si.*, p.name
    FROM sale_items si
    JOIN products p ON p.id = si.product_id
    WHERE si.sale_id=?
");
$stmt->execute([$id]);
$items = $stmt->fetchAll();
?>

<h2>FACTURE DE VENTE</h2>

<p><strong>N° Facture :</strong> <?= $sale['invoice_number'] ?></p>
<p><strong>Client :</strong> <?= htmlspecialchars($sale['customer_name']) ?></p>
<p><strong>Date :</strong> <?= $sale['created_at'] ?></p>

<hr>

<table border="1" cellpadding="8">
    <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix</th>
    </tr>

    <?php foreach($items as $i): ?>
    <tr>
        <td><?= htmlspecialchars($i['name']) ?></td>
        <td><?= $i['quantity'] ?></td>
        <td><?= number_format($i['price'], 0, ',', ' ') ?> FCFA</td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Total : <?= number_format($sale['total'], 0, ',', ' ') ?> FCFA</h3>

<br>

<button onclick="window.print()">
    Imprimer facture
</button>
<?php require '../layout/footer.php'; ?>