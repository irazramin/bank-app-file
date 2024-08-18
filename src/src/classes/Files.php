<?php

namespace App\classes;

class Files
{
    public function __construct(private string $fileName)
    {
        $this->checkFileExist();
    }

    private function checkFileExist(): void
    {
        if (!file_exists($this->fileName)) {
            file_put_contents("$this->fileName", "[]");
        }
    }

    public function saveData($data): void {
        file_put_contents("$this->fileName", $data);
    }

    public function getFileData(): bool|string
    {
        return file_get_contents($this->fileName);
    }
}