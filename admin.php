<?php
require_once __DIR__ . '/config/database.php';

if (empty($_SESSION['admin'])) {
    redirect('login.php');
}

$clients = [];
$error = '';

try {
    $pdo = getPDO();
    createClientsTable($pdo);

    // Supprimer un client
    if (isset($_GET['delete'])) {
        $id = (int) $_GET['delete'];

        $stmt = $pdo->prepare("DELETE FROM clients WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);

        redirect('admin.php');
    }

    $stmt = $pdo->query('SELECT id, nom_complet, age, date_envoi FROM clients ORDER BY date_envoi DESC, id DESC');
    $clients = $stmt->fetchAll();

} catch (Throwable $e) {
    $error = 'Impossible de charger les clients. Vérifie la base de données.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<main class="page">
    <section class="card admin-card">

        <div class="admin-header">
            <div>
                <div class="badge">Administration</div>
                <h1>Clients reçus</h1>
                <p class="subtitle">Total : <?= count($clients) ?> client(s)</p>
            </div>

            <a class="logout" href="logout.php">Déconnexion</a>
        </div>

        <?php if ($error): ?>
            <div class="alert error"><?= e($error) ?></div>
        <?php endif; ?>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom complet</th>
                        <th>Âge</th>
                        <th>Date / Heure</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!$clients): ?>
                    <tr>
                        <td colspan="5" class="empty">
                            Aucun client pour le moment.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($clients as $client): ?>

                    <tr>
                        <td><?= e($client['id']) ?></td>
                        <td><?= e($client['nom_complet']) ?></td>
                        <td><?= e($client['age']) ?></td>
                        <td><?= e($client['date_envoi']) ?></td>

                        <td>
                            <a
                                href="admin.php?delete=<?= $client['id'] ?>"
                                onclick="return confirm('Supprimer ce client ?');"
                                style="
                                    background:#dc2626;
                                    color:white;
                                    padding:8px 14px;
                                    border-radius:8px;
                                    text-decoration:none;
                                    font-weight:bold;
                                ">
                                🗑️ Supprimer
                            </a>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    </section>
</main>

</body>
</html>