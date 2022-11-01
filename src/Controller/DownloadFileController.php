<?php

namespace App\Controller;

use App\Entity\File\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mime\MimeTypeGuesserInterface;
use Symfony\Component\Routing\Annotation\Route;

class DownloadFileController extends AbstractController
{
    #[Route('/file/download/{id}', name: 'download_file')]
    public function downloadFile(File $file, MimeTypeGuesserInterface $mimeTypeGuesser): Response
    {
        $storageMetadata = $file->getStorageMetadata();
        if (!$storageMetadata || !($filepath = $storageMetadata->getFilepath()) || !($originalFilename = $storageMetadata->getOriginalFilename())) {
            throw new \LogicException('Should not happened : file without storage metadata or without filepath or without originalFilename');
        }
        $response = new BinaryFileResponse(new Stream($filepath));

        $response->headers->set('Content-Type', $mimeTypeGuesser->guessMimeType($filepath));

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $originalFilename
        );

        return $response;
    }
}
