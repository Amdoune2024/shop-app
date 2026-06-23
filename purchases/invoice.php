<?php
require '../config/db.php';
require '../layout/header.php';
$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM purchases WHERE id=?");
$stmt->execute([$id]);
$purchase = $stmt->fetch();

$stmt = $conn->prepare("
    SELECT pi.*, p.name
    FROM purchase_items pi
    JOIN products p ON p.id = pi.product_id
    WHERE pi.purchase_id=?
");
$stmt->execute([$id]);
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Facture Achat</title>
</head>
<body>

<h2>FACTURE D'ACHAT</h2>

<p><strong>N° Facture :</strong>
<?= $purchase['invoice_number'] ?>
</p>

<p><strong>Fournisseur :</strong>
<?= htmlspecialchars($purchase['supplier_name']) ?>
</p>

<p><strong>Date :</strong>
<?= $purchase['created_at'] ?>
</p>

<table border="1" cellpadding="8">
    <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Montant</th>
    </tr>

    <?php foreach($items as $item): ?>
    <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= number_format($item['price'],0,' ',' ') ?> FCFA</td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>
Total : <?= number_format($purchase['total'],0,' ',' ') ?> FCFA
</h3>

<button onclick="window.print()">
    Imprimer la facture
</button>


</body>
</html>
<?php require '../layout/footer.php'; ?>