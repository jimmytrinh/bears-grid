<?php
extract( $atts );
unset( $atts );

$categories = get_the_term_list( $id, $post_type . '_category', '', ', ' );
?>  

<div class="bg-d-col-12 bg-t-col-12 bg-m-col-12 bg-single-content">
	<div class="bg-d-col-7 bg-t-col-8 bg-m-col-12 bg-single-content-left">
		<h3 class="bg-title"><?php echo get_the_title($id); ?></h3>
		<div class="bg-term">
			<?php echo $categories; ?>
		</div>
		<div class="bg-content">
			<?php echo wpautop( get_the_content() );?>
		</div>
	</div>
	<div class="bg-meta-container bg-d-col-4 bg-t-col-4 bg-m-col-12 bg-single-content-right bg-d-offset-1">
		<?php
			do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'infos' );
			
			do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'socials' );
		?>
	</div>
</div>
<div class="bg-d-col-12 bg-t-col-12 bg-m-col-12">
	<?php
	do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'gallery' );
	?>
</div>