<?php
 
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

$bucket = 'krayo';

// Instantiate the client.
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-south-1',
    'credentials' => [
        'key'    => 'AKIATMKNUSCUWH24IO6D',
        'secret' => '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',
    ],
]);

//Iterators to returns objects.
try {
    $results = $s3->getPaginator('ListObjects', [
        'Bucket' => $bucket
    ]);

    foreach ($results as $result) {
        foreach ($result['Contents'] as $object) {
           // echo $object['Key'] . PHP_EOL;
        }
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

// Using the API.
try {
    $objects = $s3->listObjects([
        'Bucket' => $bucket
    ]);

} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="list.css">
    <link rel="stylesheet" href="index.css">
    <title>List Files</title>
</head>
<body>
<ul class="downloadList" role="menu">
    <h1>List of Files</h1>
    <div class="listOfFiles">
    <?php foreach ($objects['Contents']  as $object):?>
      <li>
        <?php echo $object['Key'] . PHP_EOL;?> <?php 
        $keyPath = $object['Key'] .PHP_EOL;
            
        $command = $s3->getCommand('GetObject', array(
            'Bucket'      => $bucket,
            'Key'         => $keyPath,

        ));
        $signedUrl = $s3->createPresignedRequest($command, "+10 seconds");
        $presignedUrl = (string)$signedUrl->getUri();
        ?>
        <a href="<?php echo $presignedUrl?>">Download</a>
      </li>
   <?php endforeach;?>
    </div>
</ul>
</body>
</html>