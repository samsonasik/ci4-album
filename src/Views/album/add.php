<?php
// set title
$title = 'Add Album';
$this->setVar('title', $title);

// extends layout
echo $this->extend('Album\Views\layout');

// begin section content
echo $this->section('content');

?>

<h1><?php echo esc($title) ?></h1>

<?php
helper('form');
echo form_open('album/add');
echo form_label('Artist', 'artist');
echo form_input('artist', set_value('artist'));
echo $errors['artist'] ?? '';

echo form_label('Title', 'title');
echo form_input('title', set_value('title'));
echo $errors['title'] ?? '';

echo form_submit('Save', 'Save New Album');
echo form_close();
?>

<br />
<?php echo anchor('album', 'Back to Album Index'); ?>

<?php
// end section content
echo $this->endSection();
?>