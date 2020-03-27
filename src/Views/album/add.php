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
?>

<div class="form-group">
    <?php
    echo form_label('Artist', 'artist', ['for' => 'artist']);
    echo form_input('artist', set_value('artist'), ['class' => 'form-control']);
    ?>
    <span class="error text-danger"><?php echo $errors['artist'] ?? '' ?></span>
</div>

<div class="form-group">
    <?php
    echo form_label('Title', 'title', ['for' => 'title']);
    echo form_input('title', set_value('title'), ['class' => 'form-control']);
    ?>
    <span class="error text-danger"><?php echo $errors['title'] ?? '' ?></span>
</div>

<div class="form-group">
    <?php
        echo form_submit('Save', 'Save New Album', ['class' => 'btn btn-primary']);
    ?>
</div>

<?php echo form_close(); ?>

<br /> <br />
<?php echo anchor('album', 'Back to Album Index'); ?>

<?php
// end section content
echo $this->endSection();
?>