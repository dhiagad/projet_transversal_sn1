<?php
require'header.php';

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$message = '';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$username = $_POST['username'] ?? '';

if ($email === '') {
    $message = "Veuillez renseigner un email.";
}
if($password === ''){
    $message = "Veuillez renseigner un mot de passe.";
}
if($username === ''){
    $message = "Veuillez renseigner un username.";
}

else {
    $doublons = $dbh->prepare('SELECT COUNT(*) FROM `users` WHERE `username` = :username');
    $doublons->execute([
        'username' => $username,
    ]);
    if ((int) $doublons->fetchColumn() === 0) {
        $sth = $dbh->prepare('INSERT INTO `users` (`username`, `email`, `password`,`created_at`) VALUES (:username, :email, :password, NOW())');
        $sth->execute([
            'email' => $email,
            'username' => $username,
               'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    }
    else{
        $message = "Ce username est deja pris.";
    }
}

?>
<title>Inscription</title>
<h1>Inscription</h1>
<?php if ($message !== ''){ ?><p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p><?php } ?>
<form method="post">
    <label>Username : <input type="texte" name="username" required></label><br>
    <label>Email : <input type='email' name="email" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <button value="register">S'inscrire</button>
</form>
<p>Deja un compte? <a href = connexion.php>Connectez vous.</a></p>

<?php
require'footer.php';
?>
