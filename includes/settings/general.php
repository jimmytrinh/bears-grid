<?php 
if(isset($_POST['submit'])){
	
	update_option( 'bg_icon_class_option', $_POST['bg_icon_class_option'] );
	update_option( 'bg_icon_image_url_option', $_POST['bg_icon_image_url_option'] );
	update_option( 'bg_icon_color_option', $_POST['bg_icon_color_option'] );
	
	?>
	<script>window.location.reload()</script>
	<?php
}

$icon_class = get_option( 'bg_icon_class_option');
$icon_image_url = get_option( 'bg_icon_image_url_option');
$icon_color = get_option( 'bg_icon_color_option');

?>
<div class="bg-tab-content">
	<form method="post" action="" >
		<div class="bg-field-wrap">
			<label for="bg_icon_class" class="bg-label bg-col-2">Icon Class</label>
			<div class="bg-col-5">
				<input type="text" id="bg_icon_class" class="bg-field bg-input" name="bg_icon_class_option" value="<?php echo (!empty($icon_class)) ? $icon_class : ''; ?>" style="width: 50%;"> 
				<p class="bg-desc">Change icon of post type Gallery and item using lightbox option. (Use <a href="https://fontawesome.com/icons">Font Awesome</a> class).</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_icon_image_url" class="bg-label bg-col-2">Icon Image Url</label>
			<div class="bg-col-5">
				<input type="text" id="bg_icon_image_url" class="bg-field bg-input" name="bg_icon_image_url_option" value="<?php echo (!empty($icon_image_url)) ? $icon_image_url : ''; ?>"> 
				<p class="bg-desc">Change icon of post type Gallery and item using lightbox option. (Use image url).</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_icon_color" class="bg-label bg-col-2">Icon Color</label>
			<div class="bg-col-5">
				<div class="bg-color-views bg-color-alpha-views">
					<input id="bg_icon_color" class="bg-field bg-color" data-alpha="true" data-default-color="rgba(255, 255, 255, 1)" name="bg_icon_color_option" value="<?php echo (!empty($icon_color)) ? $icon_color : 'rgba(255, 255, 255, 1)'; ?>">
				</div>
				<p class="bg-desc">Setting color for icon.</p> 
			</div>
		</div>
		
		<div class="bg-clear"></div>
		<?php submit_button(); ?>
	</form>
</div>