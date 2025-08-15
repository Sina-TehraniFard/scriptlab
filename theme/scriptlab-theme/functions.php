<?php
/**
 * ScriptLab functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ScriptLab
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function scriptlab_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on ScriptLab, use a find and replace
		* to change 'scriptlab' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'scriptlab', get_template_directory() . '/languages' );

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
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'scriptlab' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'scriptlab_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'scriptlab_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function scriptlab_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'scriptlab_content_width', 640 );
}
add_action( 'after_setup_theme', 'scriptlab_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function scriptlab_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'scriptlab' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'scriptlab' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'scriptlab_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function scriptlab_scripts() {
	wp_enqueue_style( 'scriptlab-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'scriptlab-style', 'rtl', 'replace' );

	// JavaScriptファイルが存在する場合のみ読み込み
	$navigation_js = get_template_directory() . '/js/navigation.js';
	if ( file_exists( $navigation_js ) ) {
		wp_enqueue_script( 'scriptlab-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'scriptlab_scripts' );

/**
 * Implement the Custom Header feature.
 */
$custom_header_file = get_template_directory() . '/inc/custom-header.php';
if ( file_exists( $custom_header_file ) ) {
	require $custom_header_file;
}

/**
 * Custom template tags for this theme.
 */
$template_tags_file = get_template_directory() . '/inc/template-tags.php';
if ( file_exists( $template_tags_file ) ) {
	require $template_tags_file;
}

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
$template_functions_file = get_template_directory() . '/inc/template-functions.php';
if ( file_exists( $template_functions_file ) ) {
	require $template_functions_file;
}

/**
 * Customizer additions.
 */
$customizer_file = get_template_directory() . '/inc/customizer.php';
if ( file_exists( $customizer_file ) ) {
	require $customizer_file;
}

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	$jetpack_file = get_template_directory() . '/inc/jetpack.php';
	if ( file_exists( $jetpack_file ) ) {
		require $jetpack_file;
	}
}