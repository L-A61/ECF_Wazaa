<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        // Nom du fichier sans l'extension pour titre
        echo ucfirst(basename($_SERVER['PHP_SELF'], '.php'));
        ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/styles/style.css">
</head>

<body>

    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Configuration bdd
    $host = '127.0.0.1';
    $dbname = 'afpa_wazaa_immo';
    $username = 'root';
    $password = '';

    try {
        // Connexion bdd
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    ?>
    <?php

    // Vérifiez si l'utilisateur est connecté
    $username = null;
    if (isset($_SESSION['u_ID'])) {
        $userId = $_SESSION['u_ID'];

        // Récupération des informations de l'utilisateur
        $sqlUser = "SELECT * FROM waz_utilisateur WHERE u_ID=:u_ID";
        $stmtUser = $pdo->prepare($sqlUser);
        $stmtUser->execute(['u_ID' => $userId]);
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $username = $user['u_ID'];
        }
    }

    // Deux variables pour définir deux cas: si admin ou employé, et si admin
    $isAdminOrEmployee = isset($_SESSION['tu_libelle']) && in_array($_SESSION['tu_libelle'], ['admin', 'employé']);
    $isAdmin = isset($_SESSION['tu_libelle']) && in_array($_SESSION['tu_libelle'], ['admin']);