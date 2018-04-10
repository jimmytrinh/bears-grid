<?php 
$terms = get_the_term_list( $_data['id'], 'bg_portfolio_category', '', ' . ', '' );
$external_link = get_post_meta( $_data['id'], 'bg_portfolio_external_link', true );
$permalink = ( isset($external_link) && $external_link != '' ) ? $external_link : $_data['permalink'];
$target = ( isset($external_link) && $external_link != '' ) ? '_blank' : '_self';
?>
<div class="<?php echo $class; ?>" style="<?php echo $_data['style']; ?>">
	<div class="bg-item-inner" style="height: <?php echo $_height; ?>;">
		<div class="thumb" style="background-image: url(<?php echo $_data['img']; ?>);"></div>
		<div class="info">
			<h3 class="heading"><a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>"><?php echo $_data['title']; ?></a></h3>
			<div class="description"><?php echo $terms; ?></div>
		</div>
		<div class="bg-overlay"></div>
	</div>
</div>