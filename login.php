<?php
require 'config/db.php';
require './layout/header.php';

if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Veuillez saisir une adresse e-mail valide.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password'])){
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit;
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    }
}
?>

<h2>Connexion</h2>

<?php if(isset($error)) echo $error; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input name="password" type="password" placeholder="Mot de passe" required><br>
    <button name="login">Se connecter</button>
</form>

<a href="register.php">Créer un compte</a>

<?php require './layout/footer.php'; ?>