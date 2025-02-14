<?php
include("header.php");

// Si l'utilisateur n'est pas un admin ou un employé, redirection vers la page index.php
if (!$isAdminOrEmployee) {
    header("Location: index.php");
    exit;
}

$utilisateur = $_SESSION['u_id'];

// Récupération de modify dans l'URL
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
$stmtOptionsAn = $pdo->prepare("SELECT * FROM waz_opt_annonces");
$stmtOptionsAn->execute();
$optionsAn = $stmtOptionsAn->fetchAll(PDO::FETCH_ASSOC);

// Si l'id existe, on prépare une reqûete SQL qui retrouve les informations de l'annonce à partir de son id
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM waz_annonces a WHERE an_id = ?");
    $stmt->execute([$id]);
    $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'annonce existe, on insert les données dans des variables
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
        
        if ($optionsAn) {
            $id_options_annonces = $optionsAn['an_id'];
        }
        

    // Sinon, on informe que l'annonce est introuvable
    } else {
        echo "Annonce introuvable.";
        exit;
    }
}

// Récupération de la method post, informations insérer dans des variables
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

    // Mettre à jour avec ceci actif cause tout les options d'être sélectionnés et inscrit dans la bdd
    // $options = $_POST['options'];

    // Si l'annonce n'existe pas on traite le formulaire comme une publication d'annonce via requête SQL préparée
    if ($id_annonce !== null) {
        $stmt = $pdo->prepare("UPDATE waz_annonces SET an_titre = ?, an_pieces = ?, an_description = ?, an_prix = ?, an_ref = ?, an_local = ?, an_surf_hab = ?, an_surf_tot = ?, an_diagnostic = ?, tb_id = ?, to_id = ? WHERE an_id = ?");
        $stmt->execute([$titre, $pieces, $description, $prix, $ref, $local, $surf_hab, $surf_tot, $diagnostic, $type, $offre, $annonce['an_id']]);
    // Si l'annonce existe, on traite le formulaire comme une modification d'annonce via requête SQL préparée
    } else {
        $stmt = $pdo->prepare("INSERT INTO waz_annonces (an_titre, an_pieces, an_description, an_prix, an_ref, an_local, an_surf_hab, an_surf_tot, an_diagnostic, an_d_ajout, an_statut, tb_id, u_id, to_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1, ?, ?, ?)");
        $stmt->execute([$titre, $pieces, $description, $prix, $ref, $local, $surf_hab, $surf_tot, $diagnostic, $type, $utilisateur, $offre]);
    }

    // Si les options d'annonces sont déjà insérées, on met à jour les ids d'options selon l'id de l'annonce
    // if($id_options_annonces) {
    //      $stmt = $pdo->prepare("UPDATE waz_opt_annonces SET opt_id = ? WHERE an_id = ?");
    //      $stmt->execute([$options, $annonce['an_id']]);
    // Si les options d'annonces ne sont pas déjà insérées, on insère les ids d'options ainsi que l'id de l'annonce associé
    // } else {
    //      $stmt = $pdo->prepare("INSERT INTO waz_opt_annonces (opt_id, an_id) SELECT o.opt_id, a.an_id FROM waz_options o, waz_annonces a");
    //      $stmt->execute();
    // }

    header('Location:index.php');
    exit;
}

?>

<!-- Formulaire de Modification / Création selon si l'id existant est présent dans l'URL -->
<div>
    <h1><?= $id ? "Modification" : "Création" ?> de l'annonce</h1>

    <form method="post">
        <div>
            <div>
                <label for="titre">Titre de l'annonce: </label>
                <input type="text" name="titre" id="titre" value="<?= $id ? htmlentities($titre) : "" ?>">
            </div>

            <!-- Choix radio du type d'offre avec un foreach -->
            <div>
                <label for="offre">Type d'offre: </label>
                <?php foreach ($typeOffre as $type): ?>
                    <input type="radio" name="offre" value="<?= htmlentities($type['to_id']) ?>" <?= (isset($annonce['to_id']) && $annonce['to_id'] == $type['to_id']) ? 'checked' : '' ?>>
                    <?= htmlentities($type['to_libelle']) ?>
                <?php endforeach; ?>
            </div>
            
            <!-- Nombre de pièces -->
            <div>
                <label for="pieces">Nombre de pièces: </label>
                <input type="text" name="pieces" id="pieces" value="<?= $id ? htmlentities($pieces) : "" ?>">
            </div>
            
            <!-- Description de l'annonce -->
            <div>
                <label for="description">Description: </label>
                <input type="text" name="description" id="description" value="<?= $id ? htmlentities($description) : "" ?>">
            </div>

            <!-- Prix du bien -->
            <div>
                <label for="prix">Prix: </label>
                <input type="text" name="prix" id="prix" value="<?= $id ? htmlentities($prix) : "" ?>">€
            </div>
            
            <!-- Référencement -->
            <div>
                <label for="ref">Référencement: </label>
                <input type="text" name="ref" id="ref" value="<?= $id ? htmlentities($ref) : "" ?>">
            </div>
            
            <!-- Localisation -->
            <div>
                <label for="local">Localisation: </label>
                <input type="text" name="local" id="local" value="<?= $id ? htmlentities($local) : "" ?>">
            </div>
            
            <!-- Surface habitable -->
            <div>
                <label for="surfhab">Surface habitable: </label>
                <input type="text" name="surfhab" id="surfhab" value="<?= $id ? htmlentities($surf_hab) : "" ?>">m²
            </div>
            
            <!-- Surface totale -->
            <div>
                <label for="surftot">Surface totale: </label>
                <input type="text" name="surftot" id="surftot" value="<?= $id ? htmlentities($surf_tot) : "" ?>">m²
            </div>
            
            <!-- Diagnostic -->
            <div>
                <label for="diagnostic">Diagnostic: </label>
                <input type="text" name="diagnostic" id="diagnostic" value="<?= $id ? htmlentities($diagnostic) : "" ?>">
            </div>
            
            <!-- Type de bien via une liste déroulante -->
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
            
            <!-- Options via un foreach (La fonctionalité post ne fonctionne pas avec) 
            <div>
                <label for="options">Options: </label>
                <?php foreach ($options as $option): ?>
                    <div>
                        <input type="checkbox" id="<?= $option['opt_id'] ?>" name="options[]" value="<?= $option['opt_id'] ?>">
                        <?= htmlentities($option['opt_libelle']) ?>
                        </input>
                    </div>
                <?php endforeach; ?>
            </div>
            -->

        </div>
        <!-- Boutton pour mettre à jour ou créer selon si l'id existant est dans l'URL-->
        <button type="submit" class="btn btn-warning"><?= $id ? "Mettre à jour" : "Créer" ?></button>
        <a href="index.php" class="btn btn-info">Retour</a>
    </form>
</div>

<?php
// Si l'annonce existe on met à jour la date de modification de l'annonce associée à l'id
if ($id_annonce) {
    $stmt = $pdo->prepare("UPDATE waz_annonces SET an_d_modif = NOW() WHERE an_id = ?");
    $stmt->execute([$annonce['an_id']]);
}

include("footer.php");
?>