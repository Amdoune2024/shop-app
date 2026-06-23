<?php
require 'config/db.php';
require './layout/header.php';

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
    $stmt->execute([$name,$email,$password]);

    echo "Compte créé avec succès. <a href='login.php'>Se connecter</a>";
}
?>

<h2>Inscription</h2>

<form method="POST">
    <input name="name" placeholder="Nom" required><br>
    <input name="email" placeholder="Email" required><br>
    <input name="password" type="password" placeholder="Mot de passe" required><br>
    <button name="register">Créer compte</button>
</form>

<a href="login.php">Déjà un compte ?</a>
<?php require './layout/footer.php'; ?>