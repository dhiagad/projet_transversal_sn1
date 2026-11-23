<?php
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: connexion.php');
    exit;
}

if (isset($_POST['reset'])) {
    unset($_SESSION['mot'], $_SESSION['lettresTrouvees'], $_SESSION['erreurs']);
    $difficultyQuery = isset($_SESSION['difficulty'])
        ? '?difficulty=' . rawurlencode($_SESSION['difficulty'])
        : '';
    header('Location: jeux.php' . $difficultyQuery);
    exit();
}

$requestedDifficulty = $_GET['difficulty'] ?? null;
if ($requestedDifficulty !== null && $requestedDifficulty !== ($_SESSION['difficulty'] ?? null)) {
    unset($_SESSION['mot'], $_SESSION['lettresTrouvees'], $_SESSION['erreurs']);
}

if (!isset($_SESSION['mot'])) {
    if ($requestedDifficulty !== null) {
        $_SESSION['difficulty'] = $requestedDifficulty;
        $wordQuery = $dbh->prepare('SELECT `word` FROM `words` WHERE `difficulty` = :difficulty ORDER BY RAND() LIMIT 1');
        $wordQuery->execute(['difficulty' => $requestedDifficulty]);
    } else {
        unset($_SESSION['difficulty']);
        $wordQuery = $dbh->query('SELECT `word` FROM `words` ORDER BY RAND() LIMIT 1');
    }

    $selectedWord = $wordQuery->fetchColumn();
    if ($selectedWord === false) {
        $message = 'Aucun mot disponible pour cette difficulté.';
    } else {
        $_SESSION['mot'] = strtoupper($selectedWord);
        $_SESSION['lettresTrouvees'] = [];
        $_SESSION['erreurs'] = 0;
    }
}

$message = $message ?? '';

if (isset($_SESSION['mot'])) {
    $mot = $_SESSION['mot'];

    if (isset($_POST['lettre'])) {
        $lettre = strtoupper($_POST['lettre']);

        if (!in_array($lettre, $_SESSION['lettresTrouvees'])) {
            $_SESSION['lettresTrouvees'][] = $lettre;

            if (strpos($mot, $lettre) === false) {
                $_SESSION['erreurs']++;
            }
        }
    }

    $affichage = "";

    for ($i = 0; $i < strlen($mot); $i++) {
        if (in_array($mot[$i], $_SESSION['lettresTrouvees'])) {
            $affichage .= $mot[$i] . " ";
        } else {
            $affichage .= "_ ";
        }
    }

    $victoire = true;

    for ($i = 0; $i < strlen($mot); $i++) {
        if (!in_array($mot[$i], $_SESSION['lettresTrouvees'])) {
            $victoire = false;
            break;
        }
    }
}

require 'header.php';
?>
<main class="game">
    <h1>Jeu du pendu</h1>
    <?php
    if ($message !== '') {
        echo '<p>' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p><a href="index.php">Choisir une difficulté</a></p>';
    } else {
        ?>
        <p class="word">Mot : <span><?php echo $affichage; ?></span></p>
        <p class="errors">Erreurs : <?php echo $_SESSION['erreurs']; ?>/6</p>
        <form method="POST">
            <label for="lettre">Choisis une lettre :</label>
            <input type="text" id="lettre" name="lettre" maxlength="1" required>
            <button type="submit">Tester</button>
        </form>
        <form method="POST">
            <button type="submit" name="reset">Réessayer</button>
        </form>
        <?php
        if ($victoire) {
            echo "<h2>Bravo ! Vous avez gagné !</h2>";
        }

        if ($_SESSION['erreurs'] >= 6) {
            echo "<h2> perdu !</h2>";
            echo "<p>Le mot c'était : " . htmlspecialchars($mot, ENT_QUOTES, 'UTF-8') . "</p>";
        }
    }
    ?>
</main>
<?php
require 'footer.php';
?>
