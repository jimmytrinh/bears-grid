<?php
$_height = $height . $unit;
foreach( $datas as $_data ){
	$class = $_data['class'] . ' bg--item-' . $_data['id'];

	if( ! $light_box && $post_type != 'bg_gallery' ) {
		$tpl_path = BG_INC_PATH . 'shortcodes/' . $sc . '/tpl/' . $tpl . '.php'; 
		if( $tpl != 'default' || file_exists( $tpl_path ) ){
			include $tpl_path; 
		} else {
			?>
			<div class="<?php echo $class; ?>" style="<?php echo $_data['style']; ?>" >
				<div class="bg-item-inner" style="height: <?php echo $_height; ?>;">
					<div class="thumb" style="background-image: url(<?php echo $_data['img']; ?>);"></div>
					<div class="info">
						<h3 class="heading"><a href="<?php echo $_data['permalink']; ?>"><?php echo $_data['title']; ?></a></h3>
						<div class="description"><?php echo wpautop($_data['content']); ?></div>
					</div>
				</div>
			</div>
			<?php
		}
	} else {
		?>
		<div class="<?php echo $class; ?>" style="<?php echo $_data['style']; ?>" data-src="<?php echo $_data['img']; ?>" data-sub-html="">
			<div class="bg-item-inner" style="height: <?php echo $_height; ?>;">
				<div class="thumb" style="background-image: url(<?php echo $_data['img']; ?>);"></div>
				<img src="<?php echo $_data['img']; ?>" class="bg-hidden">
				<div class="info">
					<span class="zoom">
						<?php 
						$icon_class = get_option( 'bg_icon_class_option');
						$icon_image_url = get_option( 'bg_icon_image_url_option');
						$icon_color = get_option( 'bg_icon_color_option');
						
						if(!empty($icon_image_url)){
							?>
							<img src="<?php echo $icon_image_url; ?>" alt="zoom-icon" />
							<?php
						} else if(!empty($icon_class)){
							?>
							<i class="<?php echo $icon_class; ?>"></i>
							<?php
						} else {
							?>
							<svg viewBox="0 0 512 512"><path d="M384 250v12c0 6.6-5.4 12-12 12h-98v98c0 6.6-5.4 12-12 12h-12c-6.6 0-12-5.4-12-12v-98h-98c-6.6 0-12-5.4-12-12v-12c0-6.6 5.4-12 12-12h98v-98c0-6.6 5.4-12 12-12h12c6.6 0 12 5.4 12 12v98h98c6.6 0 12 5.4 12 12zm120 6c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-32 0c0-119.9-97.3-216-216-216-119.9 0-216 97.3-216 216 0 119.9 97.3 216 216 216 119.9 0 216-97.3 216-216z" class=""></path></svg>
							<?php
						}
						?>
					</span>
				</div>
			</div>
		</div>
		<?php
	}
}