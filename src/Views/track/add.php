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
echo form_open(sprintf('track/add/%d', $album->id));
echo form_hidden('album_id', set_value('album_id', $album->id));

echo form_label('Title', 'title');
echo form_input('title', set_value('title'));
echo $errors['title'] ?? '';

echo form_label('Author', 'author');
echo form_input('author', set_value('author'));
echo $errors['author'] ?? '';

echo form_submit('Save', 'Save New Album Track');
echo form_close();
?>

<br />
<?php echo anchor(sprintf('track/%d', $album->id), sprintf('Back to Track Index of %s:%s', $album->artist, $album->title)); ?>

<?php
// end section content
echo $this->endSection();
?>