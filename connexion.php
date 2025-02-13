<?php

include("header.php");

if (isset($_SESSION['u_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM waz_utilisateur WHERE u_email = ?");
    $stmt->execute([$email]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur && password_verify($password, $utilisateur['u_password'])) {
        $_SESSION['u_id'] = $utilisateur['u_id'];

        $stmt = $pdo->prepare("SELECT * FROM waz_type_utilisateur WHERE tu_id = ?");
        $stmt->execute([$utilisateur['tu_id']]);
        $utilisateurType = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['tu_libelle'] = $utilisateurType['tu_libelle'];
        $_SESSION['logged_in'] = true;

        header("Location: index.php");
        exit();
    } else {
        $error = "Email ou mot de passe incorrect";
    }
}

?>
<div>
    <h1>Connexion</h1>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div>
            <input type="text" name="email" id="email" placeholder="Email...">
        </div>
        <div>
            <input type="password" name="password" id="password" placeholder="Mot de passe...">
        </div>
        <div>
            <button type="submit" class="btn btn-info">Connexion</button>
        </div>
    </form>
</div>



<?php

include("footer.php");

?>