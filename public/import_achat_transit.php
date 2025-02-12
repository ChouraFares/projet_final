<?php

// Database connection details
$host = 'localhost';
$dbname = 'bk_food';
$username = 'root';
$password = '';

// CSV file path
$file_path = 'C:\Users\chofar\Desktop\bk_food_pack\base_thon_csv_import.csv';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8");

    echo "Connected successfully.<br>";

    // Vérifier si le fichier existe
    if (file_exists($file_path)) {
        if (($handle = fopen($file_path, "r")) !== FALSE) {
            // Lire la première ligne pour récupérer les noms des colonnes
            $header = fgetcsv($handle, 1000, ",");
            if ($header === false) {
                die("Erreur: Impossible de lire l'en-tête du CSV.");
            }

            // Nettoyer les noms des colonnes
            $header = array_map('trim', $header);

            // Vérifier que les colonnes essentielles existent
            $required_columns = ['facture', 'num_conteneur', 'BL'];
            foreach ($required_columns as $col) {
                if (!in_array($col, $header)) {
                    die("Erreur: La colonne '$col' est manquante dans l'en-tête du CSV.");
                }
            }

            // Préparer la requête d'insertion SQL
            $stmt = $pdo->prepare("
                INSERT INTO facture_complimentaire_thon (
                    facture, num_conteneur, fournisseur, incoterm, armateur, port, bank, 
                    date_declaration, assureur, date_expiration, BL
                ) VALUES (
                    :facture, :num_conteneur, :fournisseur, :incoterm, :armateur, :port, :bank, 
                    :date_declaration, :assureur, :date_expiration, :BL
                )
            ");

            // Compteur pour suivre les lignes importées
            $row_count = 0;

            // Lire chaque ligne du fichier CSV
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // S'assurer que le nombre de colonnes correspond
                if (count($data) !== count($header)) {
                    echo "Ligne ignorée (nombre de colonnes incorrect: " . count($data) . " attendu: " . count($header) . ")<br>";
                    continue;
                }

                // Associer les valeurs aux colonnes
                $values = array_combine($header, array_map('trim', $data));

                // Convertir les dates au format MySQL (YYYY-MM-DD)
                $date_declaration = !empty($values['date_declaration']) 
                    ? date('Y-m-d', strtotime($values['date_declaration'])) 
                    : null;
                $date_expiration = !empty($values['date_expiration']) 
                    ? date('Y-m-d', strtotime($values['date_expiration'])) 
                    : null;

                // Exécuter l'insertion
                $stmt->execute([
                    ':facture'         => $values['facture'] ?? null,
                    ':num_conteneur'   => $values['num_conteneur'] ?? null,
                    ':fournisseur'     => $values['fournisseur'] ?? null,
                    ':incoterm'        => $values['incoterm'] ?? null,
                    ':armateur'        => $values['armateur'] ?? null,
                    ':port'            => $values['port'] ?? null,
                    ':bank'            => $values['bank'] ?? null,
                    ':date_declaration'=> $date_declaration,
                    ':assureur'        => $values['assureur'] ?? null,
                    ':date_expiration' => $date_expiration,
                    ':BL'              => $values['BL'] ?? null
                ]);

                $row_count++;
            }

            fclose($handle);
            echo "Importation terminée avec succès ! $row_count lignes importées.";
        } else {
            echo "Erreur : Impossible d'ouvrir le fichier CSV.";
        }
    } else {
        echo "Erreur : Fichier non trouvé à l'emplacement : $file_path";
    }
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>