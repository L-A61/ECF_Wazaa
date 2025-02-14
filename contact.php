<?php
include("header.php");

// Requête SQL du référencement de l'annonce via son id
$id = isset($_GET['annonce']) ? $_GET['annonce'] : '';
$sql = "SELECT an_ref FROM waz_annonces WHERE an_id = '$id'";
$annonce = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

if (!$annonce) {
    header("Location: index.php");
}

?>

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