<?php

$host = "127.0.0.1";
$user = "phpmyadmin";
$pass = "tp";
$dbname = "vetconnect";

try {

   
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    $url = "http://192.168.4.1:8080/json.htm?type=devices&rid=15";
    $json = file_get_contents($url);

    if ($json === FALSE) {
        throw new Exception("Impossible de contacter l'API Domoticz");
    }

    $data = json_decode($json, true);

    if (!isset($data['result'][0])) {
        throw new Exception("Capteur non trouvé dans le JSON");
    }

    
    $status = $data['result'][0]['Status'];
    $lastUpdate = $data['result'][0]['LastUpdate'];
    $idOutil = 54;

  
    $date = date('Y-m-d', strtotime($lastUpdate));
    $heure = date('H:i:s', strtotime($lastUpdate));

    
    $sqlLast = "SELECT date_appuie, heure_appuie 
                FROM BOUTON 
                WHERE idO = :idO 
                ORDER BY idB DESC 
                LIMIT 1";

    $stmtLast = $db->prepare($sqlLast);
    $stmtLast->execute([':idO' => $idOutil]);

    $last = $stmtLast->fetch(PDO::FETCH_ASSOC);

 
    if ($status === "On") {

        $dernierEnregistre = $last 
            ? $last['date_appuie'] . ' ' . $last['heure_appuie'] 
            : null;

        if ($dernierEnregistre !== $lastUpdate) {

            $sql = "INSERT INTO BOUTON (date_appuie, heure_appuie, idO)
                    VALUES (:date_appuie, :heure_appuie, :idO)";

            $stmt = $db->prepare($sql);

            $stmt->execute([
                ':date_appuie' => $date,
                ':heure_appuie' => $heure,
                ':idO' => $idOutil
            ]);

            echo "Bouton appuyé enregistré à $date $heure" . PHP_EOL;

        } else {
            echo "Déjà enregistré (même timestamp)" . PHP_EOL;
        }

    } else {
        echo "Bouton non actif (Status = $status)" . PHP_EOL;
    }

} catch (PDOException $e) {

    echo "Erreur Base de données : " . $e->getMessage() . PHP_EOL;

} catch (Exception $e) {

    echo "Erreur : " . $e->getMessage() . PHP_EOL;
}

?>