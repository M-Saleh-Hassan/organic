<?php

namespace App\Services\FileHandler;


class LocalFileHandler implements FileHandlerInterface
{

    public function upload($file, $filePath, array $args=null)
    {
        return $file->storeAs(
            $args['folder'],
            $filePath,
            'public'
        );
    }
}
