<?php 
$terms = get_the_term_list( $_data['id'] , 'bg_projects_category' , '' , ' . ' , '' );
?>
<div class="<?php echo $class; ?>" style="<?php echo $_data['style']; ?>">
	<div class="bg-item-inner" style="height: <?php echo $_height; ?>;">
		<div class="thumb" style="background-image: url(<?php echo $_data['img']; ?>);"></div>
		<div class="info">
			<h3 class="heading"><a href="<?php echo $_data['permalink']; ?>"><?php echo $_data['title']; ?></a></h3>
			<div class="description"><?php echo $terms; ?></div>
		</div>
		<div class="bg-overlay"></div>
	</div>
</div>