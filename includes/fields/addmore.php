<?php
$atts = array_merge(
	array(
		'id' => '',
		'items' => '',
		'field' => '',
		'desc' => ''
	),
	$atts
);

extract($atts);

$count = ($items != '') ? count($items) : 0;
$r = 0;
?>

<div class="bg-addmore-views bg-social-views bg-col-10" data-field="<?php echo $field; ?>" data-id="<?php echo $id; ?>">
	<div class="bg-addmore-container">
		<?php 
		if($items != ''){
			foreach($items as $number => $item){
				echo call_user_func('_render_'.$field.'_item', $id, $r , $item);
				$r++;
			}
		}
		?>
	</div>
	<input type="hidden" class="bg-ordinal-numbers" value="<?php echo $count; ?>">
	<div class="bg-add-files">Add</div>
	<p class="bg-desc"><?php echo $desc; ?></p>
</div>