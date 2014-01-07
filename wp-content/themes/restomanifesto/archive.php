<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */

get_header(); ?>

<div id="main" role="main" class="clearfix">

	<section>
		<?php if (have_posts()) : ?>
		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
    	<hgroup><h2 class="pagetitle"><?php single_cat_title(); ?></h2><h3>Category</h3></hgroup>
    	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
    	<hgroup><h2 class="pagetitle"><?php single_tag_title(); ?></h2><h3>Tag</h3></hgroup>
    	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    	<hgroup><h2 class="pagetitle"><?php the_time('F jS, Y'); ?></h2><h3>Day</h3></hgroup>
    	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    	<hgroup><h2 class="pagetitle"><?php the_time('F, Y'); ?></h2><h3>Month</h3></hgroup>
    	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    	<hgroup><h2 class="pagetitle"><?php the_time('Y'); ?></h2><h3>Year</h3></hgroup>
    	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
    	<hgroup><h2 class="pagetitle"><?php the_author(); ?></h2><h3>Author</h3></hgroup>
    	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    	<h2 class="pagetitle">Blog Archives</h2>
    	<?php } endif; ?>
    	
    	<?php get_template_part('loop'); ?>
  
  	</section>

</div>

<?php get_footer(); ?>
