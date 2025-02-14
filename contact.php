<?php
include("header.php");

// Requête préparé SQL du référencement de l'annonce via son id
$id = isset($_GET['annonce']) ? $_GET['annonce'] : '';
$stmt = $pdo->prepare("SELECT an_ref FROM waz_annonces WHERE an_id = ?");
$stmt->execute([$id]);
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);

// Si aucune annonce n'est trouvé, redirection vers index
if (!$annonce) {
    header("Location: index.php");
}

?>

<!-- Formulaire de contact -->
<form>
    <div class="form-group">

        <div class="form-group">
            <label for="ref">Référencement: <?= htmlentities($annonce['an_ref']) ?> </label>
        </div>

        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" class="form-control" id="nom" placeholder="Votre nom">
        </div>

        <div class="form-group">
            <label for="prenom">Prénom:</label>
            <input type="text" class="form-control" id="prenom" placeholder="Votre prénom">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" placeholder="Votre email">
        </div>

        <div class="form-group">
            <label for="tel">Numéro de Téléphone:</label>
            <input type="text" class="form-control" id="tel" placeholder="Votre téléphone">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
</form>


<?php
include("footer.php");
?>