<?php
require'header.php';

if (isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}

$message = '';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '') {
    $message = "Veuillez renseigner un email.";
}
if($password === ''){
    $message = "Veuillez renseigner un mot de passe.";
}
else {
    try {
        $sth = $dbh->prepare('INSERT INTO `users` (`email`, `password`,`created_at`) VALUES (:email, :password, NOW())');
        $sth->execute([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        $_SESSION['email'] = $email;
        header('Location: index.php');
        exit;
    }
    catch (PDOException $e) {
        if ($e->getCode() !== '23000') {
            throw $e;
        }
        $message = 'Ce username est déjà utilisé.';
    }
}

?>
<title>Inscription</title>
<?php if ($message !== ''){ ?><p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p><?php } ?>
<form method="post">
    <label>Email : <input type='email' name="email" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <button value="register">S'inscrire</button>
</form>

<?php
require'footer.php';
?>