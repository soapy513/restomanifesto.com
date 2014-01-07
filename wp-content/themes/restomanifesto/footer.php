<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */
?>
</div> <!--! end of #container -->
<div id="footer-container">
	<footer>
	      <section>
	      	<h2 class="ir"><?php bloginfo('name'); ?> Other Links</h2>
	      	<?php wp_nav_menu(array('theme_location' => 'footer-menu', 'container' => '' )); ?>
	      </section>
	      <section id="twitter">
	      	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: 'profile',
			  rpp: 4,
			  interval: 6000,
			  width: 296,
			  height: 100,
			  theme: {
			    shell: {
			      background: '#333333',
			      color: '#ffffff'
			    },
			    tweets: {
			      background: '#000000',
			      color: '#ffffff',
			      links: '#a80000'
			    }
			  },
			  features: {
			    scrollbar: false,
			    loop: false,
			    live: true,
			    hashtags: true,
			    timestamp: true,
			    avatars: false,
			    behavior: 'all'
			  }
			}).render().setUser('restomanifesto').start();
			</script>
	      </section>
	      <section>
	      <ul><?php wp_list_bookmarks(); ?></ul>
	      </section>
	      <!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
	      <p class="copyright">&copy;2009-<?php echo date("Y"); ?> RestoManifesto. All Rights Reserved.</p>
	</footer>
</div>

  <!-- Javascript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="<?php echo $GLOBALS["TEMPLATE_RELATIVE_URL"] ?>html5-boilerplate/js/jquery-1.4.2.min.js"><\/script>')</script>


  <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."html5-boilerplate/js/plugins.js") ?>
  <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."html5-boilerplate/js/script.js") ?>


  <!--[if lt IE 7 ]>
    <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."html5-boilerplate/js/dd_belatedpng.js") ?>
  <![endif]-->


  <!-- yui profiler and profileviewer - remove for production -->
  <!-- <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."html5-boilerplate/js/profiling/yahoo-profiling.min.js") ?>
    <?php versioned_javascript($GLOBALS["TEMPLATE_RELATIVE_URL"]."html5-boilerplate/js/profiling/config.js") ?> -->
  <!-- end profiling code -->


  <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet
       change the UA-XXXXX-X to be your site's ID -->
  <!-- WordPress does not allow Google Analytics code to be built into themes they host. 
       Add this section from HTML Boilerplate manually (html5-boilerplate/index.html), or use a Google Analytics WordPress Plugin-->
   <script>
    var _gaq = [['_setAccount', 'UA-20334324-1'], ['_trackPageview']];
    (function(d, t) {
     var g = d.createElement(t),
         s = d.getElementsByTagName(t)[0];
     g.async = true;
     g.src = '//www.google-analytics.com/ga.js';
     s.parentNode.insertBefore(g, s);
    })(document, 'script');
   </script>

  <?php wp_footer(); ?>

</body>
</html>
