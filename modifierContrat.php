<?php
session_start();
require_once 'fonctions/fonction.php';
$pdo = connecter();

// Récupérer le contrat à modifier
$id = $_GET['id'];
$contrat = $pdo->query("SELECT * FROM CONTRAT WHERE idCo = $id")->fetch(PDO::FETCH_ASSOC);

// Chargement des selects
$cliniques = $pdo->query("SELECT idC, nomC FROM CLINIQUE ORDER BY nomC")->fetchAll(PDO::FETCH_ASSOC);
$societes  = $pdo->query("SELECT idSo, nomSociete FROM SOCIETE")->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    modifierContrat($pdo, $_POST, $id);
    header('Location: Gestion_contrat.php?succes=modifie');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VetConnect - Modifier un Contrat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 sidebar shadow">
            <div class="text-center mb-4">
                <h4 class="fw-bold">VetConnect</h4>
                <small>Espace Admin</small>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="tableauBord.php"><i class="fas fa-home me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="Gestion_clinique.php"><i class="fas fa-hospital me-2"></i> Cliniques</a></li>
                <li class="nav-item"><a class="nav-link active" href="Gestion_contrat.php"><i class="fas fa-file-contract me-2"></i> Contrats</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user-md me-2"></i> Soigneurs</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-border-all me-2"></i> Enclos</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-sliders-h me-2"></i> Configuration Seuils</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-database me-2"></i> Statistiques Globales</a></li>
                <li class="nav-item mt-3"><a class="nav-link text-danger" href="deconnexion.php"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 main-content">
            <div class="mb-1 pt-1">
                <a href="Gestion_contrat.php" class="text-decoration-none text-muted mb-2 d-inline-block">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
                <h4 class="fw-bold">Modifier le contrat</h4>
                <p class="text-muted">Mettez à jour les informations du contrat sélectionné.</p>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <form action="modifierContrat.php?id=<?= $id ?>" method="POST">
                    <div class="row g-2">
                        <!-- idCo lecture seule -->
                        <div class="col-md-2 mb-2">
                            <label class="form-label fw-bold">idCo</label>
                            <input type="text" class="form-control bg-light" value="<?= $contrat['idCo'] ?>" readonly>
                        </div>

                        <!-- Clinique -->
                        <div class="col-md-5 mb-2">
                            <label for="idC" class="form-label fw-bold">Clinique</label>
                            <select class="form-select" id="idC" name="idC" required>
                                <?php foreach ($cliniques as $cl): ?>
                                    <option value="<?= $cl['idC'] ?>" <?= $cl['idC'] == $contrat['idC'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cl['nomC']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Société -->
                        <div class="col-md-5 mb-2">
                            <label for="idSo" class="form-label fw-bold">Société</label>
                            <select class="form-select" id="idSo" name="idSo" required>
                                <?php foreach ($societes as $so): ?>
                                    <option value="<?= $so['idSo'] ?>" <?= $so['idSo'] == $contrat['idSo'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($so['nomSociete']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="dateD" class="form-label fw-bold">Date début</label>
                            <input type="date" class="form-control" id="dateD" name="dateD" value="<?= $contrat['date_debutCo'] ?>" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="dateF" class="form-label fw-bold">Date fin</label>
                            <input type="date" class="form-control" id="dateF" name="dateF" value="<?= $contrat['date_finCo'] ?>" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="dateS" class="form-label fw-bold">Date signature</label>
                            <input type="date" class="form-control" id="dateS" name="dateS" value="<?= $contrat['date_signature'] ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-2">
                            <label for="cond" class="form-label fw-bold">Conditions</label>
                            <input type="text" class="form-control" id="cond" name="cond" value="<?= htmlspecialchars($contrat['conditions']) ?>">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="paie" class="form-label fw-bold">Paiement</label>
                            <select class="form-select" id="paie" name="paie" required>
                                <?php foreach (['Mensuel', 'Trimestriel', 'Annuel'] as $p): ?>
                                    <option value="<?= $p ?>" <?= $p == $contrat['frequence_paiement'] ? 'selected' : '' ?>><?= $p ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="enclos" class="form-label fw-bold">Enclos</label>
                            <input type="number" class="form-control" id="enclos" name="enclos" value="<?= $contrat['nbrEnclos'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="prix" class="form-label fw-bold">Prix (€)</label>
                            <input type="number" class="form-control" id="prix" name="prix" value="<?= $contrat['prix_unitaire'] ?>" required>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="Gestion_contrat.php" class="btn btn-outline-secondary px-4">Annuler</a>
                        <button type="submit" class="btn btn-add px-4">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>