<?php
extract( $atts );
unset( $atts );
?>  

<div class="bg-d-col-6 bg-t-col-6 bg-m-col-12">
	<div class="bg-row">
	<?php 
	if($post_type == 'bg_team'){
		?>
		<div class="bg-single-avatar-container bg-d-col-12 bg-t-col-12 bg-m-col-12">
			<div class="bg-single-avatar">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'bg-image-medium' ); ?>
			</div>
		</div>
		<div class="bg-single-gallery-container bg-d-col-12 bg-t-col-12 bg-m-col-12">
			<?php do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'gallery' ); ?>
		</div>
		<?php
	} else {
		do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'gallery' );
	}
	?>
	</div>
</div>
<div class="bg-d-col-5 bg-t-col-6 bg-m-col-12 bg-d-offset-1 bg-single-content">
	<div class="bg-d-col-12 bg-t-col-12 bg-m-col-12">
		<h3 class="bg-title"><?php echo get_the_title($id); ?></h3>
		<?php
		if($post_type == 'bg_team'){
			$position = get_the_term_list( $id, $post_type . '_position', '', ',  ' );
			?>
			<div class="bg-term"><?php echo $position; ?></div>
			<?php
		} else {
			$categories = get_the_term_list( $id, $post_type . '_category', '', ', ' );
			?>
			<div class="bg-term"><?php echo $categories; ?></div>
			<?php
		}
		?>
		<div class="bg-content">
			<?php echo wpautop( get_the_content() );?>
		</div>
	</div>
	<div class="bg-meta-container bg-d-col-12 bg-t-col-12 bg-m-col-12">
		<?php   
		if($post_type == 'bg_team'){
			?>
			<div class="bg-tabs-wrap">
				<ul class="bg-nav-tabs">
					<li class="active"><a href="#bg_tab_info"><?php echo __('Info', 'bears-grid'); ?></a></li>
					<li><a href="#bg_tab_skills"><?php echo __('Skills', 'bears-grid'); ?></a></li>
					<li><a href="#bg_tab_attachments"><?php echo __('Attachments', 'bears-grid'); ?></a></li>
				</ul>
				<div class="bg-tabs-content">
					<div id="bg_tab_info" class="bg-tab-pane active">
						<div class="bg-tab">
							<?php do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'infos', true ); ?>
						</div>
					</div>
					<div id="bg_tab_skills" class="bg-tab-pane">
						<div class="bg-tab">
							<?php do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'skills', true ); ?>
						</div>
					</div>
					<div id="bg_tab_attachments" class="bg-tab-pane">
						<div class="bg-tab">
							<?php do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'attachments', true ); ?>
						</div>
					</div>
				</div>
			</div>
			<?php
		} else {
			do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'infos' );
		}
		
		do_action( '_single_meta_box_action', get_the_ID(), $post_type, 'socials' );
		?>
	</div>
</div>