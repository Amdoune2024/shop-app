<?php
require 'config/db.php';
require 'config/auth.php';
require './layout/header.php';
?>

<h1>Shop App</h1>

<p>Bienvenue <?= $_SESSION['user']['name'] ?> (<?= $_SESSION['user']['role'] ?>)</p>

<a href="logout.php">Déconnexion</a>

<ul>
  <li><a href="products/add.php">Ajouter produit</a></li>
  <li><a href="products/list.php">Liste produits</a></li>
  <li><a href="sales/add.php">Nouvelle vente</a></li>
  <li><a href="purchases/add.php">Nouvel achat</a></li>
</ul>
<?php require './layout/footer.php'; ?>