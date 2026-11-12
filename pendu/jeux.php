<?php
session_start();
if (!isset($_SESSION['mot'])) {
    $mots = ["TEST", "BANANE", "ORDINATEUR", "MEOW"];
    $_SESSION['mot'] = $mots[array_rand($mots)];
    $_SESSION['lettresTrouvees'] = [];
    $_SESSION['erreurs'] = 0;}
$mot = $_SESSION['mot'];
if (isset($_POST['lettre'])) {
    $lettre = strtoupper($_POST['lettre']);

    if (!in_array($lettre, $_SESSION['lettresTrouvees'])) {
        $_SESSION['lettresTrouvees'][] = $lettre;

        if (strpos($mot, $lettre) === false) {
            $_SESSION['erreurs']++;}
    }
}
$affichage = "";

for ($i = 0; $i < strlen($mot); $i++) {

    if (in_array($mot[$i], $_SESSION['lettresTrouvees'])) {
        $affichage .= $mot[$i] . " ";
    } else {
        $affichage .= "_ ";}
}
$victoire = true;

for ($i = 0; $i < strlen($mot); $i++) {
    if (!in_array($mot[$i], $_SESSION['lettresTrouvees'])) {
        $victoire = false;
        break;}
}

if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pendu</title>
</head>
<body>
<h1> pendu</h1>
<p>Mot : <?php echo $affichage; ?></p>
<p>Erreurs : <?php echo $_SESSION['erreurs']; ?>/6</p>
<form method="POST">
    <input type="text" name="lettre" maxlength="1" required>
    <button type="submit">Tester</button>
</form>
<form method="POST">
    <button type="submit" name="reset">ressayer</button>
</form>
<?php
if ($victoire) {
    echo "<h2>Bravo ! Vous avez gagné !</h2>";
}

if ($_SESSION['erreurs'] >= 6) {
    echo "<h2> perdu !</h2>";
    echo "<p>Le mot c'était : $mot</p>";
}
?>

</body>
</html>
