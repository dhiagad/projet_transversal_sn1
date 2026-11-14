<?php
require'header.php';
?>

<main>
    <h1>Bienvenue sur le jeu du pendu !</h1>
    <p>Choisissez votre difficulté.</p>

    <div classe = choix_diff>
        <?php
        $dif = $dbh->prepare("SELECT COUNT(*) FROM difficulty");
        $dif->execute();
        $nb_dif = $dif->fetchColumn();
        for ($i = 0;$i < $nb_dif; $i++){
            $nom = $dbh->prepare("SELECT name FROM difficulty ORDER BY id LIMIT 1 OFFSET :i");
            $nom->bindValue(':i', $i, PDO::PARAM_INT);
            $nom->execute();?>
            <div classe = diff>
                <h2><?php echo($nom->fetchColumn()) ?></h2>
                <a class="button" href="jeux.php">Commencer une partie</a>
            </div>
        <?php
        }?>
    </div>
</main>

<?php
require'footer.php';
?>
