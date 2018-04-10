<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Params extraction
$atts = shortcode_atts(
	array(
		'self'              => '',
		'content'           => '',
		'post_type'         => 'projects',
		'sort'         => 'recent',
		'cat'          => '',
		'total_items'  => 9, 
		'grid_id'           => '',
		'grid_col'          => 3, 
		'grid_gap'          => 30,
		'cel_height'        => 320,
		'col_in_table'      => 2,
		'col_in_mobi'       => 1,
		'el_class'          => '',
		'css'               => '',
	),
	$atts
);
extract($atts);

$grid_name = 'projects_masonry_' . $grid_id;
$current_user = wp_get_current_user();
$sizeMap = pm_gridmap_masonryhybrid_handle('get', $grid_name);


/**
 * @var $css_class
 */
extract( $self->getStyles( $el_class, $css, $atts ) );

/** elm ID **/
$attr_id = "id={$grid_name}";

$data = $self->get_data($atts); //echo '<pre>'; print_r($data); echo '</pre>'; 

$masonry_attr = array(
	'class' => 'masonry-wrap',
);



?>
<div <?php echo esc_attr($attr_id); ?> class="<?php echo esc_attr($css_class); ?>">
	<div class="projects-masonry-inner">
		<div class="projects-masonry-filter">
			<div class="filter-item">
				<a href="javascript:void(0);" data-filter="*" class="is-active">All</button>
			</div>
			<?php 
			$projects_categories = get_terms( 'projects_category', array(
				'hide_empty' => false,
			));
			foreach($projects_categories as $projects_category) {
				?>
				<div class="filter-item">
					<a href="javascript:void(0);" data-filter=".cat_<?php echo $projects_category->slug; ?>"><?php echo $projects_category->name; ?></a>
				</div>
				<?php
			}
			?>
		</div>
		<div <?php echo pm_html_build_attributes($masonry_attr); ?>>
			<div class="grid-sizer"></div>
			<?php
			$count = 1;
			if(! empty($data) && is_array($data) && count($data) > 0) :
				foreach($data as $item) :
					$grid_item_attr = array(
					  'class' => implode(' ', array('grid-item')),
					  'style' => implode(';', array('height: '.$atts['cel_height'].'px')),
					);
					
					$cates = wp_get_post_terms($item['post_id'], 'projects_category');
					foreach($cates as $cat){
						$grid_item_attr['class'] .= ' cat_'.$cat->slug;
					}
					
					if($count == 1){
						$grid_item_attr['class'] .= ' grid-item--width5';
					} elseif($count == 2){
						$grid_item_attr['class'] .= ' grid-item--width7';
					} else {
						$grid_item_attr['class'] .= ' grid-item--width4';
					}
					
					echo implode('', array(
						'<div '. pm_html_build_attributes($grid_item_attr) .'>',
						  '<div class="grid-item-inner">',
							$self->_template($item, $atts),
						  '</div>',
						'</div>',
					));
					$count = $count + 1;
				endforeach;
			endif;
			?>
		</div>
		<div class="projects-masonry-more">
			<button data-total ="<?php echo $total_items; ?>" data-offset="<?php echo $total_items; ?>" data-atts='<?php echo json_encode($atts); ?>'>Load more</button>
		</div>
	</div>
</div>
