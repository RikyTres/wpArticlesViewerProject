<?php get_header(); ?>
<h1>Controllo</h1>
<?php
global $post;

//////* Creo le condizioni di where *///////
$meta_query = array(
	array(
		'key'		=> 'my_meta_key',
		'value'		=> array($today,$maxDate),
		'type'		=> 'numeric',
		'compare'	=> 'BETWEEN'
		)
	);

////////* Argomenti standard*/////////
/*$args = array(                                   
	'numberposts' => 5,
	'suppress_filters' => false,
	'post_status' => 'publish',
	'post_type'   => 'my_custom_type',
	'meta_key'    => 'my_meta_key',
	'orderby'     => 'meta_value',
	'order'       => 'ASC',
	'meta_query'  => $meta_query
);*/
$args = array( 'numberposts' => 5, 'orderby' => 'rand' );

/* Aggiungo il filtro per aggiungere colonne */
add_filter( 'posts_fields', function( $fields ) {
  global $wpdb;
  $fields .= sprintf( ', %s.meta_key, %s.meta_value ', $wpdb->postmeta, $wpdb->postmeta );
  return ( $fields );
}, 10, 1 );

$posts = get_posts( $args );
?>

<h1>Test page!</h1>

<ul>
<?php foreach( $myposts as $post ) :	setup_postdata($post); ?>
	<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endforeach; ?>
</ul>

<?php get_footer(); ?>