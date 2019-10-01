<?php

require_once __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

/**
 * Download an object from Cloud Storage and save it as a local file.
 *
 * @param string $bucketName the name of your Google Cloud bucket.
 * @param string $objectName the name of your Google Cloud object.
 * @param string $destination the local destination to save the encrypted object.
 *
 * @return void
 */
function download_object($bucketName, $objectName, $destination)
{
  $storage = new StorageClient();
  $bucket = $storage->bucket($bucketName);
  $object = $bucket->object($objectName);
  $object->downloadToFile($destination);
  printf(
    'Downloaded gs://%s/%s to %s' . PHP_EOL,
    $bucketName,
    $objectName,
    basename($destination)
  );
}