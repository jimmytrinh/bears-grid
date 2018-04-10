<div class="bg-social"> 
	<?php
	if( ! $tab ){
		?>
		<h4><?php echo __('Share', 'bears-grid'); ?></h4>
		<?php
	}
	?>
	<ul>
	<?php
		$socials = get_post_meta( $id , $post_type . '_social', true );
		if(isset($socials) && $socials != ''){
			foreach ($socials as $social) {
				?>
				<li>
					<a href="<?php echo $social['bg_social_link'];?>">
						<i class="<?php echo $social['bg_social_icon'];?>"></i>
					</a>
				</li>	
				<?php    
			}
		}
	?>
	</ul>
</div>