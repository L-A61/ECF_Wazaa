<?php
include("header.php");

$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$id_annonce = null;

if ($id !== '') {
    $sql = "SELECT * FROM waz_annonces a JOIN waz_type_bien tb ON a.tb_id = tb.tb_id WHERE an_id = '$id'";
    $result = $pdo->query($sql);
    $annonce = $result->fetch(PDO::FETCH_ASSOC);

    if ($annonce) {
        $offre = $annonce['an_offre'];
        $pieces = $annonce['an_pieces'];
        $titre = $annonce['an_titre'];
        $ref = $annonce['an_ref'];
        $description = $annonce['an_description'];
        $local = $annonce['an_local'];
        $surf_hab = $annonce['an_surf_hab'];
        $surf_tot = $annonce['an_surf_tot'];
        $prix = $annonce['an_prix'];
        $diagnostic = $annonce['an_diagnostic'];
        
        $id_annonce = $annonce['an_id'];
    } else {
        echo "Annonce introuvable.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    if($id_annonce !== null) {
        $stmt = $pdo->prepare("UPDATE waz_annonces SET an_titre = ?, an_description = ?, an_prix = ?");
        $stmt->execute([$titre, $description, $prix]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO waz_annonces (an_titre, an_description, an_prix) VALUES (?, ?, ?)");
        $stmt->execute([$titre, $description, $prix]);
    }

    header('Location:index.php');
    exit;
}

?>

<div>
    <h1><?= $id ? "Modification" : "Création" ?> de l'annonce</h1>

    <form method="post">
        <div>
            <label for="titre">Titre de l'annonce</label>
            <input type="text" name="titre" id="titre" value="<?= $id ? htmlentities($titre) : "" ?>">
            <br>
            <label for="description">Description</label>
            <input type="text" name="description" id="description" value="<?= $id ? htmlentities($description) : "" ?>">
            <br>
            <label for="prix">Prix (en €)</label>
            <input type="text" name="prix" id="prix" value="<?= $id ? htmlentities($prix) : "" ?>">
        </div>
        <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer"?></button>
        <a href="index.php">Retour</a>
    </form>
</div>

<?php
    // TODO : ajouter une date modification via NOW() si première modification, update la date si deuxième ou +, date ajout si nouveau.
    // $sqlModif = "UPDATE waz_annonces SET an_vues = an_vues+1 WHERE an_id = '$id'";
    // $pdo->exec($sqlModif);
    include("footer.php");
?>