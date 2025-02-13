<?php
include("header.php");

$id = isset($_GET['info']) ? $_GET['info'] : '';
$sql = "SELECT * FROM waz_annonces a JOIN waz_type_bien tb ON a.tb_id = tb.tb_id WHERE an_id = '$id'";
$annonce = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sqlPhotos = "SELECT * FROM waz_photos WHERE an_id = '$id'";
$photos = $pdo->query($sqlPhotos)->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if(count($annonce) > 0):?>
<?php foreach ($annonce as $annonceValue): ?>
    <?php foreach($photos as $photo):?>
        <img src="assets/photos/annonce_<?= htmlentities($photo['an_id'])?>/<?= htmlentities($photo['pht_libelle'])?>" alt="">
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
    <p>Type d'offre: <?= htmlentities($annonceValue['an_offre']) ?></p>
    <p>Diagnostic: <?= htmlentities($annonceValue['an_diagnostic']) ?></p>
    <p>Vue: <?= htmlentities($annonceValue['an_vues']) ?></p>
    <a href="index.php" class="btn btn-info">Retour</a>
    <a href="contact.php" class="btn btn-success">Contacter</a>
<?php endforeach; ?>
<?php else:?>
    <p>Annonce introuvable</p>
<?php endif;?>

<?php
    $sqlVue = "UPDATE waz_annonces SET an_vues = an_vues+1 WHERE an_id = '$id'";
    $pdo->exec($sqlVue);
    include("footer.php");
?>