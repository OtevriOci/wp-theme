	</div><!-- #main .wrapper -->
   </div><!-- #page -->
<footer id="mastfoot">
<div id="footer-bg1"></div>
<div id="footer-bg2"></div>
<div id="footer-content">
  <a href="https://www.facebook.com/Otevrioci.official"><div class="fontello footerButton"></div></a>
  <a href="<?php bloginfo('rss2_url'); ?>"><div class="fontello footerButton"></div></a>
  <div class="email">
    <form action="http://groups.google.com/group/aktivitypraha/boxsubscribe">
      <input type=text name=email placeholder="<?php _e('Pražské akce emailem', 'otevrioci') ?>">
      <input type=submit name="sub" value="<?php _e('Zapsat se' , 'otevrioci' ) ?>">
    </form>
  </div>
  <div class="our_sites">
    <a href="http://veggie-parade.cz/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/banner-vp.png" /></a>
    <a href="http://www.goveg.cz/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/banner-gv.png" /></a>
  </div>
  <?php wp_footer(); ?>
</div>
</footer>
</div><!-- #abovethefold -->
</body>
</html>
