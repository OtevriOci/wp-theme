<?php
//Adds Noto Sans
function load_google_fonts() {
	$protocol = is_ssl() ? 'https' : 'http';
	$query_args = array(
		'family' => 'Noto+Sans:400italic,700italic,400,700',
		'subset' => 'latin,latin-ext',
	);
	wp_enqueue_style( 'otevrioci-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
}
add_action('wp_print_styles', 'load_google_fonts');

// Adds tribe events to the homepage
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_archive() || is_tag() || is_home() && empty( $query->query_vars['suppress_filters'] ) ) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = array('post','tribe_events','attachment');
    $query->set('post_type',$post_type);
	return $query;
    }
}

// Add tribe events to the RSS Feed
function add_events_to_rss_feed( $args ) {
  if ( isset( $args['feed'] ) && !isset( $args['post_type'] ) )
    $args['post_type'] = array('post', 'tribe_events');
  return $args;
}

add_filter( 'request', 'add_events_to_rss_feed' );

// Front page navigation
function otevrioci_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>

			<div class="nav-overview"><a href="<?php echo tribe_get_events_link() ?>"><?php _e( 'Kalendář akcí', 'otevrioci' ); ?></a></div>
			
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
		</nav>
	<?php endif;
}

//Post thumbnail size
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 120, 120, true );
}

// Changes excerpt length
function custom_excerpt_length( $length ) {
	return 6;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//*** EVENTS ***

//Address
function echo_my_tribe_address(){
	$postId = get_the_ID();	
	$address_out = array();

	// Get our street address
	if( tribe_get_address( $postId ) ) {					
		$address_out []= '<span class="street-address">'. tribe_get_address( $postId ) .'</span>';
	}

	// Get our full region
	$our_province = tribe_get_event_meta( $postId, '_VenueStateProvince', true );
	$our_states = TribeEventsViewHelpers::loadStates();
	$our_full_region = isset( $our_states[$our_province] ) ? $our_states[$our_province] : $our_province;

	// Get our city
	if( tribe_get_city( $postId ) ) {
		$address_out []= ' <span class="locality">'. tribe_get_city( $postId ) .'</span>';
	}

	// Get our region
	if( tribe_get_region( $postId ) ) {
		if(count($address_out))
			$address_out []= ' <abbr class="region tribe-events-abbr" title="'. $our_full_region .'">'. tribe_get_region( $postId ) .'</abbr>';
	}

	// Get our postal code
	if( tribe_get_zip( $postId ) ) {
		$address_out []= ' <span class="postal-code">'. tribe_get_zip( $postId ) .'</span>';
	}

	// Get our country
	if( tribe_get_country( $postId ) ) {
		if(count($address_out))
		$address_out []= ' <span class="country-name">'. tribe_get_country( $postId ) .'</span>';
	}

	echo implode( ', ', $address_out );
}

//Meta
function echo_my_tribe_meta(){
	if (is_single() && tribe_get_event_website_url()!=''){
		$website_type = get_post_meta(get_the_ID(), 'website_type', $single = true);
		if ($website_type == "fb")
			echo '<span class="eventmeta"><a href="'. tribe_get_event_website_url() .'" class="fb"><span class="fontello"></span></a></span>';
		else
			echo '<span class="eventmeta"><a href="'. tribe_get_event_website_url() .'">Web</a></span>';
	}
	if (!tribe_event_is_all_day()){
		echo '<span class="eventmeta"><span class="fontello"></span> ';
		if (is_single()){
			if ( get_post_meta(get_the_ID(), 'repeat', true) == 'weekly' )
				echo tribe_get_start_date(null, false, 'l G:i');
			else {
				echo tribe_get_start_date( null, false, '' );
				echo tribe_get_start_date( null, false, ' G:i' );
			}
			if (!(tribe_get_start_date() == tribe_get_end_date()) ) echo ' - ' . tribe_get_end_date( null, false, 'G:i' );
		}
		else {
			echo tribe_get_start_date( null, false, 'G:i' );
			if (!(tribe_get_start_date( null, false, 'G:i' ) == tribe_get_end_date( null, false, 'G:i' )) ) echo ' - ' . tribe_get_end_date( null, false, 'G:i' );
		}
		echo '</span>';
	}
	if(tribe_address_exists())
		if( is_single() && tribe_show_google_map_link() ) {
			echo '<span class="eventmeta"><span class="fontello"></span> <a href="'. tribe_get_map_link() .'">'; 
			echo_my_tribe_address();
			echo '</a></span>';
		}
		else {
			echo '<span class="eventmeta"><span class="fontello"></span> ';
			echo_my_tribe_address();
			echo '</span>';
		}
	if ( tribe_get_cost() )
		echo '<span class="eventmeta"><span class="fontello"></span> '. tribe_get_cost( null, true ) . '</span>';
	if(tribe_has_organizer() && is_single() ){
		echo '<span class="eventmeta"><span class="fontello"></span> ';
		if ( tribe_get_organizer_website_url() != "" ) echo '<a href="' . tribe_get_organizer_website_url() . '">';
		echo tribe_get_organizer();
		if ( tribe_get_organizer_website_url() != "" ) echo '</a>';
		echo '</span>';
	}
}

//*** SHORTCODES ***

//Shortcode for links
function hyperlink($atts) {
  extract(shortcode_atts(array(
    'link' => '',
    'image' => '',
    'title' => ''
  ), $atts));
  $uploads = "http://otevrioci.cz/wp-content/uploads/";
  return '<a class="card rect" href="' . $link . '">
	<div class="row">
	<div class="card-thumb" style="background:url(\'' . $uploads . '/' . $image . '\');\"></div>
	</div>
	<div class="row">
	<div class="card-badge">' . $title . '</div>
	</div>
	</a>';
}

add_shortcode("hyperlink", "hyperlink");

//Shortcode for downloads
function download($atts) {
  extract(shortcode_atts(array(
    'link' => '',
    'image' => '',
    'title' => ''
  ), $atts));
  $uploads = "http://otevrioci.cz/wp-content/uploads/";
  return '<a class="download" href="' . $uploads . $link . '"><img class="downloadimg" src="' . $uploads . '/' . $image . '" /></a>';  
}

add_shortcode("download", "download");

//Shortcode for movies
function movie($atts, $content = null) {
  extract(shortcode_atts(array(
    'title' => '',
    'image' => '',
    'site' => '',
    'by' => '',
    'country' => '',
    'year' => '',
    'time' => ''
  ), $atts));
  $uploads = "http://otevrioci.cz/wp-content/uploads/";
  return '<div class="movie">
	<div class="movie-banner"><img src="' . $uploads . '/' . $image . '" alt="' . $title . '"/></div>
	<div class="movie-text"><h2>'. $title .'</h2><div class="gloss">' . $by . ' ∙ ' . $country . ' ∙ ' . $year . ' ∙ ' . $time . ' ∙ <a href="' . $site . '">'. __( Web, 'otevrioci' ) .'</a></div><p>' . $content . '</p></div></div>';  
}

add_shortcode("movie", "movie");

//Shortcode for books
function book($atts, $content = null) {
  extract(shortcode_atts(array(
    'title' => '',
    'image' => '',
    'site' => '',
    'by' => '',
    'year' => '',
    'content' => ''
  ), $atts));
  $uploads = wp_upload_dir();
  return '<div class="card long">
	   <div class="card-thumb" style="background:url(\'' . $uploads['url'] . '/' . $image . '\');\"></div>
	   </div>
	   <div class="card-header">
		<h1 class="entry-title">' . $title . '</h1>
		<div class="entry-info">' . $by . ' ∙ ' . $year . ' ∙ ' . '<a href="' . $site . '">'. __( Web, 'otevrioci' ) .'</a></div>
	   </div>
	   <div class="card-info">' . $content . '</div>
	  </div>';
}

add_shortcode("book", "book");

//Shortcode for map
function map($atts, $content = null) {
  extract(shortcode_atts(array(
    'bbox' => '14.425312,50.086432,14.431733,50.089588',
    'marker' => '50.08798,14.42842'
  ), $atts));
return '<iframe class="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox='. $bbox .'&amp;layer=mapnik&amp;marker=' . $marker . '"></iframe>';  
}

add_shortcode("map", "map");
?>
