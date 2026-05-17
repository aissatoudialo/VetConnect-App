<?php
session_start();
require_once 'fonctions/fonction.php';
$pdo = connecter();

$cliniques    = $pdo->query("SELECT idC, nomC FROM CLINIQUE ORDER BY nomC")->fetchAll(PDO::FETCH_ASSOC);
$utilisateurs = $pdo->query("SELECT idU, pseudo FROM UTILISATEUR WHERE roleU = 'soigneur' ORDER BY pseudo")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ajouterSoigneur($pdo, $_POST);
    header('Location: Gestion_soigneur.php?succes=ajoute');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VetConnect - Ajouter un Soigneur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <li class="nav-item"><a class="nav-link" href="Gestion_contrat.php"><i class="fas fa-file-contract me-2"></i> Contrats</a></li>
                <li class="nav-item"><a class="nav-link active" href="Gestion_soigneur.php"><i class="fas fa-user-md me-2"></i> Soigneurs</a></li>
                <li class="nav-item"><a class="nav-link" href="Gestion_enclos.php"><i class="fas fa-border-all me-2"></i> Enclos</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-sliders-h me-2"></i> Configuration Seuils</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-database me-2"></i> Statistiques Globales</a></li>
                <li class="nav-item mt-3"><a class="nav-link text-danger" href="deconnexion.php"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a></li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 main-content">
            <div class="mb-3 pt-3">
                <a href="Gestion_soigneur.php" class="text-decoration-none text-muted mb-2 d-inline-block">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
                <h2 class="fw-bold">Ajouter un soigneur</h2>
                <p class="text-muted">Remplissez les informations pour enregistrer un nouveau soigneur.</p>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <form action="ajouterSoigneur.php" method="POST">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <label class="form-label fw-bold">idS</label>
                            <input type="text" class="form-control bg-light" placeholder="AUTO" disabled>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label for="nomS" class="form-label fw-bold">Nom du soigneur</label>
                            <input type="text" class="form-control" id="nomS" name="nomS" placeholder="Ex: Dupont" required>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label for="prenomS" class="form-label fw-bold">Prénom du soigneur</label>
                            <input type="text" class="form-control" id="prenomS" name="prenomS" placeholder="Ex: Jean" required>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label for="specialite" class="form-label fw-bold">Spécialité du soigneur</label>
                            <input type="text" class="form-control" id="specialite" name="specialite" placeholder="Ex: Chirurgie, Dermatologie..." required>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label for="role" class="form-label fw-bold">Rôle du soigneur</label>
                            <input type="text" class="form-control" id="role" name="role" placeholder="Ex: Soigneur principal, Assistant..." required>
                        </div>

                        <!-- Utilisateur depuis la BDD -->
                        <div class="col-md-5 mb-2">
                            <label for="idU" class="form-label fw-bold">Utilisateur associé</label>
                            <select class="form-select" id="idU" name="idU" required>
                                <option value="" disabled selected>Choisir...</option>
                                <?php foreach ($utilisateurs as $u): ?>
                                    <option value="<?= $u['idU'] ?>"><?= htmlspecialchars($u['pseudo']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Clinique depuis la BDD -->
                        <div class="col-md-5 mb-2">
                            <label for="idC" class="form-label fw-bold">Clinique associée</label>
                            <select class="form-select" id="idC" name="idC" required>
                                <option value="" disabled selected>Choisir...</option>
                                <?php foreach ($cliniques as $cl): ?>
                                    <option value="<?= $cl['idC'] ?>"><?= htmlspecialchars($cl['nomC']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="Gestion_soigneur.php" class="btn btn-outline-secondary px-4">Annuler</a>
                        <button type="submit" class="btn btn-add px-4">Enregistrer le soigneur</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>