<?php
 /**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require('./wp-blog-header.php');


/* Creo le condizioni di where */
$meta_query = array(
	array(
		'key'		=> 'my_meta_key',
		'value'		=> array($today,$maxDate),
		'type'		=> 'numeric',
		'compare'	=> 'BETWEEN'
		)
	);

/* Argomenti standard*/
$args = array(                                   
	'numberposts' => 5,
	'suppress_filters' => false,
	'post_status' => 'publish',
	'post_type'   => 'my_custom_type',
	'meta_key'    => 'my_meta_key',
	'orderby'     => 'meta_value',
	'order'       => 'ASC',
	'meta_query'  => $meta_query
);

/* Aggiungo il filtro per aggiungere colonne */
add_filter( 'posts_fields', function( $fields ) {
  global $wpdb;
  $fields .= sprintf( ', %s.meta_key, %s.meta_value ', $wpdb->postmeta, $wpdb->postmeta );
  return ( $fields );
}, 10, 1 );

$posts = get_posts( $args );
?>

<ul>
<?php foreach( $myposts as $post ) :	setup_postdata($post); ?>
	<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
</ul>

?>