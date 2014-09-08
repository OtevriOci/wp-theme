 <?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<!-- SINGLE POST -->
  <?php if ( is_single() ) : ?>
     <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
		echo '<div class="entry-banner" style="background:url(\''.$thumb[0].'\');\"></div>';
	} ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<p class="subtitle"><?php $subtitle = get_post_meta($post->ID, 'subtitle', $single = true);
		if($post->post_type == 'post' && $subtitle != '') echo $subtitle; ?></p>
	</header>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
	</div>
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
     </article>
<!-- #single post -->

<!-- POST LOOP -->

  <?php else : ?>

	<a id="post-<?php the_ID(); ?>"  href="<?php the_permalink(); ?>" class="card stacked <?php if ( ( (tribe_is_event()) && (tribe_get_days_between(tribe_get_end_date(),date()) < 1) ) ) echo 'highlight'; ?>">
	 <div class="card-badge">
	  <?php if(tribe_is_event()): ?>
	   <?php if(get_post_meta(get_the_ID(), 'repeat', true) == 'weekly'): ?>
	    <div class="day"><?php echo tribe_get_start_date( null, false, 'D' ); ?></div>
	   <?php elseif(tribe_is_multiday()): ?>
	    <div class="day"><?php echo tribe_get_start_date( null, false, 'j. n.' ); ?><br /> - <br /><?php echo tribe_get_end_date( null, false, 'j. n.' ); ?></div>
	   <?php else: ?>
	    <div class="day"><?php echo tribe_get_start_date( null, false, 'j. n.' ); ?></div>
	   <?php endif; ?>
	  <?php else: ?>
	   <?php if($post->post_type == 'page'): ?><span class="fontello"></span> <!-- DOES NOT WORK, NEED TO FIX -->
	   <?php else: ?><span class="fontello"></span>
	   <?php endif; ?>
	  <?php endif; ?>
	 </div>

	 <div class="card-content">
	  <header class="card-header">
	   <h1 class="entry-title">
	    <?php the_title(); ?>
	   </h1>
	  </header>
	  <div class="card-info">
	   <div class="entry-info">
	   <?php if(tribe_is_event()) echo_my_tribe_meta();
	   else {
	    $subtitle = get_post_meta($post->ID, 'subtitle', $single = true);
	    if($post->post_type == 'post' && $subtitle != '') echo "<em>" . $subtitle . "</em>";
	   };
	   ?>
	   </div>
	  </div>
	 </div>
	 <?php if ( has_post_thumbnail() ) {
	  $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail', false );
	  echo '<div class="card-thumb" style="background:url(\''.$thumb[0].'\');\"></div>';
	 } ?>
	</a>

  <?php endif; ?>
<!-- #post loop -->
