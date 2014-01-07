<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */
/*
Template Name: Categories
*/
?>

<?php get_header(); ?>

<div id="main">

  <section>
    <h2>Browse All Categories</h2>
    <ul>
      <?php wp_list_categories( array('title_li'=>'') ); ?>
    </ul>
  </section>

</div>

<?php get_footer(); ?>
