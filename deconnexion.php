
<?php
// session_start() réécrit ici au lieu d'include header.php (nécessaire au bon fonctionnement de la fonctionnalité déconnexion)
session_start();

// Supprime tous les éléments de la session (dans ce cas là les informations de l'utilisateur).
$_SESSION = [];

// Suppression de la session
session_destroy();

// Redirection vers index.php
header("Location: index.php");
exit;
?>