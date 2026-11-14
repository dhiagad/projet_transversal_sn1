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
    <?php
    if (!isset($_SESSION['username'])){?>
        <a href="connexion.php">connexion</a>
        <a href="inscription.php">inscription</a>
        <?php
    }
    else{?>
        <p><?php echo ($_SESSION['username'])?></p>
        <a href="deconnexion.php">deconnexion</a>
    <?php
    }?>
</header>
