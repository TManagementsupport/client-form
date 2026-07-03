<?php
require_once __DIR__ . '/config/bootstrap.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $adminUser = env_value('ADMIN_USER', 'admin');
    $adminPass = env_value('ADMIN_PASS', 'change-moi-123');

    if (hash_equals($adminUser, $username) && hash_equals($adminPass, $password)) {
        $_SESSION['admin'] = true;
        redirect('admin.php');
    }

    $error = 'Identifiants incorrects.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<main class="page">
    <section class="card form-card">
        <div class="badge">Espace admin</div>
        <h1>Connexion</h1>
        <p class="subtitle">Connecte-toi pour voir les clients.</p>

        <?php if ($error): ?>
            <div class="alert error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Nom d'utilisateur</label>
            <input id="username" type="text" name="username" required>

            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>
        <a class="link" href="index.php">Retour au formulaire</a>
    </section>
</main>
</body>
</html>
