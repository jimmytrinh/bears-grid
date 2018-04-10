<?php
$atts = array_merge(
	array(
		'id' => '',
		'files' => '',
		'multiple' => 'true',
		'max_files' => 40,
		'count_files' => 0
		
	),
	$atts
);

extract($atts);
?>

<div class="bg-files-views" data-multiple="<?php echo $multiple ?>" data-max-files="<?php echo $max_files ?>" data-type="files">
	<input class="bg-files" id="<?php echo $id ?>" name="<?php echo $id ?>" type="hidden" value="<?php echo $files; ?>">
	<ul class="bg-files-list">
		<?php 
		if($files != ""){
			$files = explode(',',  $files);
			$count_files = count($files);
			echo _get_uploaded_files($files);
		}
		?>
	</ul>
	<div class="bg-add-files">Add Files</div>
	<span class="bg-status"><span><?php echo $count_files; ?></span>/<?php echo $max_files ?> files</span>
</div>