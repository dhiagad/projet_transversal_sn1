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
    <a id = "menu_btn" href="index.php"><b>Pendu</b></a>
    <div class="bar_btn">
        <a href="classement.php">Classement</a>
        <a href="regles_du_jeu.php">Règles du jeu</a>
        <?php
        if (!isset($_SESSION['username'])){?>
            <a href="connexion.php">connexion</a>
            <a href="inscription.php">inscription</a>
            <?php
        }
        else{?>
            <a href="deconnexion.php">deconnexion</a>
            <span id="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <?php
        }?>
    </div>
</header>