<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class UploaderHelper
{
    private $uploadsPath;

    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadTrickImage(UploadedFile $uploadedFile): string
    {
        $destination = $this->uploadsPath;
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = Slugify::slugify($originalFilename) .'-'.uniqid().'.'.$uploadedFile->guessExtension();

        $uploadedFile->move(
            $destination,
            $newFilename
        );

        return $newFilename;
    }

    public function deleteFile(string $path)
    {
        $filesystem = new Filesystem();

        try {
            $filesystem->mkdir($uploadsPath.'/'.$path);
        } catch (IOExceptionInterface $e) {
            echo "Une erreur est arrivée pour ". $e->getPath();
        }
    }
}