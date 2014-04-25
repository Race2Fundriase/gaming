<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'library/bones.php' ); // if you remove this, bones will break
/*
2. library/custom-post-type.php
	- an example custom post type
	- example custom taxonomy (like categories)
	- example custom taxonomy (like tags)
*/
require_once( 'library/custom-post-type.php' ); // you can disable this if you like
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once( 'library/admin.php' ); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once( 'library/translation/translation.php' ); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<?php // custom gravatar call ?>
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<?php // end custom gravatar call ?>
				<?php printf(__( '<cite class="fn">%s</cite>', 'bonestheme' ), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>
				<?php edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'bonestheme' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'bonestheme' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
} // don't remove this bracket!

//No Button Search
function nobtn_search($form) {
	$searchtxt = "search";
	
	$form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '">
	<input type="text" value="'.$searchtxt.'" name="s" id="s" onblur="if (this.value == "' . $searchtxt . '") {this.value == "" }" />
	<input type="hidden" id="searchsubmit"/>
	</form>';
	return $form;
}

/************* Login Button on Main Nav ***********/
//Add login/logout link to naviagation menu
function add_login_out_item_to_menu( $items, $args ){

	//change theme location with your them location name
	if( is_admin() ||  $args->theme_location != 'main-nav' )
		return $items; 
	
	$redirect = ( is_home() ) ? false : get_permalink();
	
	$new_links = array();
	
	/* if (is_front_page() ) {
	$item = array(
		'title' => 'Sign up',
		'menu_item_parent' => 0,
		'ID' => 'signup',
		'db_id' => '',
		'url' => '/join',
		'classes' => 'menu-item sign-up'
		      );
	} else { */
	 $item = array(
		'title' => 'Enter Now',
		'menu_item_parent' => 0,
		'ID' => 'signup',
		'db_id' => '',
		'url' => '/races',
		'classes' => 'menu-item sign-up'
		      );
	// }
	$new_links[] = (object) $item;
	unset ($item);
	
	array_splice($items, 4, 0, $new_links);
	unset ($new_links);
	
	
	
	if( is_user_logged_in( ) ) {
		$label = 'Logout';
		$link = wp_logout_url($redirect);
	}
	else
	{
		$label = 'Login';
		$link = wp_login_url($redirect);
	
	}
	
	$item = array (
			'title' => $label,
			'menu_item_parent' =>0,
			'ID' => 'loginout',
			'db_id' => '',
			'url' => $link,
			'classes' => 'menu-item log-in-out'
		);
	
	$new_links[] = (object) $item;
	unset($item);
	
	$index = count( $items );  // Insert before the last two items

	// Insert the new links at the appropriate place.
	array_splice( $items, $index, 0, $new_links );
	
	return $items;//.= '<li id="log-in-out-link" class="menu-item menu-type-link">'. $link . '</li>';

} add_filter( 'wp_nav_menu_objects', 'add_login_out_item_to_menu', 50, 2 );

/**************YOUTUBE META BOX******************************/

add_action( 'add_meta_boxes', 'featuredVideo_add_custom_box' );
add_action( 'save_post', 'featuredVideo_save_postdata' );

function featuredVideo_add_custom_box() {
    add_meta_box(  'featuredVideo_sectionid', 'Featured Video', 'featuredVideo_inner_custom_box', 'page', 'side' );
}

function featuredVideo_inner_custom_box( $post ) {
    wp_nonce_field( plugin_basename( __FILE__ ), 'featuredVideo_noncename' );
 
    // show featured video if it exists
    echo getFeaturedVideo( $post->ID, 260, 120);   
 
    echo '<h4 style="margin: 10px 0 0 0;">URL [YouTube Only]</h4>';
    echo '<input type="text" id="featuredVideoURL_field" name="featuredVideoURL_field" value="'.get_post_meta($post->ID, 'featuredVideoURL', true).'" style="width: 100%;" />';
}

function featuredVideo_save_postdata( $post_id ) {
 
    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
 
    // check authorizations
    if ( !wp_verify_nonce( $_POST['featuredVideo_noncename'], plugin_basename( __FILE__ ) ) )
      return;
 
    // update meta/custom field
    update_post_meta( $post_id, 'featuredVideoURL', $_POST['featuredVideoURL_field'] );
}

function getFeaturedVideo($post_id, $width = 680, $height = 360) {
    $featuredVideoURL = get_post_meta($post_id, 'featuredVideoURL', true);
 
    preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $featuredVideoURL, $youTubeMatch);
 
    if ($youTubeMatch[1])
        return '<iframe width="'.$width.'" height="'.$height.'" src="http://ww'.
               'w.youtube.com/embed/'.$youTubeMatch[1].'?rel=0&showinfo=0&cont'.
               'rols=0&autoplay=0&modestbranding=1" frameborder="0" allowfulls'.
               'creen ></iframe>';
    else
        return null;
}

require_once( 'functions-game.php' );

//Wordpress Login Page

function custom_login() {
	echo'<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/library/css/custom-login.css"/>';
	echo'<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/library/css/style.css"/>';
}

add_action('login_head', 'custom_login');

function loginpage_custom_link() {
	return 'http://race2fundraise.com';
}
add_filter('login_headerurl','loginpage_custom_link');

function change_title_on_logo() {
	return 'R2F - Join The Race To Fundraise';
}
add_filter('login_headertitle', 'change_title_on_logo');


function my_added_login_field(){
    //Output your HTML
?>
  
	<div class="inner-container wrap">
		<div class="sixcol first text-center">
		<a href="http://race2fundraise.com/join/" class="btn medium">Register Charity or Fundraiser</a>
		</div>
		
		<div class="sixcol first text-center">
		<a href="#" class="btn medium">Register As Individual</a>
		</div>
	</div>
   
<?php
}

add_action('login_footer','my_added_login_field');
?>