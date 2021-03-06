<?php
/**
 * fourenergy functions and definitions
 *
 * @package fourenergy
 */

if ( ! function_exists( 'fourenergy_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fourenergy_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on fourenergy, use a find and replace
	 * to change 'fourenergy' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'fourenergy', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'products-thumb', 564, 390, true );
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Header Menu', 'fourenergy' ),
		'secondary' => esc_html__( 'Footer Menu', 'fourenergy' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'fourenergy_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // fourenergy_setup
add_action( 'after_setup_theme', 'fourenergy_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fourenergy_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fourenergy_content_width', 640 );
}
add_action( 'after_setup_theme', 'fourenergy_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function fourenergy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fourenergy' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'fourenergy_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function fourenergy_scripts() {
	wp_enqueue_style( 'fourenergy-style', get_stylesheet_uri() );

	wp_enqueue_script( 'fourenergy-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'fourenergy-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'bundle', get_template_directory_uri() . '/js/bundle.js', array(), '20150625', true );

}
add_action( 'wp_enqueue_scripts', 'fourenergy_scripts' );



function fourenergy_favicon() {
    echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_template_directory_uri().'/favicon.ico" />';
}
add_action('wp_head', 'fourenergy_favicon');

	
add_filter ("wp_mail_from", "my_awesome_mail_from");
function my_awesome_mail_from() {
	return "info@sonnsolar.com";
}
	
/*add_filter ("wp_mail_from_name", "my_awesome_mail_from_name");
function my_awesome_email_from_name() {
	return "Sonnsolar";
}*/
/**
 * Informar cuando alguien crea un post para revision
 */
function authorNotification($post_id) {
      global $wpdb;
      $post = get_post($post_id);
      $author = get_userdata($post->post_author);

      $message = "
         Hola Administrador,
         ".$author->display_name." Acaba de crear el articulo ".$post->post_title." pendiente de revisión. Puedes publicarlo si es correcto! 
      ";

      $user = get_user_by( 'login', '4energy' );

      wp_mail($user->user_email, "Se creó un articulo pendiente de revisión", $message);
   }
add_action('pending_post', 'authorNotification');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load Custom Post Types.
 */
require get_template_directory() . '/inc/cpt.php';