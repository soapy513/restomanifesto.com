<?php if (is_home()) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
		query_posts('posts_per_page=5&paged='.$paged); } ?>
		
<?php if (is_search()): ?><h2>Search Results</h2><?php endif; ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
	  
	  <?php if(is_home() && $wp_query->current_post == 2):?><hr /><?php endif; ?>
      
      <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <header class="clearfix">
          <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
          <?php if (!is_page()) : ?>
          <time datetime="<?php the_time('Y-m-d')?>"><?php the_time('F jS, Y') ?></time>
          <p><?php the_category(', ') ?></p>
          <p><?php comments_popup_link('0', '1', '%', 'comments-number', 'Off'); ?></p>
          <?php global $wp_query; if($wp_query->current_post < 2 && is_home() && has_post_thumbnail()) the_post_thumbnail(); ?>
          <?php if(is_single()) { jr_post_image_list($id); } endif; ?>
        </header>
        
        <?php if (is_single() || is_page()) {
        		the_content();
        	  } else {
        		echo '<p>'; smart_excerpt(get_the_excerpt(), 100); echo '</p>';
        	  }?>
        
        <footer>
          <p><?php if (!(is_single() || is_page())) : ?>
          	 	<a href="<?php the_permalink() ?>" rel="bookmark" title="Read More of <?php the_title() ?>">Read More</a>
          	 <?php endif; ?>
          </p>
        </footer>
        
        <?php if(is_single() || is_page()) { comments_template(); }?>
        
      </article>

    <?php endwhile; ?>

<?php else : ?>
    
    <?php if ( is_category() ) { // If this is a category archive
    	printf("<h2>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
  	} else if ( is_date() ) { // If this is a date archive
    	echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
  	} else if ( is_author() ) { // If this is a category archive
    	$userdata = get_userdatabylogin(get_query_var('author_name'));
    	printf("<h2>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
    } else if ( is_search() ) { // If this is a search results page ?>
    	 <h2>No posts found. Try a different search?</h2> <?php
  	} else { ?>
    	<h2>Not Found</h2>
    	<p>Sorry, but you are looking for something that isn't here.</p>
  	<?php } get_search_form(); ?>

<?php endif; ?>
