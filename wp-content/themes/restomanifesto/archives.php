<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="main">

  <aside>

    <section>
      <h2>Archives by Month:</h2>
      <ul>
        <?php wp_get_archives('type=monthly'); ?>
      </ul>
    </section>

    <section>
      <h2>Archives by Subject:</h2>
      <ul>
        <?php wp_list_categories( array('title_li'=>'') ); ?>
      </ul>
    </section>

  </aside>

  <section>
    <h2>All Reviews</h2>
    <ul>
      <?php wp_get_archives('type=alpha'); ?>
    </ul>
  </section>


</div>

<?php get_footer(); ?>
