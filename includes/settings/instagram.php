<?php 
$instagram = new InstagramAPI();

if(isset($_POST['submit'])){
	update_option( 'bg_instagram_username_option', $_POST['bg_instagram_username_option'] );
	update_option( 'bg_instagram_access_token_option', $_POST['bg_instagram_access_token_option'] );
	update_option( 'bg_instagram_background_color_option', $_POST['bg_instagram_background_color_option'] );
	update_option( 'bg_instagram_background_option', $_POST['bg_instagram_background_option'] );
	update_option( 'bg_instagram_background_hover_color_option', $_POST['bg_instagram_background_hover_color_option'] );
	update_option( 'bg_instagram_background_hover_option', $_POST['bg_instagram_background_hover_option'] );
	?>
	<script>window.location.reload()</script>
	<?php
}
$username = get_option( 'bg_instagram_username_option');
$access_token = get_option( 'bg_instagram_access_token_option');
$background_color = get_option( 'bg_instagram_background_color_option');
$background = get_option( 'bg_instagram_background_option');
$background_hover_color = get_option( 'bg_instagram_background_hover_color_option');
$background_hover = get_option( 'bg_instagram_background_hover_option');



$_access_token = (isset($_GET['access_token'])) ? $_GET['access_token'] : $access_token;

if(!empty($_access_token)) {
	$data = $instagram->getUser($_access_token);
	$_username = (!empty($data->username)) ? $data->username : $username;
}

?>
<div class="bg-tab-content">
	<form method="post" action="" >
		<div class="bg-field-wrap ">
			<div class="bg-col-5">
				<a class="bg-login-instagram-btn" href="<?php echo $instagram->getLoginUrl(array('basic', 'likes', 'comments')); ?>"> 
					<i class="fab fa-instagram"></i>
					<span>Signup with Instagram</span> 
				</a>
				<p class="bg-desc">You need Access Token for using Instagram API. Click sign in with Instagram button above to get yours. This will not show your Instagram media.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_instagram_username" class="bg-label bg-col-2">Username</label>
			<div class="bg-col-5">
				<input id="bg_instagram_username" class="bg-field bg-input" name="bg_instagram_username_option" value="<?php echo (!empty($_username)) ? $_username : ''; ?>">
				<p class="bg-desc">Instagram username.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_instagram_access_token" class="bg-label bg-col-2">Access Token</label>
			<div class="bg-col-5">
				<input id="bg_instagram_access_token" class="bg-field bg-input" name="bg_instagram_access_token_option" value="<?php echo (!empty($_access_token)) ? $_access_token : ''; ?>">
				<p class="bg-desc">Instagram access token.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_instagram_background_color" class="bg-label bg-col-2">Background Color</label>
			<div class="bg-col-5">
				<div class="bg-color-views bg-color-alpha-views">
					<input id="bg_instagram_background_color" class="bg-field bg-color" data-alpha="true" data-default-color="rgba(0,0,0,0)" name="bg_instagram_background_color_option" value="<?php echo (!empty($background_color)) ? $background_color : 'rgba(0,0,0,0)'; ?>">
				</div>
				<br>
				<input type="text" id="bg_instagram_background" class="bg-field bg-input" name="bg_instagram_background_option" value="<?php echo (!empty($background)) ? $background : ''; ?>"> 
				<p class="bg-desc">Setting background for item.</p> 
			</div>
		</div>
		<div class="bg-field-wrap">
			<label for="bg_instagram_background_hover_color" class="bg-label bg-col-2">Background Hover Color</label>
			<div class="bg-col-5">
				<div class="bg-color-views bg-color-alpha-views">
					<input id="bg_instagram_background_hover_color" class="bg-field bg-color" data-alpha="true" data-default-color="rgba(251, 43, 105, 0.6)" name="bg_instagram_background_hover_color_option" value="<?php echo (!empty($background_hover_color)) ? $background_hover_color : 'rgba(251, 43, 105, 0.6)'; ?>">
				</div>
				<br>
				<input type="text" id="bg_instagram_background_hover" class="bg-field bg-input" name="bg_instagram_background_hover_option" value="<?php echo (!empty($background_hover)) ? $background_hover : ''; ?>"> 
				<p class="bg-desc">Setting background for item when hover.</p> 
			</div>
		</div>
		<div class="bg-clear"></div>
		<?php submit_button(); ?>
	</form>
</div>