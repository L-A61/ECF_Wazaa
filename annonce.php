<?php
include("header.php");

// Récupération dans l'url de l'id de l'annonce et requête préparé SQL
$id = isset($_GET['info']) ? $_GET['info'] : '';
$stmt = $pdo->prepare("SELECT * FROM waz_annonces a JOIN waz_type_bien tb ON a.tb_id = tb.tb_id 
JOIN waz_type_offre o ON a.to_id = o.to_id
WHERE an_id = ?");
$stmt->execute([$id]);
$annonce = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Requête prépare pour les photos
$stmtPhotos = $pdo->prepare("SELECT * FROM waz_photos WHERE an_id = ?");
$stmtPhotos->execute([$id]);
$photos = $stmtPhotos->fetchAll(PDO::FETCH_ASSOC);

// Requête préparé pour les types d'offres
$stmtOffre = $pdo->prepare("SELECT * FROM waz_type_offre");
$stmtOffre->execute();
$typeOffre = $stmtOffre->fetchAll(PDO::FETCH_ASSOC);

// Requête préparé pour les options dans les annonces
$stmtOptionsAn = $pdo->prepare("SELECT * FROM waz_opt_annonces");
$stmtOptionsAn->execute();
$optionsAn = $stmtOptionsAn->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if(count($annonce) > 0):?>
<?php foreach ($annonce as $annonceValue): ?>
    <?php foreach($photos as $photo):?>
        <img src="assets/photos/annonce_<?= htmlentities($photo['an_id'])?>/<?= htmlentities($photo['pht_libelle'])?>" alt="" class="row w-50 p-3">
    <?php endforeach;?>

    <h4><?= htmlentities($annonceValue['an_titre']) ?></h4>
        <p>Publié le: <?= htmlentities($annonceValue['an_d_ajout']) ?></p>
        <?php if ($annonceValue['an_d_modif']): ?>
            <p>Dernière modification le: <?= htmlentities($annonceValue['an_d_modif']) ?></p>
        <?php endif; ?>
        <p>Description: <?= htmlentities($annonceValue['an_description']) ?>
    </h4>
    <p>Prix: <?= htmlentities($annonceValue['an_prix']) ?>€</p>
    <p>Type de bien: <?= htmlentities($annonceValue['tb_libelle']) ?></p>
    <p>Référence: <?= htmlentities($annonceValue['an_ref']) ?></p>
    <p>Surface habitable: <?= htmlentities($annonceValue['an_surf_hab']) ?>m²</p>
    <p>Surface totale: <?= htmlentities($annonceValue['an_surf_tot']) ?>m²</p>
    <p>Type d'offre: <?= htmlentities($annonceValue['to_libelle']) ?></p>
    <p>Diagnostic: <?= htmlentities($annonceValue['an_diagnostic']) ?></p>
    <p>Vue: <?= htmlentities($annonceValue['an_vues']) ?></p>
    <a href="index.php" class="btn btn-info">Retour</a>
    <a href="contact.php?annonce=<?= htmlentities($annonceValue['an_id'])?>" class="btn btn-success">Contacter</a>
<?php endforeach; ?>
<?php else:?>
    <p>Annonce introuvable</p>
<?php endif;?>

<?php
    // Incrémente la valeur de la colonne an_vue de l'annonce associée à l'id pour chaqe visite
    $stmtVue = $pdo->prepare("UPDATE waz_annonces SET an_vues = an_vues+1 WHERE an_id = ?");
    $stmtVue->execute([$id]);
    include("footer.php");
?>