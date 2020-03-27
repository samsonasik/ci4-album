<?php
// set title
$title = sprintf('Add Album Track of %s:%s', $album->artist, $album->title);
$this->setVar('title', $title);

// extends layout
echo $this->extend('Album\Views\layout');

// begin section content
echo $this->section('content');

?>

<h1><?php echo esc($title) ?></h1>

<?php
helper('form');
echo form_open(sprintf('album-track/add/%d', $album->id));
echo form_hidden('album_id', set_value('album_id', $album->id));
?>

<div class="form-group">
	<?php
		echo form_label('Title', 'title', ['for' => 'title']);
		echo form_input('title', set_value('title'), ['class' => 'form-control']);
	?>
	<span class="error text-danger"><?php echo $errors['title'] ?? '' ?></span>
</div>

<div class="form-group">
	<?php
		echo form_label('Author', 'author', ['for' => 'author']);
		echo form_input('author', set_value('author'), ['class' => 'form-control']);
	?>
	<span class="error text-danger"><?php echo $errors['author'] ?? '' ?></span>
</div>

<div class="form-group">
<?php
echo form_submit('Save', 'Save New Album Track', ['class' => 'btn btn-primary']);
?>

<?php echo form_close(); ?>

<br /> <br />
<?php echo anchor(
	sprintf('album-track/%d', $album->id),
	sprintf('Back to Track Index of %s:%s', $album->artist, $album->title)
	);
?>

<?php
// end section content
echo $this->endSection();
?>