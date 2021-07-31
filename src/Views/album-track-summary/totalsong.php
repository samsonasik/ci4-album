<?php

// set title
$title = 'Album Track Summary Total Song';
$this->setVar('title', $title);
// extends layout
echo $this->extend('Album\Views\layout');
// begin section content
echo $this->section('content');
?>
<h1> <?php
echo esc($title);
?></h1>

<table class="table">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Artist</th>
		<th>Total Songs</th>
	</tr>
	<?php
	if (! $summary) : ?>
		<tr>
			<td colspan="4" align="center">No album track summary found.</td>
		</tr>
		<?php else:
			foreach ($summary as $result) : ?>
		<tr>
			<td><?php echo esc($result->id) ?></td>
			<td><?php echo esc($result->title) ?></td>
			<td><?php echo esc($result->artist) ?></td>
			<td><?php echo esc($result->total_song) ?></td>
		</tr>
		<?php endforeach;
	endif;
		?>
</table>

<?php
echo $pager->links() ?>

?>

<br /> <br />
<?php
echo anchor('album', 'Back to Album Index');
?>

<?php
// end section content
echo $this->endSection();
