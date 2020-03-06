<?php
// set title
$title = 'Edit Album';
$this->setVar('title', $title);

// extends layout
echo $this->extend('Album\Views\layout');

// begin section content
echo $this->section('content');

?>

<h1><?php echo esc($title) ?></h1>

<?php
echo form_open(sprintf('album/edit/%d', $album->id));
echo form_label('Artist', 'artist');
echo form_hidden('id', set_value('id', $album->id));
echo form_input('artist', set_value('artist', $album->title));
echo $errors['artist'] ?? '';

echo form_label('Title', 'title');
echo form_input('title', set_value('title', $album->artist));
echo $errors['title'] ?? '';

echo form_submit('Save', 'Save New Album');
echo form_close();
?>

<?php echo anchor('album', 'Back to Album Index'); ?>

<?php
// end section content
echo $this->endSection();
?>