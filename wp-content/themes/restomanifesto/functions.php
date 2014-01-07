<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */

// Custom HTML5 Comment Markup
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li>
     <article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
       <header class="comment-author vcard">
          <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
          <time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></time>
          <?php edit_comment_link(__('(Edit)'),'  ','') ?>
       </header>
       <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>

       <?php comment_text() ?>

       <nav>
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
       </nav>
     </article>
    <!-- </li> is added by wordpress automatically -->
<?php
}

add_theme_support('automatic-feed-links');

// Widgetized Sidebar HTML5 Markup
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<section>',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

// Custom Functions for CSS/Javascript Versioning
$GLOBALS["TEMPLATE_URL"] = get_bloginfo('template_url')."/";
$GLOBALS["TEMPLATE_RELATIVE_URL"] = wp_make_link_relative($GLOBALS["TEMPLATE_URL"]);

// Add ?v=[last modified time] to style sheets
function versioned_stylesheet($relative_url, $add_attributes=""){
  echo '<link rel="stylesheet" href="'.versioned_resource($relative_url).'" '.$add_attributes.'>'."\n";
}

// Add ?v=[last modified time] to javascripts
function versioned_javascript($relative_url, $add_attributes=""){
  echo '<script src="'.versioned_resource($relative_url).'" '.$add_attributes.'></script>'."\n";
}

// Add ?v=[last modified time] to a file url
function versioned_resource($relative_url){
  $file = $_SERVER["DOCUMENT_ROOT"].$relative_url;
  $file_version = "";

  if(file_exists($file)) {
    $file_version = "?v=".filemtime($file);
  }

  return $relative_url.$file_version;
}

// Add featured image support
add_theme_support( 'post-thumbnails' );

// Register WP3 custom menu
if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menu( 'main-nav', 'Main Navigation Menu' );
	register_nav_menu( 'footer-menu', 'Footer Menu' );
	register_nav_menu( 'contact-menu', 'Contact Menu' );
}

// Excerpt construction

// Set the maximum length of an excerpt here
function new_excerpt_length($length) {
	return 200;
}
add_filter('excerpt_length', 'new_excerpt_length');

// Call this function with get_the_excerpt() as first parameter so that the
// template can use varied excerpt lengths (don't use the_excerpt())
function smart_excerpt($string, $limit) {
	global $post;
    $words = explode(" ",$string);
    if ( count($words) >= $limit) $tail = '...';
    echo implode(" ",array_splice($words,0,$limit)).$tail;
}

// Modify the post_class() call to set separate styles for the rows of articles on first page
function add_classes_home_rows($classes) {
	if (is_home()) {
		global $wp_query;
		if ($wp_query->current_post <= 1) {
			// First row
			$classes[] = 'first-row';
		} else {
			// Second row
			$classes[] = 'second-row';
		}
		return $classes;
	}
}
add_filter('post_class', 'add_classes_home_rows');

// Modify The Loop to allow for offsets and paging
function offset_and_pagination_support($limit) {
	global $wp_query;
	
	// If we weren't doing pagination, then we can keep the same behvior by saying this is page 1
	$wp_query->set('paged', (get_query_var('paged')) ? get_query_var('paged') : 1);
	
	$page = intval(get_query_var('paged'));
	if (get_query_var('offset') && get_query_var('posts_per_page')) {
		$offset = intval(get_query_var('offset'));
		$postsperpage_q = intval(get_query_var('posts_per_page'));
		
		// Find starting point
		$strt = (($page-1) * $postsperpage_q) + $offset;
		
		// Find length
		if (($strt-$offset) + $postsperpage_q > intval(get_option('posts_per_page'))) {
			$length = intval(get_option('posts_per_page')) - ($strt-$offset);
		} else {
			$length = $postsperpage_q;
		}
		
		$limit = 'LIMIT '.$strt.', '.$length;
	}
	return $limit;
}
add_filter('post_limits', 'offset_and_pagination_support');

// Set Thumbnail size
set_post_thumbnail_size(215,170,TRUE);
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'post-gallery-thumb', 90, 90 );
}


// Logging used for debug
if(!function_exists('_log')){
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  }
}

// Add logo to emails on contact form
function add_logo_to_emails($mail) {
  require_once ABSPATH . WPINC . '/class-phpmailer.php';
	require_once ABSPATH . WPINC . '/class-smtp.php';
  
  //$imageURL = get_stylesheet_directory_uri() . '/images/logo-email.jpg';
  $imageURL = dirname(__FILE__) . '/images/logo-email.jpg';
  
  $mail->AddEmbeddedImage($imageURL, 'logoimg', $imageURL);
  
  return $mail;
}
add_action('phpmailer_init', 'add_logo_to_emails');
