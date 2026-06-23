<?php

require '../config/db.php';
require '../layout/header.php';

// 🔐 sécurité : utilisateur connecté obligatoire
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

if(isset($_POST['submit'])){
    $stmt = $conn->prepare("INSERT INTO products(name, price, stock) VALUES (?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['price'],
        $_POST['stock']
    ]);

    echo "<div class='alert alert-success'>Produit ajouté</div>";
}
?>

<div class="container">

<h2 class="mb-3">Ajouter produit</h2>

<form method="POST" class="card p-3 shadow-sm">

  <input name="name" class="form-control mb-2" placeholder="Nom">

  <input name="price" class="form-control mb-2" placeholder="Prix">

  <input name="stock" class="form-control mb-2" placeholder="Stock">

  <button name="submit" class="btn btn-primary">
    Ajouter
  </button>

</form>

</div>

<?php require '../layout/footer.php'; ?>