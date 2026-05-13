<?php
session_start();
require_once 'fonctions/fonction.php';
$pdo = connecter();

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM CONTRAT WHERE idCo = :id");
$stmt->execute([':id' => $id]);

header('Location: Gestion_contrat.php?succes=supprime');
exit;
?>