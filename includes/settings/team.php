<?php 
if(isset($_POST['submit'])){
	if(isset($_POST['bg_team_disable_option'])) {
		update_option( 'bg_team_disable_option', $_POST['bg_team_disable_option'] );
	} else {
		update_option( 'bg_team_disable_option', '' );
	}
	
	update_option( 'bg_team_name_option', $_POST['bg_team_name_option'] );
	update_option( 'bg_team_slug_option', $_POST['bg_team_slug_option'] );
	update_option( 'bg_team_background_color_option', $_POST['bg_team_background_color_option'] );
	update_option( 'bg_team_background_option', $_POST['bg_team_background_option'] );
	update_option( 'bg_team_background_hover_color_option', $_POST['bg_team_background_hover_color_option'] );
	update_option( 'bg_team_background_hover_option', $_POST['bg_team_background_hover_option'] );
	update_option( 'bg_team_name_color_option', $_POST['bg_team_name_color_option'] );
	update_option( 'bg_team_position_color_option', $_POST['bg_team_position_color_option'] );
	?>
	<script>window.location.reload()</script>
	<?php
}

$disable = get_option( 'bg_team_disable_option');
$name = get_option( 'bg_team_name_option');
$slug = get_option( 'bg_team_slug_option');
$background_color = get_option( 'bg_team_background_color_option');
$background = get_option( 'bg_team_background_option');
$background_hover_color = get_option( 'bg_team_background_hover_color_option');
$background_hover = get_option( 'bg_team_background_hover_option');
$name_color = get_option( 'bg_team_name_color_option');
$position_color = get_option( 'bg_team_position_color_option');

?>
<div class="bg-tab-content">
	<form method="post" action="" >
		<div class="bg-field-wrap">
			<label for="bg_team_disable" class="bg-label bg-col-2">Disable</label>
			<div class="bg-col-5">
				<input type="checkbox" id="bg_team_disable" class="bg-checkbox" name="bg_team_disable_option" value="1" <?php echo ($disable == '1') ? 'checked' : ''; ?>>
				<p class="bg-desc">Check to disable post type.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_team_name" class="bg-label bg-col-2">Name</label>
			<div class="bg-col-5">
				<input type="text" id="bg_team_name" class="bg-field bg-input" name="bg_team_name_option" value="<?php echo (!empty($name)) ? $name : 'Bears Team'; ?>"> 
				<p class="bg-desc">Change name of post type.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_team_slug" class="bg-label bg-col-2">Slug</label>
			<div class="bg-col-5">
				<input type="text" id="bg_team_slug" class="bg-field bg-input" name="bg_team_slug_option" value="<?php echo (!empty($slug)) ? $slug : 'bg-team'; ?>"> 
				<p class="bg-desc">Change slug of post type. (Please save permalinks again after change slug)</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_team_background_color" class="bg-label bg-col-2">Background Color</label>
			<div class="bg-col-5">
				<div class="bg-color-views bg-color-alpha-views">
					<input id="bg_team_background_color" class="bg-field bg-color" data-alpha="true" data-default-color="rgba(0,0,0,0)" name="bg_team_background_color_option" value="<?php echo (!empty($background_color)) ? $background_color : 'rgba(0,0,0,0)'; ?>">
				</div>
				<br>
				<input type="text" id="bg_team_background" class="bg-field bg-input" name="bg_team_background_option" value="<?php echo (!empty($background)) ? $background : ''; ?>"> 
				<p class="bg-desc">Setting background color for item.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_team_background_hover_color" class="bg-label bg-col-2">Background Hover Color</label>
			<div class="bg-col-5">
				<div class="bg-color-views bg-color-alpha-views">
					<input id="bg_team_background_hover_color" class="bg-field bg-color" data-alpha="true" data-default-color="rgba(251, 43, 105, 0.6)" name="bg_team_background_hover_color_option" value="<?php echo (!empty($background_hover_color)) ? $background_hover_color : 'rgba(255, 255, 255, 0.75)'; ?>">
				</div>
				<br>
				<input type="text" id="bg_team_background_hover" class="bg-field bg-input" name="bg_team_background_hover_option" value="<?php echo (!empty($background_hover)) ? $background_hover : ''; ?>"> 
				<p class="bg-desc">Setting background for item when hover.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_team_name_color" class="bg-label bg-col-2">Name Color</label>
			<div class="bg-col-5">
				<div class="bg-color-views bg-color-alpha-views">
					<input id="bg_team_name_color" class="bg-field bg-color" data-alpha="true" data-default-color="rgba(255, 255, 255, 1)" name="bg_team_name_color_option" value="<?php echo (!empty($name_color)) ? $name_color : '#2b2b2b'; ?>">
				</div>
				<p class="bg-desc">Setting name color for item.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_team_position_color" class="bg-label bg-col-2">Position Color</label>
			<div class="bg-col-5">
				<div class="bg-color-views bg-color-alpha-views">
					<input id="bg_team_position_color" class="bg-field bg-color" data-alpha="true" data-default-color="rgba(252, 244, 0, 1)" name="bg_team_position_color_option" value="<?php echo (!empty($position_color)) ? $position_color : '#96122c'; ?>">
				</div>
				<p class="bg-desc">Setting position color for item.</p> 
			</div>
		</div>
		<div class="bg-clear"></div>
		<?php submit_button(); ?>
	</form>
</div>