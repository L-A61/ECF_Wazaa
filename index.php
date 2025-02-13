<?php
    include("header.php");

    if ($isAdminOrEmployee) {
        $sql = "SELECT * FROM waz_annonces a JOIN waz_type_bien tb ON a.tb_id = tb.tb_id";
    } else {
        $sql = "SELECT * FROM waz_annonces a JOIN waz_type_bien tb ON a.tb_id = tb.tb_id WHERE a.an_statut = 1";
    }

    $annonces = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_SESSION['utilisateur_ID'])) {
        header("Location: contact.php");
        exit();
    }

    if (isset($_GET['unlist'])) {
        $unlist_id = $_GET['unlist'];
        $stmt = $pdo->prepare("SELECT an_id FROM waz_annonces WHERE an_id = ?");
        $stmt->execute([$unlist_id]);
        $annonce = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($annonce) {
            $stmt = $pdo->prepare("UPDATE waz_annonces SET an_statut = ? WHERE an_id = ?");
            $stmt->execute([0, $unlist_id]);
        } else {
            echo "Erreur";
        }
        header('Location: index.php');
        exit;
    }

    if (isset($_GET['relist'])) {
        $relist_id = $_GET['relist'];
        $stmt = $pdo->prepare("SELECT an_id FROM waz_annonces WHERE an_id = ?");
        $stmt->execute([$relist_id]);
        $annonce = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if ($annonce) {
            $stmt = $pdo->prepare("UPDATE waz_annonces SET an_statut = ? WHERE an_id = ?");
            $stmt->execute([1, $relist_id]);
        } else {
            echo "Erreur";
        }
        header('Location: index.php');
        exit;
    }
?>

<div>
    <h1>Nos annonces</h1>

    <div class="column w-50 p-3">
        <?php if($isAdminOrEmployee):?>
            <a href="annonce-select.php" class="btn btn-success">Publier une annonce</a>
        <?php endif;?>
        <?php if (count($annonces) > 0): ?>
            <?php foreach($annonces as $annonce):?>
                <?php if ($isAdminOrEmployee):?>
                    <a href="annonce-select.php?modify=<?= $annonce['an_id']?>" class="btn btn-warning">Modifier</a>
                <?php endif;?>
                <?php if ($isAdmin && $annonce['an_statut'] == 1):?>
                    <a href="index.php?unlist=<?= $annonce['an_id']?>" class="btn btn-danger">Désactiver</a>
                    <!--TODO: else if isAdminOrEmployee && an_satut == 0, bouton activer--> 
                <?php elseif($isAdmin && $annonce['an_statut'] == 0):?>
                    <a href="index.php?relist=<?= $annonce['an_id']?>" class="btn btn-danger">Activer</a>
                <?php endif;?>
                
                <div class="card">
                    <div>
                        <img src="assets/photos/annonce_<?= htmlentities($annonce['an_id'])?>/<?= htmlentities($annonce['an_id'])?>-1.jpg" alt="" class="img-thumbnail">
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