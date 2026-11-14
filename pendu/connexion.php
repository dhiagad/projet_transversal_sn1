<?php
require'header.php';

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

else{ ?>
    <h1>Connexion</h1>
    <form method="post">
        <label>Username : </Label>
        <input type="texte" name="username"><br/>
        <label>Email : </Label>
        <input type="email" name="email"><br/>
        <label>Password : </Label>
        <input type="password" name="password"><br/>
        <input type="submit" value="Valider" name="connect">
    </form>
    <p>Pas de compte? <a href = inscription.php>Inscrivez vous.</a></p>
    <?php
    if (isset($_POST['connect' ])) {
        $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email and username = :username");
        $stmt->execute([
            'email' => $_POST['email'],
            'username' => $_POST['username'],
            ]);
        $user = $stmt->fetch(PDO :: FETCH_ASSOC);
        if ($user) {
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION['username' ] = $_POST['username'];
                header('Location: index.php');
                exit;
            }
        }
    }
} 

require'footer.php';
?>
