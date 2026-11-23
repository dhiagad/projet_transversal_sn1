<?php
require_once 'config.php';

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $message = "Veuillez renseigner un email.";
    } elseif ($username === '') {
        $message = "Veuillez renseigner un nom d'utilisateur.";
    } elseif ($password === '') {
        $message = "Veuillez renseigner un mot de passe.";
    } else {
        $doublons = $dbh->prepare('SELECT COUNT(*) FROM `users` WHERE `username` = :username');
        $doublons->execute([
            'username' => $username,
        ]);
        if ((int) $doublons->fetchColumn() === 0) {
            $sth = $dbh->prepare('INSERT INTO `users` (`username`, `email`, `password`, `created_at`) VALUES (:username, :email, :password, NOW())');
            $sth->execute([
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit;
        } else {
            $message = "Ce nom d'utilisateur est deja pris.";
        }
    }
}

require 'header.php';
?>
<main>
    <h1>Inscription</h1>
    <?php if ($message !== '') { ?><p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p><?php } ?>
    <form method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà un compte ? <a href="connexion.php">Connectez-vous.</a></p>
</main>
<?php
require 'footer.php';
?>
