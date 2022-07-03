<html>
<head>
	<title>AWS File Upload</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
	<form method="POST" action="upload.php" enctype="multipart/form-data">
		<input type="file" name="file" />
		<input type="submit" value="Upload" />
	</form>
    <a href="list.php">Click here to download files</a>
   
</body>
</html>