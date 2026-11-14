<?php
require_once'config.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <a classe = "bar_btn" href="index.php">Pendu</a>
    <?php
    if (!isset($_SESSION['username'])){?>
        <a classe = "bar_btn" href="connexion.php">connexion</a>
        <a classe = "bar_btn" href="inscription.php">inscription</a>
        <?php
    }
    else{?>
        <p classe = "bar_btn"><?php echo ($_SESSION['username'])?></p>
        <a classe = "bar_btn" href="deconnexion.php">deconnexion</a>
    <?php
    }?>
    <a classe = "bar_btn" href="classement.php">Classement</a>
    <a classe = "bar_btn" href="regles_du_jeu.php">Règles du jeu</a>
</header>
