<?php
require_once 'connexion/db.php';

// =============================================
// CONNEXION
// =============================================

function connecter() {
    try {
        $pdo = new PDO(
            'mysql:host=' . SERVEUR . ';dbname=' . BD . ';charset=utf8',
            NOM,
            PASSE,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

// CONTRAT

function ajouterContrat($pdo, $data) {
    $stmt = $pdo->prepare("
        INSERT INTO CONTRAT (date_debutCo, date_finCo, conditions, frequence_paiement, nbrEnclos, date_signature, statutContrat, prix_unitaire, idC, idSo)
        VALUES (:date_debutCo, :date_finCo, :conditions, :frequence_paiement, :nbrEnclos, :date_signature, 'Actif', :prix_unitaire, :idC, :idSo)
    ");
    $stmt->execute([
        ':date_debutCo'       => $data['dateD'],
        ':date_finCo'         => $data['dateF'],
        ':conditions'         => $data['cond'],
        ':frequence_paiement' => $data['paie'],
        ':nbrEnclos'          => $data['enclos'],
        ':date_signature'     => $data['dateS'],
        ':prix_unitaire'      => $data['prix'],
        ':idC'                => $data['idC'],
        ':idSo'               => $data['idSo'],
    ]);
}

function modifierContrat($pdo, $data, $id) {
    $stmt = $pdo->prepare("
        UPDATE CONTRAT SET
            date_debutCo        = :dateD,
            date_finCo          = :dateF,
            conditions          = :cond,
            frequence_paiement  = :paie,
            nbrEnclos           = :enclos,
            date_signature      = :dateS,
            prix_unitaire       = :prix,
            idC                 = :idC,
            idSo                = :idSo
        WHERE idCo = :id
    ");
    $stmt->execute([
        ':dateD'  => $data['dateD'],
        ':dateF'  => $data['dateF'],
        ':cond'   => $data['cond'],
        ':paie'   => $data['paie'],
        ':enclos' => $data['enclos'],
        ':dateS'  => $data['dateS'],
        ':prix'   => $data['prix'],
        ':idC'    => $data['idC'],
        ':idSo'   => $data['idSo'],
        ':id'     => $id,
    ]);
}

// Tu ajouteras ici les autres fonctions au fur et à mesure :
// function modifierContrat(...)
// function supprimerContrat(...)
// function ajouterClinique(...)
// etc.
?>