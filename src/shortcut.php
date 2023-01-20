<?php

require __DIR__ . '/connection.php';

function validateUrl(array $form): ?string {
    if (empty($form['url'])) {
        return "Veuillez saisir une URL à raccourcir";
    }

    if (filter_var($form['url'], FILTER_VALIDATE_URL) === false) {
        return "Adresse URL non valide";
    }

    $parseUrl = parse_url($form['url'], PHP_URL_SCHEME);
    if ($parseUrl !== "http" && $parseUrl !== "https") {
        return "Adresse URL non valide";
    }

    return null;
}

function createShortcut(array $form): string
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = "https";
    } else {
        $protocol = "http";
    }
    $protocol .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $checkUrl = validateUrl($form);
    if ($checkUrl !== null) {
        return $checkUrl;
    }

    $connection = getDbConnection();
    $url = htmlspecialchars($form['url']);
    $duplicatedUrl = $connection->prepare('SELECT * FROM links WHERE url = ?');
    $duplicatedUrl->execute(array($url));
    $result = $duplicatedUrl->fetch(PDO::FETCH_ASSOC);
    if ($duplicatedUrl->rowCount() == 1) {
        $shortcutUrl = $result['shortcut'];
    } else {
        try {
            $shortcutUrl = crypt($url, rand());
            $shortcutIt = $connection->prepare('INSERT INTO links (url, shortcut) VALUES (?, ?)');
            $shortcutIt->execute(array($url, $shortcutUrl));
        } catch (PDOException $error) {
            die($error->getMessage());
        }
    }

    return $protocol . "?url=" . $shortcutUrl;
}
