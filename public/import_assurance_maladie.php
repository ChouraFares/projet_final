<?php

$host = 'localhost';
$dbname = 'bk_food_copie';
$username = 'root';
$password = '';

$file_path = 'C:\Users\chofar\Desktop\bk_food_pack\borderaux_application_web_importation.csv';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8");

    echo "Connexion réussie.<br>";

    if (!file_exists($file_path)) {
        die("Erreur : Fichier non trouvé à l'emplacement : $file_path");
    }

    if (($handle = fopen($file_path, "r")) === FALSE) {
        die("Erreur : Impossible d'ouvrir le fichier CSV.");
    }

    // Ignorer le BOM si présent
    if (ftell($handle) === 0) {
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }
    }

    // Lire la première ligne brute pour diagnostic
    $first_line = fgets($handle);
    echo "Première ligne brute : <pre>" . htmlspecialchars($first_line) . "</pre>";
    rewind($handle);

    // Lire l'en-tête avec fgetcsv
    $header = fgetcsv($handle, 1000, ",", '"');
    if ($header === false) {
        die("Erreur : Impossible de lire l'en-tête du CSV.");
    }

    $header = array_map(function($value) {
        return trim($value, " \t\n\r\0\x0B\"");
    }, $header);
    echo "En-tête initial : <pre>" . print_r($header, true) . "</pre>";

    // Si fgetcsv n’a pas séparé correctement, forcer la séparation
    if (count($header) === 1) {
        $header_string = $header[0];
        $header = explode('","', $header_string);
        $header[0] = trim($header[0], '"');
        $header[count($header) - 1] = trim($header[count($header) - 1], '"');
        echo "En-tête corrigé : <pre>" . print_r($header, true) . "</pre>";
    }

    // Vérifier les colonnes requises
    $required_columns = ['numero_borderaux', 'bulletin_numero', 'nom_adherent', 'date_de_soin', 'date_envoi'];
    foreach ($required_columns as $col) {
        if (!in_array($col, $header)) {
            die("Erreur : La colonne '$col' est manquante dans l'en-tête du CSV.");
        }
    }

    // Préparer la requête SQL
    $stmt = $pdo->prepare("
        INSERT INTO assurance_maladie (
            numero_borderaux, bulletin_numero, nom_adherent, date_de_soin, date_envoi, 
            matricule, status, reclamation
        ) VALUES (
            :numero_borderaux, :bulletin_numero, :nom_adherent, :date_de_soin, :date_envoi, 
            :matricule, :status, :reclamation
        )
    ");

    $row_count = 0;

    // Lire les lignes du CSV
    while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
        echo "Ligne lue brute : <pre>" . print_r($data, true) . "</pre>";

        // Si fgetcsv n’a pas séparé correctement, forcer la séparation
        if (count($data) === 1) {
            $data_string = $data[0];
            // Séparer d’abord la première colonne (sans guillemets)
            $first_split = explode(',', $data_string, 2);
            $first_column = $first_split[0]; // Ex: "25"
            $remaining = $first_split[1];    // Ex: "5854370","nawres hanafi ","3/7/2025","3/19/2025"

            // Séparer le reste avec les guillemets
            $remaining_columns = explode('","', $remaining);
            $remaining_columns[count($remaining_columns) - 1] = trim($remaining_columns[count($remaining_columns) - 1], '"');

            // Combiner les colonnes
            $data = array_merge([$first_column], $remaining_columns);
        }

        echo "Ligne corrigée : <pre>" . print_r($data, true) . "</pre>";

        if (count($data) !== count($header)) {
            echo "Ligne ignorée (nombre de colonnes incorrect : " . count($data) . " attendu : " . count($header) . ")<br>";
            continue;
        }

        $values = array_combine($header, array_map('trim', $data));

        $date_de_soin = !empty($values['date_de_soin']) 
            ? date('Y-m-d', strtotime($values['date_de_soin'])) 
            : null;
        $date_envoi = !empty($values['date_envoi']) 
            ? date('Y-m-d', strtotime($values['date_envoi'])) 
            : null;

        $matricule = 'N/A';
        $status = 'Non Remis';
        $reclamation = null;

        $stmt->execute([
            ':numero_borderaux' => $values['numero_borderaux'] ?? null,
            ':bulletin_numero'  => $values['bulletin_numero'] ?? null,
            ':nom_adherent'     => $values['nom_adherent'] ?? null,
            ':date_de_soin'     => $date_de_soin,
            ':date_envoi'       => $date_envoi,
            ':matricule'        => $matricule,
            ':status'           => $status,
            ':reclamation'      => $reclamation
        ]);

        $row_count++;
    }

    fclose($handle);
    echo "Importation terminée avec succès ! $row_count lignes importées.";

} catch (PDOException $e) {
    echo "Erreur de connexion ou d'exécution : " . $e->getMessage();
}
?>