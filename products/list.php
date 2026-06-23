<?php

require '../config/db.php';
require '../layout/header.php';

// 🔐 protection login
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$products = $conn->query("SELECT * FROM products")->fetchAll();
?>

<div class="container">

<h2 class="mb-3">Produits</h2>

<table class="table table-striped table-bordered">

<tr class="table-dark">
    <th>Nom</th>
    <th>Prix</th>
    <th>Stock</th>
</tr>

<?php foreach($products as $p): ?>
<tr>
    <td><?= htmlspecialchars($p['name']) ?></td>
    <td><?= $p['price'] ?></td>
    <td><?= $p['stock'] ?></td>
</tr>
<?php endforeach; ?>

</table>

</div>

<?php require '../layout/footer.php'; ?>