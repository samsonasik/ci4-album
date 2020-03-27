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
helper('form');
echo form_open(sprintf('album/edit/%d', $album->id));
echo form_hidden('id', set_value('id', $album->id));
?>
<div class="form-group">
    <?php
    echo form_label('Artist', 'artist', ['for' => 'artist']);
    echo form_input('artist', set_value('artist', $album->artist), ['class' => 'form-control']);
    ?>
    <span class="error text-danger"><?php echo $errors['artist'] ?? '' ?></span>
</div>

<div class="form-group">
    <?php
    echo form_label('Title', 'title', ['for' => 'title']);
    echo form_input('title', set_value('title', $album->title), ['class' => 'form-control']);
    ?>
    <span class="error text-danger"><?php echo $errors['title'] ?? '' ?></span>
</div>

<div class="form-group">
    <?php
        echo form_submit('Save', 'Update Album', ['class' => 'btn btn-primary']);
    ?>
</div>
<?php  echo form_close(); ?>

<br /> <br />
<?php echo anchor('album', 'Back to Album Index'); ?>

<?php
// end section content
echo $this->endSection();
?>