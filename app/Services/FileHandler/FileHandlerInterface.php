<?php

namespace App\Services\FileHandler;

interface FileHandlerInterface
{
    public function upload($file, $filePath, array $args=null);
}
