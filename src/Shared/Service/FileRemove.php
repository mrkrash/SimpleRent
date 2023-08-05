<?php

namespace App\Shared\Service;

class FileRemove
{
    public function __construct(
        private readonly string $uploadDir,
    ) {
    }

    public function remove(string $filename): void
    {
        unlink($this->uploadDir . '/' . $filename);
    }

    public function getTargetDirectory(): string
    {
        return $this->uploadDir;
    }
}