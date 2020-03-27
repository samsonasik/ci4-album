<?php
// set title
$title = sprintf('Album Tracks of %s', $album->title);
$this->setVar('title', $title);

// extends layout
echo $this->extend('Album\Views\layout');

// begin section content
echo $this->section('content');
?>
<h1> <?php echo esc($title); ?></h1>
<p>
	<?php echo anchor('album/add', 'Add new album'); ?>
</p>

<?php
helper('form');
echo form_open('album', ['method' => 'get']);
echo form_input('keyword', esc($keyword), ['placeholder' => 'Search keyword']);
echo form_close();
?>

<div style="background-color: green;">
	<?php echo session()->getFlashdata('status'); ?>
</div>

<table class="table">
	<tr>
		<th>Title</th>
		<th>Artist</th>
		<th>&nbsp;</th>
	</tr>
	<?php if (! $tracks) : ?>
		<tr>
			<td colspan="3">No album found.</td>
		</tr>
	<?php else:
		foreach ($tracks as $track) : ?>
		<tr>
			<td><?php echo esc($track->title) ?></td>
			<td><?php echo esc($track->author) ?></td>
			<td>
				<?php echo anchor(sprintf('album/edit/%d', $album->id), 'Edit'); ?>
				<?php echo anchor(
						  sprintf('album/delete/%d', $album->id),
						  'Delete',
						  ['onclick' => 'return confirm(\'Are you sure?\')']
					  );
				?>
			</td>
		</tr>
	<?php endforeach;
	endif; ?>
</table>
<?php echo $pager->links() ?>

<?php
// end section content
echo $this->endSection();
?>