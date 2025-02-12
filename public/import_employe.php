<?php

// Connexion à la base de données
$host = 'localhost';
$dbname = 'bk_food_copie';
$username = 'root';
$password = '';

// Chemin du nouveau fichier CSV
$file_path = "C:\\Users\\chofar\\Desktop\\bk_food_pack\\importation_employe_2025.csv";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");

    echo "✅ Connexion réussie.<br>";

    if (!file_exists($file_path)) {
        die("❌ Fichier non trouvé : " . $file_path);
    }

    if (($handle = fopen($file_path, "r")) === FALSE) {
        die("❌ Impossible d'ouvrir le fichier.");
    }

    // Lire la première ligne (en-tête)
    $first_line = fgets($handle);
    if (substr($first_line, 0, 3) === "\xEF\xBB\xBF") {
        $first_line = substr($first_line, 3); // Supprime le BOM si présent
    }

    // Convertir l'en-tête en tableau
    $header = str_getcsv($first_line, ",");

    if ($header === FALSE || empty($header)) {
        die("❌ Impossible de lire l'en-tête du fichier.");
    }

    // Nettoyer les noms des colonnes
    $header = array_map(function($value) {
        return trim($value, ' "'); // Supprime guillemets et espaces
    }, $header);

    // En-tête attendu
    $expected_columns = ["MLE", "Nom", "Prenom", "Zone_geographique", "Site", "Direction", "N+1", "Affectation"];

    if ($header !== $expected_columns) {
        echo "❌ L'entête du fichier ne correspond pas aux colonnes attendues !<br>";
        echo "En-tête du fichier : " . implode(", ", $header) . "<br>";
        echo "En-tête attendue : " . implode(", ", $expected_columns) . "<br>";
        die();
    }

    // Préparer la requête SQL avec UPSERT
    $stmt = $pdo->prepare("
        INSERT INTO employes (MLE, Nom, Prenom, Zone_geographique, Site, Direction, `N+1`, Affectation)
        VALUES (:MLE, :Nom, :Prenom, :Zone_geographique, :Site, :Direction, :N1, :Affectation)
        ON DUPLICATE KEY UPDATE 
            Nom = VALUES(Nom),
            Prenom = VALUES(Prenom),
            Zone_geographique = VALUES(Zone_geographique),
            Site = VALUES(Site),
            Direction = VALUES(Direction),
            `N+1` = VALUES(`N+1`),
            Affectation = VALUES(Affectation)
    ");

    $rowNumber = 1;
    $successCount = 0;

    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $rowNumber++;

        if (count($data) < 8) {
            echo "⚠️ Ligne $rowNumber ignorée : nombre de colonnes incorrect (" . count($data) . ")<br>";
            continue;
        }

        // Nettoyer les valeurs et gérer l'encodage
        $data = array_map(function($value) {
            $value = trim($value, ' "');
            return mb_convert_encoding($value, 'UTF-8', 'auto');
        }, $data);

        try {
            $stmt->execute([
                ':MLE' => $data[0],
                ':Nom' => $data[1],
                ':Prenom' => $data[2],
                ':Zone_geographique' => $data[3],
                ':Site' => $data[4],
                ':Direction' => $data[5],
                ':N1' => $data[6],
                ':Affectation' => $data[7]
            ]);
            $successCount++;
            echo "✅ Importé : {$data[1]} {$data[2]} (MLE: {$data[0]})<br>";
        } catch (Exception $e) {
            echo "❌ Erreur à la ligne $rowNumber : " . $e->getMessage() . "<br>";
            echo "Données : " . implode(", ", $data) . "<br>";
        }
    }

    fclose($handle);
    echo "✅ Importation terminée. $successCount lignes insérées/mises à jour.";

} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
?>