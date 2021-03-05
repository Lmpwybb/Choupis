<?php

require 'connection.php';

function shortCutIt(array $form): string
{
    if (empty($form['url'])) {
        return "Veuillez saisir une URL à raccourcir";
    }

    if (filter_var($form['url'], FILTER_VALIDATE_URL) === false) {
        return "Adresse URL non valide";
    }

    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = "https";
    } else {
        $protocol  = "http";
    }
    $protocol  .= "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $connection = getConnection();
    $url = htmlspecialchars($form['url']);

    try {
        $duplicatedUrl = $connection->prepare('SELECT COUNT(*) AS x FROM links WHERE url = ?');
        $duplicatedUrl->execute(array($url));
        while($result = $duplicatedUrl->fetch(PDO::FETCH_ASSOC)) {
            if($result['x'] != 0) {
                return "Cette URL a déjà été raccourcie";
            }
        }
    } catch (PDOException $error) {
        die($error->getMessage());
    }

    $shortcutUrl = crypt($url, rand());
    $shortcutIt = $connection->prepare('INSERT INTO links (url, shortcut) VALUES (?, ?)');
    $shortcutIt->execute(array($url, $shortcutUrl));

    return $protocol . "?url=" . $shortcutUrl;
}
