<?php
session_start();
require_once 'fonctions/fonction.php';
$pdo = connecter();

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM SOIGNEUR WHERE idS = :id");
$stmt->execute([':id' => $id]);
// ou on met supprimerSoigneur($pdo, $id);

header('Location: Gestion_soigneur.php?succes=supprime');
exit;
?>