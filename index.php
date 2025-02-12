<?php
    include("header.php");

    $sql = "SELECT * FROM waz_annonces a JOIN waz_type_annonce ta ON a.ta_id = ta.ta_id";

    $annonces = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<div>
    <h1>Nos annonces</h1>

    <div class="row">
        <?php if (count($annonces) > 0): ?>
            <?php foreach($annonces as $annonce):?>
                <div>
                    <h3><?= htmlentities($annonce['an_titre'])?></h3>
                    <p>Description: <?= htmlentities($annonce['an_description'])?></h4>
                    <p>Type d'offre: <?= htmlentities($annonce['an_offre'])?></p>
                    <p>Type de bien: <?= htmlentities($annonce['ta_libelle'])?></p>
                    <p>Nombre de pièces: <?= htmlentities($annonce['an_pieces'])?></p>
                    <p>Référence: <?= htmlentities($annonce['an_ref'])?></p>
                    <p>Surface habitable: <?= htmlentities($annonce['an_surf_hab'])?>m²</p>
                    <p>Surface totale: <?= htmlentities($annonce['an_surf_tot'])?>m²</p>
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