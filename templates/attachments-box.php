<div class="bg-attachments">
	<?php
	if( ! $tab ){
		?>
		<h4><?php echo __('Attachments', 'bears-grid'); ?></h4>
		<?php
	}
	?>
	<ul>
	<?php 
		$attachments = get_post_meta( $id , $post_type . '_attachments', true );
		$attachs = explode(',', $attachments);
		if(isset($attachments) && $attachments != ''){
			foreach ($attachs as $attach) {
				$url = wp_get_attachment_url($attach);
				$file_name =pathinfo($url, PATHINFO_FILENAME);
				?>
				<li>
					<span class="file-name"><?php echo $file_name; ?></span>
					<a class="file-download" href="<?php echo $url; ?>" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
				</li>
				<?php
			}
		}
	?>   
	</ul>
</div>