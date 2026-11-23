<?php
require'header.php';
?>

<main>
    <h1>Bienvenue sur le jeu du pendu !</h1>
    <p>Choisissez votre difficulté.</p>

    <div class="choix_diff">
        <?php
        $difficulties = $dbh->query("SELECT name, color FROM difficulty ORDER BY id");
        foreach ($difficulties as $difficulty) {
            $difficultyName = $difficulty['name'];
            ?>
            <div class="diff">
                <h2><?= htmlspecialchars($difficultyName, ENT_QUOTES, 'UTF-8') ?></h2>
                <a class="button" href="jeux.php?difficulty=<?= rawurlencode($difficultyName) ?>"
                   style="background-color: <?= htmlspecialchars($difficulty['color'], ENT_QUOTES, 'UTF-8') ?>;">
                    Commencer une partie
                </a>
            </div>
        <?php } ?>
    </div>
</main>

<?php
require'footer.php';
?>