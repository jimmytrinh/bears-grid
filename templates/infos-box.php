<div class="bg-info"> 
	<?php
	if( ! $tab ){
		?>
		<h4><?php echo __('Info', 'bears-grid'); ?></h4>
		<?php
	}
	?>
	<ul>
	<?php 
		$infos = get_post_meta( $id , $post_type . '_meta', true );
		if(isset($infos) && $infos != ''){
			foreach ($infos as $info) {
				?>
				<li><span><?php echo $info['bg_meta_title'];?></span><p><?php echo $info['bg_meta_value']; ?></p></li>
				<?php
			}
		}
	?>   
	</ul>
</div>