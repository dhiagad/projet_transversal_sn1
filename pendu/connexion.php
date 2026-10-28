<?php
require'header.php';

if (isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

else{ ?>
    <h1>Connexion</h1>
    <form method="post">
        <label>Email : </Label>
        <input type="email" name="email"><br/>
        <label>Password : </Label>
        <input type="password" name="password"><br/>
        <input type="submit" value="Valider" name="connect">
    </form>
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