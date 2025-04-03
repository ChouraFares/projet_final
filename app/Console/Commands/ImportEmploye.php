<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDOException; // Importer PDOException directement

use PDO;

class ImportEmploye extends Command
{
    protected $signature = 'import:employe';
    protected $description = 'Import employe data from a CSV file into the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $file_path = storage_path('app/public/employes_cleaned.csv'); // Assurez-vous que le fichier est dans le dossier public

        try {
            $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=" . env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->info("Connected successfully.");

            if (file_exists($file_path)) {
                if (($handle = fopen($file_path, "r")) !== FALSE) {
                    fgetcsv($handle); // Skip header row

                    $stmt = $pdo->prepare("INSERT INTO employes (MLE, Nom, Prenom, Zone_geographique, Site, Direction, `N+1`, Affectation)
                                           VALUES (:MLE, :Nom, :Prenom, :Zone_geographique, :Site, :Direction, :N1, :Affectation)");

                    while (($line = fgets($handle)) !== FALSE) {
                        $data = explode(",", trim($line));
                        $data = array_map(fn($field) => trim($field, "\" "), $data);
                        $data = array_filter($data, fn($value) => !is_null($value) && $value !== '');

                        if (count($data) === 8) {
                            $MLE = !empty($data[0]) ? $data[0] : "Unknown";
                            $Nom = !empty($data[1]) ? $data[1] : "Unknown";
                            $Prenom = !empty($data[2]) ? $data[2] : "Unknown";
                            $Zone_geographique = !empty($data[3]) ? $data[3] : "Unknown";
                            $Site = !empty($data[4]) ? $data[4] : "Unknown";
                            $Direction = !empty($data[5]) ? $data[5] : "Unknown";
                            $N1 = !empty($data[6]) ? $data[6] : "Unknown";
                            $Affectation = !empty($data[7]) ? $data[7] : "Unknown";

                            $stmt->bindParam(':MLE', $MLE);
                            $stmt->bindParam(':Nom', $Nom);
                            $stmt->bindParam(':Prenom', $Prenom);
                            $stmt->bindParam(':Zone_geographique', $Zone_geographique);
                            $stmt->bindParam(':Site', $Site);
                            $stmt->bindParam(':Direction', $Direction);
                            $stmt->bindParam(':N1', $N1);
                            $stmt->bindParam(':Affectation', $Affectation);

                            $stmt->execute();
                        } else {
                            $this->warn("Row skipped due to insufficient columns.");
                        }
                    }

                    fclose($handle);
                    $this->info("Data imported successfully.");
                } else {
                    $this->error("Could not open the file.");
                }
            } else {
                $this->error("File not found: " . $file_path);
            }
        } catch (PDOException $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
