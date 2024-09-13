<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UploadHelper
{
    // if (! request()->hasFile($name)) {
    //         return [
    //             'status_code' => 401,
    //             'message' => 'File not found.',
    //         ];
    //     }
    //     $file = request()->file($name);
    public static function upload($fileInput = [], $newName = '', $path = 'uploads', $allowExtension = [], $childPath = false)
    {
        $data = [];

        if (! array_key_exists('file', $fileInput) || empty($fileInput['file'])) {
            return [
                'success' => false,
                'status_code' => 401,
                'message' => 'File not found.',
            ];
        }

        $file = $fileInput['file'];
        $fileName = isset($fileInput['fileName']) ? $fileInput['fileName'] : null;
        $partIndex = isset($fileInput['partIndex']) ? $fileInput['partIndex'] : null;
        $totalParts = isset($fileInput['totalParts']) ? $fileInput['totalParts'] : null;
        $resume = isset($fileInput['resume']) ? $fileInput['resume'] : null;
        $uuid = isset($fileInput['uuid']) ? $fileInput['uuid'] : null;
        $done = isset($fileInput['done']) && $fileInput['done'] ? true : false;

        if (! $file->isValid()) {
            return [
                'status_code' => 500,
                'message' => 'File error.',
            ];
        }

        // Upload directory.
        $path = str_replace('.', '', $path);
        $path = trim($path, '/');
        $path = $childPath ? $path.'/'.date('Ymd') : $path;
        // $uploadDir = public_path($path.'/');
        $uploadDir = storage_path('app/'.$path.'/');
        Log::info('uploadDir : '.$fileName . ' -part: '.$partIndex.' -path: '.$uploadDir);
        if (! File::isDirectory($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true, true);
        }

        $outDir = $uploadDir.'videos/';
        if (! File::isDirectory($outDir)) {
            File::makeDirectory($outDir, 0755, true, true);
        }

        // $fileName = $file->getClientOriginalName();
        // $file = pathinfo($file->path())['basename'];
        // $size = filesize($file->path());
        // $extension = strtolower($file->getClientOriginalExtension());
        // $extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));


        if (! empty($allowExtension) && ! in_array($extension, $allowExtension)) {
            return [
                'status_code' => 500,
                'message' => $fileName . 'File type is not accept.'
            ];
        }

        $newFullName = ! empty($newName) ? $newName.'.'.$extension : uniqcode().'.'.$extension;
        $outPath = $outDir.$newFullName;

        // Handle upload with chunk or not chunk.
        if (! is_null($partIndex) && ! is_null($totalParts)) {
            $tempDir = $uploadDir.'tmp/'.$newName;
            if (! File::isDirectory($tempDir)) {
                File::makeDirectory($tempDir, 0755, true, true);
            }

            // Save part of file.
            $success = $file->move($tempDir, "part_{$partIndex}");

            // Check when all part-file was uploaded.
            // if (count(scandir($tempDir)) - 2 == $totalParts) {
            // if ($done) {
            if ($success && count(scandir($tempDir)) - 2 == $totalParts) {
                // Combine to one file.
                $outFile = fopen($outPath, 'wb');
                for ($i = 0; $i < $totalParts; $i++) {
                    $partPath = $tempDir . "/part_{$i}";
                    fwrite($outFile, file_get_contents($partPath));

                    // if (File::exists($partPath)) {
                    //     unlink($partPath); // Delete after merged.
                    // }
                }
                fclose($outFile);
                File::deleteDirectory($tempDir);

                $data[] = [
                    'success'   => true,
                    'original'  => $fileName,
                    'name'      => $newName,
                    'path'      => $outPath,
                ];
            }
        } else {
            if (! $file->move($uploadDir, $newFullName)) {
                return [
                    'status_code' => 500,
                    'message' => 'Save file was been failed.'
                ];
            } else {
                $data[] = [
                    'name' => $fileName,
                    'path' => $outPath,
                ];
            }
        }

        return [
            'status_code' => 200,
            'message' => 'Upload successfull.',
            'data' => $data
        ];
    }
}
