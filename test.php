<?PHP
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