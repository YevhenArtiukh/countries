<?php
/**
 * Created by PhpStorm.
 * User: Smile
 * Date: 2020-06-17
 * Time: 14:12
 */

namespace App\Entity\Countries\UseCase\CreateCountry;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFlag
{
    private $uploadedFile;
    private $targetDir;

    public function __construct(
        UploadedFile $uploadedFile,
        string $targetDir
    )
    {
        $this->uploadedFile = $uploadedFile;
        $this->targetDir = $targetDir;
    }

    public function move()
    {
        $fileName = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=').'.'.strtolower($this->uploadedFile->getClientOriginalExtension());
        $this->uploadedFile->move($this->targetDir, $fileName);

        return $fileName;
    }
}