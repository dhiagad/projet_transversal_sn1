<?php
require'header.php';

if (isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

else{ ?>
    <main>
    <h1>Connexion</h1>
    <form method="post">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="connect">Se connecter</button>
    </form>
    </main>
    <?php
    if (isset($_POST['connect' ])) {
        $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $_POST['email']]);
        $user = $stmt->fetch(PDO :: FETCH_ASSOC);
        if ($user) {
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION['email' ] = $_POST['email'];
                header('Location: index.php');
                exit;
            }
        }
    }
} 

require'footer.php';
?>