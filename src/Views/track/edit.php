<?php
// set title
$title = sprintf('Edit Album Track of %s:%s', $album->artist, $album->title);
$this->setVar('title', $title);

// extends layout
echo $this->extend('Album\Views\layout');

// begin section content
echo $this->section('content');

?>

<h1><?php echo esc($title) ?></h1>

<?php
helper('form');
echo form_open(sprintf('track/edit/%d/%d', $album->id, $track->id));
echo form_hidden('album_id', set_value('album_id', $album->id));
echo form_hidden('id', set_value('id', $track->id));
?>


<div class="form-group">
	<?php
		echo form_label('Title', 'title', ['for' => 'title']);
		echo form_input('title', set_value('title', $track->title), ['class' => 'form-control']);
	?>
	<span class="error text-danger"><?php echo $errors['title'] ?? '' ?></span>
</div>

<div class="form-group">
		<?php
			echo form_label('Author', 'author', ['for' => 'title']);
			echo form_input('author', set_value('author', $track->author), ['class' => 'form-control']);
		?>
		<span class="error text-danger"><?php echo $errors['author'] ?? '' ?></span>
</div>

<div class="form-group">
	<?php
		echo form_submit('Save', 'Update Album Track', ['class' => 'btn btn-primary']);
	?>
</div>

<?php echo form_close(); ?>

<br /> <br />
<?php echo anchor(
	sprintf('track/%d', $album->id),
	sprintf('Back to Track Index of %s:%s', $album->artist, $album->title)
	);
?>

<?php
// end section content
echo $this->endSection();
?>