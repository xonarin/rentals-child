<?php
function widget_skidka($post_id) {
	$link = get_permalink($post_id);
	$title = get_the_title( $post_id );
	$property_area      = get_the_term_list($post_id, 'property_area', '', ', ', '');
	$terms = get_the_terms( $post_id, 'property_area' );
	if( $terms ){ $term = array_shift( $terms );}
	
	$default_attr = array(
		'class' => "widget__item-img",
	);
	$img = get_the_post_thumbnail( $post_id, array(108,85), $default_attr );
	echo "
		<li class='widget__item'>
			<a href='$link' class='widget__item-link'>
				{$img}
				{$title}
			</a>
			<p>Железный Порт, {$term->name}</p>
		</li>
	";
}















?>