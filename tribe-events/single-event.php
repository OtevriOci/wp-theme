<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 * 
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @since  2.1
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

$event_id = get_the_ID();
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- Post banner -->
	<?php if ( has_post_thumbnail() && $thumb[1] > $thumb[2])
		//If width > height, show a banner
		echo '<div class="entry-banner" style="background:url(\''.$thumb[0].'\');\"></div>';
	?>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-info tribe-events-schedule updated published tribe-clearfix">
		<?php echo_my_tribe_meta(); ?>
		</div>
	</header>
	<div class="entry-content">
	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('vevent'); ?>>
			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content entry-content description">
				<?php the_content(); ?>
			</div><!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

			<!-- Event poster -->
			<?php if ( has_post_thumbnail() && $thumb[2] >= $thumb[1]) {
				echo '<div class="event-poster"><a href="'.$thumb[0].'">';
				the_post_thumbnail('large');
				echo '</a></div>';
			} ?>

			</div><!-- .hentry .vevent -->
		<?php if( get_post_type() == TribeEvents::POSTTYPE && tribe_get_option( 'showComments','no' ) == 'yes' ) { comments_template(); } ?>
	<?php endwhile; ?>

	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
</article><!-- #tribe-events-content -->
