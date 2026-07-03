<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$nomComplet = trim($_POST['nom_complet'] ?? '');
$age = trim($_POST['age'] ?? '');

if ($nomComplet === '' || $age === '') {
    redirect('index.php?error=' . urlencode('Veuillez remplir tous les champs.'));
}

try {
    $pdo = getPDO();
    createClientsTable($pdo);

    $stmt = $pdo->prepare('INSERT INTO clients (nom_complet, age) VALUES (:nom_complet, :age)');
    $stmt->execute([
        ':nom_complet' => $nomComplet,
        ':age' => $age,
    ]);

    $emailSent = sendClientEmail($nomComplet, $age);

    redirect('index.php?success=1&email=' . ($emailSent ? '1' : '0'));
} catch (Throwable $e) {
    redirect('index.php?error=' . urlencode('Impossible d’enregistrer les informations. Vérifie la base de données.'));
}