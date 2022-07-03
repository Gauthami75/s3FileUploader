<?php
	require 'vendor/autoload.php';
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	// AWS Account information
	$bucketName = 'krayo';
	$IAM_KEY = 'AKIATMKNUSCUWH24IO6D';
	$IAM_SECRET = '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';
	$REGION = 'ap-south-1';

	// Establishing connection to AWS
	try {
		
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => $REGION
			)
		);
	} catch (Exception $e) {
		
		die("Error: " . $e->getMessage());
	}

	
	// generating a unqiue random string for the key name.
	$keyName = 'my_folder/' . basename($_FILES["file"]['name']);
	$pathInS3 = 'https://s3.'.$REGION.'.amazonaws.com/' . $bucketName . '/' . $keyName;

	try {
		
		$file = $_FILES["file"]['tmp_name'];

		$result = $s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);
		$url = $result['ObjectURL'];
		echo 'File Uploaded Successfully !'.$url;

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}

    try {
        // Geting the object.
        
        $result = $s3->getObject([
            
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file_1,
			
        ]);
    
        // Displaying  the object in the browser.
        header("Content-Type: {$result['ContentType']}");
        echo $result['Body'];
    } catch (S3Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }

?>