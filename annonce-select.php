<?php
include("header.php");

if (!$isAdminOrEmployee) {
    header("Location: index.php");
    exit;
}

$utilisateur = $_SESSION['u_id'];

$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$id_annonce = null;

// Requête préparé pour les options
$stmtOptions = $pdo->prepare("SELECT * FROM waz_options");
$stmtOptions->execute();
$options = $stmtOptions->fetchAll(PDO::FETCH_ASSOC);

// Requête préparé pour les types de bien
$stmtBien = $pdo->prepare("SELECT * FROM waz_type_bien");
$stmtBien->execute();
$typeBien = $stmtBien->fetchAll(PDO::FETCH_ASSOC);

// Requête préparé pour les Offre
$stmtOffre = $pdo->prepare("SELECT * FROM waz_type_offre");
$stmtOffre->execute();
$typeOffre = $stmtOffre->fetchAll(PDO::FETCH_ASSOC);

// Requête préparé poures les options dans les annonces
// $stmtOptionsAn = $pdo->prepare("SELECT * FROM waz_opt_annonces");
// $stmtOptionsAn->execute();
// $optionsAn = $stmtOptionsAn->fetchAll(PDO::FETCH_ASSOC);

if ($id !== '') {
    $stmt = $pdo->prepare("SELECT * FROM waz_annonces WHERE an_id = ?");
    $stmt->execute([$id]);
    $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($annonce) {
        $titre = $annonce['an_titre'];
        $pieces = $annonce['an_pieces'];
        $description = $annonce['an_description'];
        $prix = $annonce['an_prix'];
        $ref = $annonce['an_ref'];
        $local = $annonce['an_local'];
        $surf_hab = $annonce['an_surf_hab'];
        $surf_tot = $annonce['an_surf_tot'];
        $diagnostic = $annonce['an_diagnostic'];
        $type = $annonce['tb_id'];
        $offre = $annonce['to_id'];

        $id_annonce = $annonce['an_id'];
        $date_modification = $annonce['an_d_modif'];
        $id_utilisateur = $annonce['u_id'];

        // $id_options_annonces = $optionsAn['an_id'];
    } else {
        echo "Annonce introuvable.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $pieces = $_POST['pieces'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $ref = $_POST['ref'];
    $local = $_POST['local'];
    $surf_hab = $_POST['surfhab'];
    $surf_tot = $_POST['surftot'];
    $diagnostic = $_POST['diagnostic'];
    $type = $_POST['typeBien'];
    $offre = $_POST['offre'];

    if ($id_annonce !== null) {
        $stmt = $pdo->prepare("UPDATE waz_annonces SET an_titre = ?, an_pieces = ?, an_description = ?, an_prix = ?, an_ref = ?, an_local = ?, an_surf_hab = ?, an_surf_tot = ?, an_diagnostic = ?, tb_id = ?, to_id = ? WHERE an_id = ?");
        $stmt->execute([$titre, $pieces, $description, $prix, $ref, $local, $surf_hab, $surf_tot, $diagnostic, $type, $offre, $annonce['an_id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO waz_annonces (an_titre, an_pieces, an_description, an_prix, an_ref, an_local, an_surf_hab, an_surf_tot, an_diagnostic, an_d_ajout, an_statut, tb_id, u_id, to_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1, ?, ?, ?)");
        $stmt->execute([$titre, $pieces, $description, $prix, $ref, $local, $surf_hab, $surf_tot, $diagnostic, $type, $utilisateur, $offre]);
    }

    // if($id_options_annonces !== null) {
    //     $stmt = $pdo->prepare("UPDATE waz_opt_annonces SET opt_id = ? WHERE an_id = ?");
    //     $stmt->execute([$options, $optionsAn['an_id']]);
    // } else {
    //     $stmt = $pdo->prepare("INSERT INTO waz_annonces (an_titre, an_description, an_prix, an_ref, an_local, an_surf_hab, an_surf_tot, an_diagnostic, an_d_ajout) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    //     $stmt->execute([$titre, $description, $prix, $ref, $local, $surf_hab, $surf_tot, $diagnostic]);
    // }

    header('Location:index.php');
    exit;
}

?>

<div>
    <h1><?= $id ? "Modification" : "Création" ?> de l'annonce</h1>

    <form method="post">
        <div>
            <div>
                <label for="titre">Titre de l'annonce: </label>
                <input type="text" name="titre" id="titre" value="<?= $id ? htmlentities($titre) : "" ?>">
            </div>

            <div>
                <label for="offre">Type d'offre: </label>
                <?php foreach ($typeOffre as $type): ?>
                    <input type="radio" name="offre" value="<?= htmlentities($type['to_id']) ?>" <?= (isset($annonce['to_id']) && $annonce['to_id'] == $type['to_id']) ? 'checked' : '' ?>>
                    <?= htmlentities($type['to_libelle']) ?>
                <?php endforeach; ?>
            </div>

            <div>
                <label for="pieces">Nombre de pièces: </label>
                <input type="text" name="pieces" id="pieces" value="<?= $id ? htmlentities($pieces) : "" ?>">
            </div>

            <div>
                <label for="description">Description: </label>
                <input type="text" name="description" id="description" value="<?= $id ? htmlentities($description) : "" ?>">
            </div>
            <div>
                <label for="prix">Prix: </label>
                <input type="text" name="prix" id="prix" value="<?= $id ? htmlentities($prix) : "" ?>">€
            </div>

            <div>
                <label for="ref">N° reference: </label>
                <input type="text" name="ref" id="ref" value="<?= $id ? htmlentities($ref) : "" ?>">
            </div>

            <div>
                <label for="local">Localisation: </label>
                <input type="text" name="local" id="local" value="<?= $id ? htmlentities($local) : "" ?>">
            </div>

            <div>
                <label for="surfhab">Surface habitable: </label>
                <input type="text" name="surfhab" id="surfhab" value="<?= $id ? htmlentities($surf_hab) : "" ?>">m²
            </div>

            <div>
                <label for="surftot">Surface totale: </label>
                <input type="text" name="surftot" id="surftot" value="<?= $id ? htmlentities($surf_tot) : "" ?>">m²
            </div>

            <div>
                <label for="diagnostic">Diagnostic: </label>
                <input type="text" name="diagnostic" id="diagnostic" value="<?= $id ? htmlentities($diagnostic) : "" ?>">
            </div>

            <div>
                <label for="typeBien">Type de bien</label>
                <select name="typeBien" id="typeBien">
                    <?php foreach ($typeBien as $type): ?>
                        <option value="<?= $type['tb_id'] ?>" <?= (isset($annonce['tb_id']) && $annonce['tb_id'] == $type['tb_id']) ? 'selected' : '' ?>>
                            <?= htmlentities($type['tb_libelle']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div>
                <label for="options">Options: </label>
                <?php foreach ($options as $option): ?>
                    <div>
                        <input type="checkbox" id="<?= $option['opt_id'] ?>" name="<?= $option['opt_id'] ?>">
                        <?= htmlentities($option['opt_libelle']) ?>
                        </input>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer" ?></button>
        <a href="index.php" class="btn btn-info">Retour</a>
    </form>
</div>

<?php
if ($id_annonce !== null) {
    $stmt = $pdo->prepare("UPDATE waz_annonces SET an_d_modif = NOW() WHERE an_id = ?");
    $stmt->execute([$annonce['an_id']]);
}

// TODO : ajouter une date modification via NOW() si première modification, update la date si deuxième ou +, date ajout si nouveau.
// 
// $pdo->exec($sqlModif);
include("footer.php");
?>