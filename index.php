<?php require __DIR__ . '/src/shortcut.php'; ?>

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
    <link rel="stylesheet" type="text/css" href="design/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="shortcut icon" href="pictures/favicon.ico" type="image/png">
</head>
<body>
<section class="hero is-fullheight has-bg-img">
    <header class="hero-head">
        <div class="container">
            <img src="pictures/choupisB.png" alt="logo">
        </div>
    </header>
    <div class="hero-body has-text-centered">
        <div class="container">
            <h1 class="title has-text-white">Une URL à rallonge ? Choupisez-la !</h1>
            <h2 class="subtitle has-text-white">Largement plus choupie que les autres.</h2>
            <form method="post" action="index.php">
                <label>
                    <input class="input is-link is-medium is-rounded" type="url" name="url"
                           placeholder="Collez un lien">
                </label>
                <label>
                    <input class="button is-medium is-rounded has-text-white" type="submit" value="Raccourcir">
                </label>
            </form>
            <?php
            if (isset($_GET['url'])) {
                $connection = getConnection();
                $url = htmlspecialchars($_GET['url']);

                $redirect = $connection->prepare('SELECT * FROM links WHERE shortcut = ?');
                $redirect->execute(array($url));
                $result = $redirect->fetch(PDO::FETCH_ASSOC);

                header('Location: ' . $result['url']);
                exit();
            }

            if (isset($_POST['url'])) {
                echo "<div class='notification is-rounded'><b>" . shortCutIt($_POST) . "</b></div>";
            }
            ?>
        </div>
    </div>
</section>
<footer class="footer has-text-centered">
    <img src="pictures/choupisV.png" alt="logo">
    <p>&copy; choupis.alwaysdata.net</p>
</footer>
</body>
</html>
