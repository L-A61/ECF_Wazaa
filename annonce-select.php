<?php
include("header.php");

$id = isset($_GET['modify']) ? $_GET['modify'] : '';
$id_annonce = null;

$options = [];
$options = $pdo->query("SELECT * from waz_options")->fetchAll();

// $optionsAn = [];
// $optionsAn = $pdo->query("SELECT * FROM waz_opt_annonces")->fetchAll();

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
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $ref = $_POST['ref'];
    $local = $_POST['local'];
    $surf_hab = $_POST['surfhab'];
    $surf_tot = $_POST['surftot'];
    $diagnostic = $_POST['diagnostic'];

    if($id_annonce !== null) {
        $stmt = $pdo->prepare("UPDATE waz_annonces SET an_titre = ?, an_description = ?, an_prix = ?, an_ref = ?, an_local = ?, an_surf_hab = ?, an_surf_tot = ?, an_diagnostic = ? WHERE an_id = ?");
        $stmt->execute([$titre, $description, $prix, $ref, $local, $surf_hab, $surf_tot, $diagnostic, $annonce['an_id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO waz_annonces (an_titre, an_description, an_prix, an_ref, an_local, an_surf_hab, an_surf_tot, an_diagnostic, an_d_ajout) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$titre, $description, $prix, $ref, $local, $surf_hab, $surf_tot, $diagnostic]);
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
                
            </div>
                <label for="options">Options: </label>
                <?php foreach($options as $option):?>
                    <div>
                        <input type="checkbox" id="<?= $option['opt_id']?>" name="<?= $option['opt_id']?>">
                            <?= htmlentities($option['opt_libelle'])?>
                        </input>
                    </div>
                <?php endforeach;?>
            </select>
        </div>
        <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer"?></button>
        <a href="index.php" class="btn btn-info">Retour</a>
    </form>
</div>

<?php
    if (empty($date_modification)) {
        $stmt = $pdo->prepare("UPDATE waz_annonces SET an_d_modif = NOW() WHERE an_id = ?");
        $stmt->execute([$annonce['an_id']]);
    } else {
        $stmt = $pdo->prepare("UPDATE waz_annonces SET an_d_modif = NOW() WHERE an_id = ?");
        $stmt->execute([$annonce['an_id']]);
    }
    // TODO : ajouter une date modification via NOW() si première modification, update la date si deuxième ou +, date ajout si nouveau.
    // 
    // $pdo->exec($sqlModif);
    include("footer.php");
?>