<?php
/*
Plugin Name: JR Post Image
Plugin URI: http://www.jacobras.nl/wordpress/post-image/
Description: Displays an image 'attached' to a post in a SEO friendly way. Use jr_post_image($id) in The Loop.
Version: 1.6.2
Author: Jacob Ras
Author URI: http://www.jacobras.nl

	Copyright 2009  Jacob Ras  (email : info@jacobras.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

--------------------

~ Changelog:
v1.6.2 (November 7, 2009)
- Fixed non-correct closure of image link

v1.6.1 (November 7, 2009)
- Fixed xHTML error when using default image
- Fixed problem where only </a> was showed when there was no image attached

v1.6 (November 6, 2009)
- Added option to disable the post image for a specific post / page
- Fixed bug where default image won't show up

v1.5 (October 24, 2009)
- Fixed linking feature, now links to image in single.php and links to post in index.php
- Fixed lightbox feature

v1.4 (September 21, 2009)
- Fixed configuration page layout problem
- Using array instead of vars for settings
- Use post-title as default image alt text to use the title of the post/page

v1.3 (September 19, 2009)
- Added post/page image list functionality
- Added Lightbox support
- Added option to skip first image

v1.1 (September 19, 2009)
- Added admin configuration page

v1.0 (September 17, 2009)
- First final release

*/

function jr_post_image($id) {
	
	$jr = get_option('jr_post_image');
	$files = get_children("post_parent=$id&post_type=attachment&post_mime_type=image");
	//if($jr['make_link'] == 'on') { echo '<a href="'; if (is_single()) { echo get_permalink(); } else { echo 'oi'; } echo '" title="' . get_the_title() . '">'; }
	
	if (get_post_meta($id, 'jr_nopostimage', true) != 'true' || is_home()) {
		if ($files) {
			$keys = array_keys($files);
			$i = 0;
			$img_id = $keys[0];
			$img = wp_get_attachment_image_src($img_id, $size=$jr['image_size']);
			$img_large = wp_get_attachment_image_src($img_id, $size='full');
			$alt_tag = $files[$img_id]->post_title;
			if($jr['make_link'] == 'on') { echo '<a href="'; if (is_single()) { echo $img_large[0]; } else { echo get_permalink(); } echo '"';
			if ($jr['enable_lightbox'] == 'on' && !is_home()) { echo ' rel="lightbox"'; }
			echo ' title="' . get_the_title() . '">'; }
			echo '<img src="' . $img[0] . '" width="' . $img[1] . '" height="' . $img[2] . '" alt="' . $alt_tag . '" class="jr-post-img" />';
			if($jr['make_link'] == 'on') { echo '</a>'; }
		} else {
			if (!empty($jr['default_url'])) {
				if($jr['make_link'] == 'on') { echo '<a href="'; echo get_permalink(); echo '" title="' . get_the_title() . '">'; }
				echo '<img src="' . $jr['default_url'] . '" alt="';
				if($default_image_alt == 'post-title') { echo get_the_title(); } else { echo $jr['default_alttext']; }
				echo '" />';
				if($jr['make_link'] == 'on') { echo '</a>'; }
			}
		}
	}
}

function jr_post_image_list($id, $number_of_images) {
	
	$jr = get_option('jr_post_image');
	$files = get_children("post_parent=$id&post_type=attachment&post_mime_type=image");
	
	if ($files) {
		$keys = array_keys($files);
		if ($jr['skip_first'] == 'on') { $i = 1; } else { $i = 0; }
		$aantal_bijlagen = count($files);
		
		while($i < $number_of_images) {
			$afb_id = $keys[$i];
			$afb = wp_get_attachment_image_src($afb_id, $size='thumbnail');
			$afb_groot = wp_get_attachment_image_src($afb_id, $size='full');
			$alt_tag = $files[$afb_id]->post_title;
			echo $jr['image_before_sp'];
			
			if($jr['make_link_sp'] == 'on') {
				echo '<a href="' . $afb_groot[0] . '" ';
				if ($jr['enable_lightbox'] == 'on') { echo 'rel="lightbox[]" '; }
				echo 'title="' . $alt_tag . '">';
			}
			
			echo '<img src="' . $afb[0] . '" width="' . $afb[1] . '" height="' . $afb[2] . '" alt="' . $alt_tag . '" />';
			if($jr['make_link_sp'] == 'on') { echo '</a>'; }
			echo $jr['image_after_sp'];
			$i++;
		}
		
	} else {
		if (!empty($jr['default_url_sp'])) {
			echo '<img src="' . $jr['default_url_sp'] . '" alt="';
			
			if($jr['default_alttext'] == 'post-title') { echo get_the_title(); } else { echo $jr['default_alttext']; }
			echo '"" />';
		}
	}
	
}

function jr_post_image_admin() { ?>
	
	<div class="wrap">
		<a href="http://www.jacobras.nl"><img src="http://www.jacobras.nl/logo-32.png" width="32" height="32" style="float:left;margin:14px 6px 0 6px;" alt="" /></a>
		<h2>JR Post Image Options</h2>
		
		<?php if($_POST['jr_hidden'] == 'Y') {
			$jr['default_url'] = $_POST['jr_default_url'];
			$jr['default_url_sp'] = $_POST['jr_default_url_sp'];
			$jr['default_alttext'] = $_POST['jr_default_alttext'];
			$jr['image_size'] = $_POST['jr_image_size'];
			$jr['make_link'] = $_POST['jr_make_link'];
			$jr['make_link_sp'] = $_POST['jr_make_link_sp'];
			$jr['enable_lightbox'] = $_POST['jr_enable_lightbox'];
			$jr['skip_first'] = $_POST['jr_skip_first'];
			$jr['image_before_sp'] = stripslashes(html_entity_decode($_POST['jr_image_before_sp']));
			$jr['image_after_sp'] = stripslashes(html_entity_decode($_POST['jr_image_after_sp']));
			update_option('jr_post_image', $jr);
			$jr['image_before_sp'] = htmlentities($jr['image_before_sp']);
			$jr['image_after_sp'] = htmlentities($jr['image_after_sp']);
			?>
			<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
			<?php
		} else {
			$jr = get_option('jr_post_image');
			$jr['image_before_sp'] = htmlentities($jr['image_before_sp']);
			$jr['image_after_sp'] = htmlentities($jr['image_after_sp']);
		} ?>
		
		<div class="postbox-container" style="width:70%;"><div class="metabox-holder">
			<form action="" method="post">
			<input type="hidden" name="jr_hidden" value="Y" />
				<div class="postbox">
					<h3><span>Settings for JR Post Image</span></h3>
					<div class="inside">
						<table class="form-table">
							<tr>
								<th valign="top">
									<label>Default image URL:</label><br/>
									<small>Ex: http://www.site.com/noimage.jpg . Leave empty if no image should be showed</small>
								</th>
								<td valign="top"><input type="text" name="jr_default_url" value="<?php echo $jr['default_url']; ?>" size="50" /></td>
							</tr>
							<tr>
								<th valign="top">
									<label>Image list default image URL:</label><br/>
									<small>Ex: http://www.site.com/noimage.jpg . Leave empty if no image should be showed</small>
								</th>
								<td valign="top"><input type="text" name="jr_default_url_sp" value="<?php echo $jr['default_url_sp']; ?>" size="50" /></td>
							</tr>
							<tr>
								<th valign="top">
									<label>Default image alt text:</label><br/>
									<small>Use <strong>post-title</strong> to use the title of the post/page</small>
								</th>
								<td valign="top"><input type="text" name="jr_default_alttext" value="<?php echo $jr['default_alttext']; ?>" size="40" /></td>
							</tr>
							<tr>
								<th valign="top">
									<label>Image size:</label>
								</th>
								<td valign="top">
									<select name="jr_image_size">
										<option <?php if($jr['image_size'] == 'thumbnail') { echo 'selected="selected"'; } ?> value="thumbnail">Thumbnail&nbsp;&nbsp;&nbsp;</option>
										<option <?php if($jr['image_size'] == 'full') { echo 'selected="selected"'; } ?> value="full">Full size&nbsp;&nbsp;&nbsp;</option>
									</select>
								</td>
							</tr>
							<tr>
								<th valign="top">
									<label>Make single image link:</label><br/>
									<small>Makes the single image clickable, links to the post/page</small>
								</th>
								<td valign="top">
									<input type="checkbox" name="jr_make_link" <?php if ($jr['make_link']) { echo 'checked="checked"'; } ?> />
								</td>
							</tr>
							<tr>
								<th valign="top">
									<label>Make list image link:</label><br/>
									<small>Makes the list image clickable, links full-size image</small>
								</th>
								<td valign="top">
									<input type="checkbox" name="jr_make_link_sp" <?php if ($jr['make_link_sp']) { echo 'checked="checked"'; } ?> />
								</td>
							</tr>
							<tr>
								<th valign="top">
									<label>Enable Lightbox:</label><br/>
									<small>Enables Lightbox for the image list (<a href="http://www.jacobras.nl/how-to-install-lightbox/">How to install</a>)</small>
								</th>
								<td valign="top">
									<input type="checkbox" name="jr_enable_lightbox" <?php if ($jr['enable_lightbox']) { echo 'checked="checked"'; } ?> />
								</td>
							</tr>
							<tr>
								<th valign="top">
									<label>Skip first image in list:</label>
								</th>
								<td valign="top">
									<input type="checkbox" name="jr_skip_first" <?php if ($jr['skip_first']) { echo 'checked="checked"'; } ?> />
								</td>
							</tr>
							<tr>
								<th valign="top">
									<label>Code before image in list:</label><br/>
									<small>Code that will be showed before the image, like &lt;div class="image"&gt;</small>
								</th>
								<td valign="top"><input type="text" name="jr_image_before_sp" value="<?php echo $jr['image_before_sp']; ?>" size="40" /></td>
							</tr>
							<tr>
								<th valign="top">
									<label>Code after image in list:</label><br/>
									<small>Code that will be showed after the image, like &lt;/div&gt;</small>
								</th>
								<td valign="top"><input type="text" name="jr_image_after_sp" value="<?php echo $jr['image_after_sp']; ?>" size="40" /></td>
							</tr>
						</table>
						<div style="margin:20px 0 12px 0;padding-left:12px;"><input type="submit" class="button-primary" name="submit" value="Save settings" /></div>
					</div>
				</div>
			</form>
		</div></div>
		
		<div class="postbox-container" style="width:20%;">
			<div class="metabox-holder">
				<div class="postbox">
					<h3><span>Need help?</span></h3>
					<div class="inside" style="padding:0 12px;">
						<p>If you have any problems with this plugin or good ideas for improvements or new features, please <a href="http://www.jacobras.nl/contact/">let me know</a>.</p>
					</div>
				</div>
				
				<div class="postbox">
					<h3><span>Like this plugin?</span></h3>
					<div class="inside" style="padding:0 12px;">
						<p>Why don't you:</p>
						
						<a href="http://www.jacobras.nl/wordpress/" style="padding:4px;display:block;padding-left:25px;background-repeat:no-repeat;background-position:2px 50%;text-decoration:none;border:none;background-image:url(http://www.jacobras.nl/logo-16.png);">Check out my other handy plugins</a>
						
						<a href="http://wordpress.org/extend/plugins/jr-post-image/" style="padding:4px;display:block;padding-left:25px;background-repeat:no-repeat;background-position:2px 50%;text-decoration:none;border:none;background-image:url(http://www.jacobras.nl/logo-16.png);">Vote for the plugin on WordPress.org.</a>
						
						<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=F8RVLT4RZTVJY&lc=NL&item_name=Jacob%20Ras&item_number=JR%20Post%20Image&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted"style="padding:4px;display:block;padding-left:25px;background-repeat:no-repeat;background-position:2px 50%;text-decoration:none;border:none;background-image:url(http://www.jacobras.nl/logo-16.png);">Donate a token of your appreciation.</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<?php }

function jr_post_image_configpagina() {
	add_options_page("JR Post Image", "JR Post Image", 1, "jr-post-image", "jr_post_image_admin");  
}


// default settings
$jr 					= array();
$jr['default_url']		= '';
$jr['default_url_sp']	= '';
$jr['default_alttext']	= 'post-title';
$jr['image_size']		= 'thumbnail';
$jr['make_link']		= 'on';
$jr['make_link_sp']		= 'on';
$jr['enable_lightbox']	= 'off';
$jr['skip_first']		= 'off';
$jr['image_before_sp']	= '';
$jr['image_after_sp']	= '';
add_option('jr_post_image', $jr);
add_action('admin_menu', 'jr_post_image_configpagina');
?>