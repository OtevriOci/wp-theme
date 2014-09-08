<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		<?php if ( have_posts() ) : ?>
		<?php $upcoming_posts = array(); ?>

			<?php /* The Loop */
			/* Upcoming events */
			$upcoming_query = new WP_Query( array( 'post_type' => 'tribe_events', 'meta_key'=>'_EventStartDate', 'orderby'=>'_EventStartDate', 'order' => 'ASC', 'eventDisplay' => 'upcoming', 'paged' => ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 ) ) );

			while ( $upcoming_query->have_posts() )
			{
				$upcoming_query->the_post();
				$upcoming_posts[] = $post->ID;
				get_template_part( 'content', get_post_format() );
			}
			
			wp_reset_postdata();
			
			/* The rest */
			$curr_year = 0;

			while ( have_posts() )
			{
				the_post();
				if ( in_array($post->ID, $upcoming_posts) )
					continue;

				$event_year = tribe_is_event() ? tribe_get_start_date( $post, false, 'Y' ) : get_the_time( 'Y', $post );
				if ( $event_year != $curr_year )
				{
					if ($curr_year == 0)
						echo '<h1 class="year">--- ' . $event_year . ' ---</h1>';
					else
						echo '<h1 class="year">' . $event_year . '</h1>';

					$curr_year = $event_year;
				}
				
				get_template_part( 'content', get_post_format() );
			}
			?>

			<?php otevrioci_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'No posts to display', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'twentytwelve' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

			<?php else :
				// Show the default message to everyone else.
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; // end current_user_can() check ?>

			</article><!-- #post-0 -->

		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
