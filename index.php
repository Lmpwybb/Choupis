<?php

require 'shortcut.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="index, follow, noodp">
    <meta name="description" content="Choupis raccourcisseur d'url express">
    <meta name="keywords" content="raccourcisseur url express native responsive HTML CSS PHP">
    <meta name="author" content="Choupis">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choupis</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="shortcut icon" href="pictures/favicon.ico" type="image/png">
</head>
<body>
<section class="section has-bg-img">
        <header class="has-text-left">
            <img src="pictures/choupisB.png" alt="logo">
        </header>
        <div class="block has-text-centered">
            <h1 class="title is-2 has-text-white">Une URL à rallonge ? Choupisez-la !</h1>
            <h2 class="subtitle is-3 has-text-white">Largement plus choupie que les autres.</h2>
            <form method="post" action="index.php">
                <label>
                    <input class="input is-link is-medium is-rounded scale" type="url" name="url"
                           placeholder="Collez un lien">
                </label>
                <label>
                    <input class="button is-medium is-rounded scale has-text-white" type="submit" value="Raccourcir">
                </label>
            </form>
            <div class="notification is-rounded">
                <?php
                    if (isset($_GET['url'])) {
                        $connection = getConnection();
                        $url = htmlspecialchars($_GET['url']);

                        $redirect = $connection->prepare('SELECT * FROM links WHERE shortcut = ?');
                        $redirect->execute(array($url));
                        $result = $redirect->fetch(PDO::FETCH_ASSOC);

                        header('location: ' . $result['url']);
                        exit();
                    }

                    if (isset($_POST['url'])) {
                        echo "<b>" . shortCutIt($_POST) . "</b>";
                    } else {
                        echo "<b>Votre lien sera ici</b>";
                    }
                ?>
            </div>
        </div>
</section>
<footer class="footer has-text-centered">
    <img src="pictures/choupisV.png" alt="logo">
    <p>&copy choupis.alwaysdata.net</p>
</footer>
</body>
</html>
