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

// Quand on clique sur "Enregistrer"
if (isset($_POST["enregistrer"])) {

    $animal["nom"] = $_POST["nom"];
    $animal["espece"] = $_POST["espece"];
    $animal["age"] = $_POST["age"];
    $animal["date_entree"] = $_POST["date_entree"];
    $animal["date_sortie"] = $_POST["date_sortie"];
    $animal["soigneur"] = $_POST["soigneur"];

    echo "<p style='color:green;'>Modifications enregistrées !</p>";
}

?>

<form method="POST">

<table border="1" cellpadding="10">

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

<br>

<button type="submit" name="enregistrer">
    Enregistrer les modifications
</button>

</form>
