<!doctype html>
<html>
<head>
	<title>CI4 App - <?php echo $this->getData()['title'] ?? ''; ?> </title>
</head>
<body>
	<?= $this->renderSection('content') ?>
</body>
</html>
