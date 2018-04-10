<div class="bg-skill">
	<?php
	if( ! $tab ){
		?>
		<h4><?php echo __('Skill', 'bears-grid'); ?></h4>
		<?php
	}
	?>
	<ul>
	<?php 
		$skills = get_post_meta( $id , $post_type . '_skills', true );
		if(isset($skills) && $skills != ''){
			foreach ($skills as $skill) {
				$level = ($skill['bg_skill_level']/10)*100;
				?>
				<li class="item-skills" data-percent="<?php echo $level; ?>" style="background-color:<?php echo $skill['bg_skill_color'];?>;">
					<span class="skill-name"><?php echo $skill['bg_skill_name'];?></span>
					<span class="skill-value"><?php echo number_format($skill['bg_skill_level'], 1, '.', '');?></span>
				</li>
				<?php
			}
		}
	?>   
	</ul>
</div>