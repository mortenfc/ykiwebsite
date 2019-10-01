<?php
# Includes the autoloader for libraries installed with composer
require_once __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Storage\StorageClient;

/**
 * Upload a file.
 *
 * @param string $bucketName the name of your Google Cloud bucket.
 * @param string $objectName the name of the object.
 * @param string $source the path to the file to upload.
 *
 * @return Psr\Http\Message\StreamInterface
 */
function upload_object($bucketName, $objectName, $source)
{
  $storage = new StorageClient();
  $file = fopen($source, 'r');
  $bucket = $storage->bucket($bucketName);
  $object = $bucket->upload($file, [
    'name' => $objectName
  ]);
  printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);
}

// # Your Google Cloud Platform project ID
// $projectId = 'YKIWebsite';

// # Instantiates a client
// $storage = new StorageClient([
// 'projectId' => $projectId
// ]);

// # The name for the new bucket
// $bucketName = 'my-new-bucket';

// # Creates the new bucket
// $bucket = $storage->createBucket($bucketName);

// echo 'Bucket ' . $bucket->name() . ' created.';