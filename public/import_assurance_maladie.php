<?php

$host = 'localhost';
$dbname = 'bk_food';
$username = 'root';
$password = '';

$file_path = "C:\Users\chofar\Desktop\bk_food_pack\RECAP assurance maladie.csv";

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8");

    echo "Connexion réussie.<br>";

    // Vérification de l'existence du fichier
    if (!file_exists($file_path)) {
        die("Erreur : Fichier non trouvé à l'emplacement : $file_path");
    }

    // Normalisation du fichier
    $file_content = file_get_contents($file_path);
    $file_content = preg_replace('/^\xEF\xBB\xBF/', '', $file_content); // Supprimer BOM
    $file_content = str_replace(["\r\n", "\r"], "\n", $file_content); // Normaliser les fins de ligne
    $file_content = preg_replace('/""/', '"', $file_content); // Supprimer guillemets doubles
    
    // Créer un fichier temporaire nettoyé
    $cleaned_file = tempnam(sys_get_temp_dir(), 'csv_clean_');
    file_put_contents($cleaned_file, $file_content);

    if (($handle = fopen($cleaned_file, "r")) === FALSE) {
        die("Erreur : Impossible d'ouvrir le fichier CSV nettoyé.");
    }

    // Détection du délimiteur
    $first_line = fgets($handle);
    $delimiter = (strpos($first_line, ';') !== false) ? ';' : ',';
    rewind($handle);

    // Lecture de l'en-tête
    $header = fgetcsv($handle, 0, $delimiter, '"');
    if ($header === false || empty($header)) {
        die("Erreur : Impossible de lire l'en-tête du CSV ou en-tête vide.");
    }

    // Nettoyage de l'en-tête
    $header = array_map(function($value) {
        return trim($value, " \t\n\r\0\x0B\"'");
    }, $header);

    // Afficher l'en-tête pour débogage
    echo "<h3>En-tête détecté :</h3><pre>";
    print_r($header);
    echo "</pre>";

    // Vérification des colonnes requises
    $required_columns = ['numero_borderaux', 'bulletin_numero', 'nom_adherent', 'date_de_soin', 'date_envoi'];
    foreach ($required_columns as $col) {
        if (!in_array($col, $header)) {
            die("Erreur : La colonne '$col' est manquante dans l'en-tête du CSV.");
        }
    }

    // Préparation de la requête SQL (adaptée à votre table)
    $stmt = $pdo->prepare("
        INSERT INTO assurance_maladie (
            numero_borderaux, bulletin_numero, nom_adherent, date_de_soin, date_envoi
            /* Suppression des colonnes inexistantes : matricule, status, reclamation */
        ) VALUES (
            :numero_borderaux, :bulletin_numero, :nom_adherent, :date_de_soin, :date_envoi
        )
    ");

    $row_count = 0;
    $skipped_rows = 0;

    // Lecture des données
    while (($data = fgetcsv($handle, 0, $delimiter, '"')) !== FALSE) {
        // Ignorer les lignes vides
        if (count($data) === 1 && empty(trim($data[0]))) {
            continue;
        }

        // Vérification du nombre de colonnes
        if (count($data) !== count($header)) {
            echo "Ligne ignorée (nombre de colonnes incorrect : " . count($data) . " attendu : " . count($header) . ")<br>";
            $skipped_rows++;
            continue;
        }

        // Association des valeurs
        $values = array_combine($header, array_map('trim', $data));

        // Formatage des dates (adapté au format de votre fichier)
        try {
            $date_de_soin = !empty($values['date_de_soin']) 
                ? DateTime::createFromFormat('d/m/Y', $values['date_de_soin'])->format('Y-m-d')
                : null;
                
            $date_envoi = !empty($values['date_envoi']) 
                ? DateTime::createFromFormat('d/m/Y', $values['date_envoi'])->format('Y-m-d')
                : null;
        } catch (Exception $e) {
            echo "Erreur de format de date : " . $e->getMessage() . "<br>";
            $skipped_rows++;
            continue;
        }

        try {
            $stmt->execute([
                ':numero_borderaux' => $values['numero_borderaux'] ?? null,
                ':bulletin_numero'  => $values['bulletin_numero'] ?? null,
                ':nom_adherent'     => $values['nom_adherent'] ?? null,
                ':date_de_soin'     => $date_de_soin,
                ':date_envoi'       => $date_envoi
            ]);

            $row_count++;
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion : " . $e->getMessage() . "<br>";
            echo "Données problématiques : <pre>" . print_r($values, true) . "</pre>";
            $skipped_rows++;
        }
    }

    fclose($handle);
    unlink($cleaned_file); // Supprimer le fichier temporaire

    // Résumé
    echo "<h3>Résultat de l'importation :</h3>";
    echo "Lignes importées avec succès : $row_count<br>";
    echo "Lignes ignorées : $skipped_rows<br>";
    if ($row_count > 0) {
        echo "Importation terminée avec succès !";
    } else {
        echo "Aucune donnée n'a été importée. Vérifiez le format du fichier CSV.";
    }

} catch (PDOException $e) {
    echo "Erreur de connexion ou d'exécution : " . $e->getMessage();
} catch (Exception $e) {
    echo "Erreur générale : " . $e->getMessage();
}