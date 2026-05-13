<?php
session_start();
require_once 'fonctions/fonction.php';
$pdo = connecter();

$contrats = $pdo->query("
    SELECT c.*, cl.nomC, so.nomSociete
    FROM CONTRAT c
    JOIN CLINIQUE cl ON c.idC = cl.idC
    JOIN SOCIETE so  ON c.idSo = so.idSo
    ORDER BY c.idCo
")->fetchAll(PDO::FETCH_ASSOC);

$succes = $_GET['succes'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VetConnect - Gestion des Contrats</title>
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Gestion des Contrats</h2>
                <a href="ajouterContrat.php" class="btn btn-add">
                    <i class="fas fa-plus me-2"></i>Ajouter un contrat
                </a>
            </div>

            <?php if ($succes === 'ajoute'): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i> Contrat ajouté avec succès !
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if ($succes === 'supprime'): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-trash me-2"></i> Contrat supprimé.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card border-none shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">idCo</th>
                                <th>Clinique</th>
                                <th>Société</th>
                                <th>Date début</th>
                                <th>Date fin</th>
                                <th>Date signature</th>
                                <th>Conditions</th>
                                <th>Paiement</th>
                                <th>Enclos</th>
                                <th>Statut</th>
                                <th>Prix (€)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contrats as $c): ?>
                            <tr>
                                <td class="ps-4 text-muted fw-bold"><?= $c['idCo'] ?></td>
                                <td><?= htmlspecialchars($c['nomC']) ?></td>
                                <td><?= htmlspecialchars($c['nomSociete']) ?></td>
                                <td><?= $c['date_debutCo'] ?></td>
                                <td><?= $c['date_finCo'] ?></td>
                                <td><?= $c['date_signature'] ?></td>
                                <td><?= htmlspecialchars($c['conditions']) ?></td>
                                <td><?= htmlspecialchars($c['frequence_paiement']) ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $c['nbrEnclos'] ?></span></td>
                                <td><span class="badge <?= $c['statutContrat'] === 'Actif' ? 'bg-success' : 'bg-secondary' ?>"><?= $c['statutContrat'] ?></span></td>
                                <td class="fw-bold"><?= $c['prix_unitaire'] ?>€</td>
                                <td class="text-nowrap">
                                    <div class="d-flex gap-2">
                                        <a href="modifierContrat.php?id=<?= $c['idCo'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSuppression"
                                                data-id="<?= $c['idCo'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- Modal suppression -->
<div class="modal fade" id="modalSuppression" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                <p>Supprimer ce contrat ?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" id="btnSupprimer" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('modalSuppression').addEventListener('show.bs.modal', function(e) {
        const id = e.relatedTarget.getAttribute('data-id');
        document.getElementById('btnSupprimer').href = 'supprimerContrat.php?id=' + id;
    });
</script>

</body>
</html>