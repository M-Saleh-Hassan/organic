<?php

namespace App\Services\FileHandler;

use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class S3FileHandler implements FileHandlerInterface
{
    private $storage;
    private $client;
    private $bucket_name;
    private $bucket_url;

    public function __construct()
    {
        // $this->storage = Storage::disk('s3');
        $this->client = new S3Client([
            'version' => 'latest',
            'region'  => config('app.bucket_region'),
            'credentials' => array(
                'key' => config('aws.key'),
                'secret'  => config('aws.secret'),
            )
        ]);
        $this->bucket_name = config('app.bucket_name');
        $this->bucket_url = config('app.bucket_url');
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function upload($fileBody, $filePath, array $args=null)
    {
        $mimeType = $args['mime_type']?? mime_content_type($filePath);

        if($mimeType == 'image/svg')
            $mimeType = 'image/svg+xml';

        $result =  $this->client->putObject([
            'ACL' => $args['acl']?? 'public-read',
            'Body' => $fileBody,
            'Bucket' => $args['bucket_name']?? $this->bucket_name,
            'ContentType' => $mimeType,
            'Key' => $filePath,
        ]);
        return  $args['bucket_url'] ?? $this->bucket_url . $filePath;
    }
}
