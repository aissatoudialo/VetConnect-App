<?php

// Informations Animal
$animal = [
    "nom" => "Simba",
    "espece" => "Lion",
    "age" => "5 ans",
    "date_entree" => "10/05/2026",
    "date_sortie" => "15/05/2026",
    "soigneur" => "Jean Dupont"
];

// Vérifie si le bouton a été cliqué
if (isset($_POST["enregistrer"])) {

    // Mise à jour des données
    $animal["nom"] = $_POST["nom"];
    $animal["espece"] = $_POST["espece"];
    $animal["age"] = $_POST["age"];
    $animal["date_entree"] = $_POST["date_entree"];
    $animal["date_sortie"] = $_POST["date_sortie"];
    $animal["soigneur"] = $_POST["soigneur"];

    $message = "Modifications enregistrées avec succès !";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion Animal</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
        }

        table {
            border-collapse: collapse;
            width: 600px;
            background-color: white;
        }

        th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
        }

        td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        input {
            width: 95%;
            padding: 8px;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            color: green;
            margin-bottom: 15px;
            font-weight: bold;
        }

    </style>

</head>

<body>

    <h2>Informations de l'animal</h2>

    <?php
    if (isset($message)) {
        echo "<p class='message'>$message</p>";
    }
    ?>

    <form method="POST">

        <table>

            <tr>
                <th>Information</th>
                <th>Donnée</th>
            </tr>

            <tr>
                <td>Nom</td>
                <td>
                    <input type="text" name="nom" value="<?php echo $animal["nom"]; ?>">
                </td>
            </tr>

            <tr>
                <td>Espèce</td>
                <td>
                    <input type="text" name="espece" value="<?php echo $animal["espece"]; ?>">
                </td>
            </tr>

            <tr>
                <td>Âge</td>
                <td>
                    <input type="text" name="age" value="<?php echo $animal["age"]; ?>">
                </td>
            </tr>

            <tr>
                <td>Date d'entrée</td>
                <td>
                    <input type="text" name="date_entree" value="<?php echo $animal["date_entree"]; ?>">
                </td>
            </tr>

            <tr>
                <td>Date de sortie</td>
                <td>
                    <input type="text" name="date_sortie" value="<?php echo $animal["date_sortie"]; ?>">
                </td>
            </tr>

            <tr>
                <td>Soigneur Responsable</td>
                <td>
                    <input type="text" name="soigneur" value="<?php echo $animal["soigneur"]; ?>">
                </td>
            </tr>

        </table>

        <button type="submit" name="enregistrer">
            Enregistrer les modifications
        </button>

    </form>

</body>

</html>
