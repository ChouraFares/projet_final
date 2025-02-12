<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileHandler
{
    /**
     * Stocker un fichier dans un dossier donné.
     *
     * @param  \Illuminate\Http\UploadedFile|null $file
     * @param  string $folder
     * @return string|null
     */
    public function storeFile($file, $folder)
    {
        if ($file) {
            return $file->store($folder, 'public');
        }
        return null;
    }

    /**
     * Supprimer un fichier existant.
     *
     * @param  string|null $filePath
     * @return void
     */
    public function deleteFile($filePath)
    {
        if ($filePath && Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }
}
