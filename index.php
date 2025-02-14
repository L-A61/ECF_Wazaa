<?php
    include("header.php");
    // Affiche toutes les annonces si l'utilisateur est admin ou employée, sinon n'affiche que les annonces activées
    if ($isAdminOrEmployee) {
        $sql = "SELECT * FROM waz_annonces a JOIN waz_type_bien tb ON a.tb_id = tb.tb_id";
    } else {
        $sql = "SELECT * FROM waz_annonces a JOIN waz_type_bien tb ON a.tb_id = tb.tb_id WHERE a.an_statut = 1";
    }
    $annonces = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // Si l'URL contient "unlist", on prépare une requête SQL de l'ID
    if (isset($_GET['unlist'])) {
        $unlist_id = $_GET['unlist'];
        $stmt = $pdo->prepare("SELECT an_id FROM waz_annonces WHERE an_id = ?");
        $stmt->execute([$unlist_id]);
        $annonce = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Si l'annonce existe, on met à jour la colonne an_statut à 0 (soit false) de l'ID sélectionné
        if ($annonce) {
            $stmt = $pdo->prepare("UPDATE waz_annonces SET an_statut = ? WHERE an_id = ?");
            $stmt->execute([0, $unlist_id]);
        } else {
            echo "Erreur";
        }
        header('Location: index.php');
        exit;
    }

    // Si l'URL contient "relist", on prépare une requête SQL de l'ID
    if (isset($_GET['relist'])) {
        $relist_id = $_GET['relist'];
        $stmt = $pdo->prepare("SELECT an_id FROM waz_annonces WHERE an_id = ?");
        $stmt->execute([$relist_id]);
        $annonce = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Si l'annonce existe, on met à jour la colonne an_statut à 1 (soit true) de l'ID sélectionné
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

    <!-- Affichage des annonces -->
    <div class="column w-50 p-3">

        <!-- Si l'utilisateur est admin ou employé, le bouton pour publier une annonce s'affiche -->
        <?php if($isAdminOrEmployee):?>
            <a href="annonce-select.php" class="btn btn-success">Publier une annonce</a>
        <?php endif;?>
        <?php if (count($annonces) > 0): ?>
            <?php foreach($annonces as $annonce):?>

                <!-- Si l'utilisateur est admin ou employé, le bouton pour modifier une annonce s'affiche -->
                <?php if ($isAdminOrEmployee):?>
                    <a href="annonce-select.php?modify=<?= $annonce['an_id']?>" class="btn btn-warning">Modifier</a>
                <?php endif;?>
                
                <!-- Si l'utilisateur est admin le bouton pour désactiver ou activer une annonce s'affiche selon si l'annonce est activé ou désactivé -->
                <?php if ($isAdmin && $annonce['an_statut'] == 1):?>
                    <a href="index.php?unlist=<?= $annonce['an_id']?>" class="btn btn-danger">Désactiver</a>
                    <!--TODO: else if isAdminOrEmployee && an_satut == 0, bouton activer--> 
                <?php elseif($isAdmin && $annonce['an_statut'] == 0):?>
                    <a href="index.php?relist=<?= $annonce['an_id']?>" class="btn btn-danger">Activer</a>
                <?php endif;?>
                
                
                <div class="card">
                    <!-- Affiche la première image contenu dans le dossier appartenant à l'annonce -->
                    <div>
                        <img src="assets/photos/annonce_<?= htmlentities($annonce['an_id'])?>/<?= htmlentities($annonce['an_id'])?>-1.jpg" alt="" class="img-thumbnail">
                    </div>

                    <!--Informations pertinentes en priorités avec bouton info-->
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