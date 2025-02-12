<?php
    include("header.php");

    $sql = "SELECT * FROM waz_annonces a JOIN waz_type_bien tb ON a.tb_id = tb.tb_id";

    $annonces = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<div>
    <h1>Nos annonces</h1>

    <div class="column">
        <a href="" class="btn btn-success">Publier une annonce</a>
        <?php if (count($annonces) > 0): ?>
            <?php foreach($annonces as $annonce):?>
                
                <div class="card">
                    <div>
                        <img src="assets/photos/annonce_<?= htmlentities($annonce['an_id'])?>/<?= htmlentities($annonce['an_id'])?>-1.jpg" alt="">
                    </div>
                    <h4><?= htmlentities($annonce['an_titre'])?></h3>
                    <p>Publié le: <?= htmlentities($annonce['an_d_ajout'])?></p>
                    <?php if($annonce['an_d_modif']):?>
                        <p>Dernière modification le: <?= htmlentities($annonce['an_d_modif'])?></p>
                    <?php endif;?>
                    <p>Description: <?= htmlentities($annonce['an_description'])?></h4>
                    <p>Prix: <?= htmlentities($annonce['an_prix'])?>€</p>
                    <p>Type de bien: <?= htmlentities($annonce['tb_libelle'])?></p>
                    <a href="annonce.php?info=<?= $annonce['an_id']?>" class="btn btn-info">Détails</a>
                    <!--TODO: if isAdminOrEmployee-->
                    <a href="" class="btn btn-warning">Modifier</a>
                    <!--TODO: if isAdminOrEmployee-->
                    <a href="" class="btn btn-danger">Désactiver</a>
                </div>
            <?php endforeach; ?>
        <?php else:?>
            <div>Aucune annonce disponible</div>
        <?php endif;?>
    </div>
</div>


<?php
    include("footer.php");
?>

<!-- <p>Nombre de pièces: <?= htmlentities($annonce['an_pieces'])?></p>
                    <p>Référence: <?= htmlentities($annonce['an_ref'])?></p>
                    <p>Surface habitable: <?= htmlentities($annonce['an_surf_hab'])?>m²</p>
                    <p>Surface totale: <?= htmlentities($annonce['an_surf_tot'])?>m²</p>
                    <p>Type d'offre: <?= htmlentities($annonce['an_offre'])?></p>
                    <p>Vue: <?= htmlentities($annonce['an_vues'])?></p>
                    <p>Diagnostic: <?= htmlentities($annonce['an_diagnostic'])?></p> -->