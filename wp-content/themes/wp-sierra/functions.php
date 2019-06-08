<?php

/*
	1. Load the Theme CSS
	2. Load the Theme JS
	3. Widgets
	4. Load functions
	5. Theme Support
	6. Register menus
  7. Kirki Customizer options
*/


if ( ! function_exists( 'wpsierra_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wpsierra_fs() {
        global $wpsierra_fs;

        if ( ! isset( $wpsierra_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $wpsierra_fs = fs_dynamic_init( array(
                'id'                  => '2565',
                'slug'                => 'wp-sierra',
                'type'                => 'theme',
                'public_key'          => 'pk_f008883de2d70aea803633df9636f',
                'is_premium'          => false,
                'has_addons'          => true,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'wpsierra',
                    'contact'        => false,
                    'support'        => false,
                    'parent'         => array(
                        'slug' => 'themes.php',
                    ),
                ),
            ) );
        }

        return $wpsierra_fs;
    }

    // Init Freemius.
    wpsierra_fs();
    // Signal that SDK was initiated.
    do_action( 'wpsierra_fs_loaded' );}


// 1. Load the Theme CSS
function wpsierra_styles()
{
    wp_enqueue_style( 'wp-mediaelement' );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
    wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/lightgallery.min.css' );
    wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
    wp_enqueue_style( 'wpsierra-main-css', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'wpsierra-theme-css', get_template_directory_uri() . '/css/theme.css' );
  	wp_add_inline_style( 'wpsierra-theme-css', wpsierra_gutenberg_colors() );
    wp_style_add_data( 'wpsierra-theme-css', 'rtl', 'replace' );
}

add_action( 'wp_enqueue_scripts', 'wpsierra_styles' );
// 2. Load the Theme JS
function wpsierra_js()
{
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'masonry' );
    wp_enqueue_script( 'wp-mediaelement' );
    wp_enqueue_script(
        'bootstrap',
        get_template_directory_uri() . '/js/bootstrap.min.js',
        array( 'jquery' ),
        '',
        true
    );
    //Required for nested reply function that moves reply inline with JS
    if ( is_singular() ) {
        wp_enqueue_script( 'comment-reply' );
    }
    wp_enqueue_script(
        'wpsierra-theme-js',
        get_template_directory_uri() . '/js/theme.js',
        array( 'jquery', 'bootstrap' ),
        '',
        true
    );
    wp_enqueue_script(
        'jquery-lightgallery',
        get_template_directory_uri() . '/js/lightgallery.min.js',
        array( 'jquery' ),
        '',
        true
    );
    wp_enqueue_script(
        'jquery-lg-fullscreen',
        get_template_directory_uri() . '/js/lg-fullscreen.min.js',
        array( 'jquery' ),
        '',
        true
    );
    wp_enqueue_script(
        'jquery-lg-video',
        get_template_directory_uri() . '/js/lg-video.min.js',
        array( 'jquery' ),
        '',
        true
    );
    wp_enqueue_script(
        'jquery-lg-zoom',
        get_template_directory_uri() . '/js/lg-zoom.min.js',
        array( 'jquery' ),
        '',
        true
    );
}

add_action( 'wp_enqueue_scripts', 'wpsierra_js' );
// 3. Widgets
// Function for creating Widegets
add_action( 'widgets_init', 'wpsierra_widgets_init' );
function wpsierra_widgets_init()
{
    function create_widget( $name, $id, $description )
    {
        register_sidebar( array(
            'name'          => $name,
            'id'            => $id,
            'description'   => $description,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title-style">',
            'after_title'   => '</h3>',
        ) );
    }

    //Create widgets
    create_widget( esc_html__( 'Blog Sidebar', 'wp-sierra' ), 'blog', 'Displays in the side navigation of blog posts and main blog page' );
    create_widget( esc_html__( 'Footer One', 'wp-sierra' ), 'footer-one', 'Displays first footer widget' );
    create_widget( esc_html__( 'Footer Two', 'wp-sierra' ), 'footer-two', 'Displays second footer widget' );
    create_widget( esc_html__( 'Footer Three', 'wp-sierra' ), 'footer-three', 'Displays third footer widget' );
    create_widget( esc_html__( 'Footer Four', 'wp-sierra' ), 'footer-four', 'Displays fourth footer widget' );
}

// 4. Load functions

// Welcome page
if ( file_exists( dirname( __FILE__ ) . '/admin/wpsierra-welcome.php' ) ) {
    require_once get_template_directory() . '/admin/wpsierra-welcome.php';
}

//WP Sierra Functions
require_once get_template_directory() . '/inc/sierra-functions.php';

// Required plugins
if ( file_exists( dirname( __FILE__ ) . '/admin/tgmpa/required-plugins.php' ) ) {
    get_template_part( 'admin/tgmpa/required-plugins' );
}

// 5. Theme Support
add_action( 'after_setup_theme', 'wpsierra_theme_setup' );
function wpsierra_theme_setup()
{
    /* Set the $content_width for things such as video embeds. */
    if ( !isset( $content_width ) ) {
        $content_width = 1200;
    }
    /* Add theme support for automatic feed links. */
    add_theme_support( 'automatic-feed-links' );
    /* Add theme support for post thumbnails (featured images). */
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ) );
    add_theme_support( 'editor-color-palette', array(

        array(
            'name' => esc_html__( 'Pale Pink', 'wp-sierra' ),
            'slug' => 'pale-pink',
            'color' => '#fcf0ef',
        ),

        array(
            'name' => esc_html__( 'Vivid Red', 'wp-sierra' ),
            'slug' => 'vivid-red',
            'color' => '#cf2e2e',
        ),

        array(
            'name' => esc_html__( 'Luminous vivid orange', 'wp-sierra' ),
            'slug' => 'luminous-vivid-orange',
            'color' => '#ff6900',
        ),

        array(
            'name' => esc_html__( 'Luminous vivid amber', 'wp-sierra' ),
            'slug' => 'luminous-vivid-amber',
            'color' => '#fcb900',
        ),

        array(
            'name' => esc_html__( 'Light green cyan', 'wp-sierra' ),
            'slug' => 'light-green-cyan',
            'color' => '#7bdcb5',
        ),

        array(
            'name' => esc_html__( 'Vivid green cyan', 'wp-sierra' ),
            'slug' => 'vivid-green-cyan',
            'color' => '#00d084',
        ),

        array(
            'name' => esc_html__( 'Pale cyan blue', 'wp-sierra' ),
            'slug' => 'pale-cyan-blue',
            'color' => '#8ed1fc',
        ),

        array(
            'name' => esc_html__( 'Vivid cyan blue', 'wp-sierra' ),
            'slug' => 'vivid-cyan-blue',
            'color' => '#0693e3',
        ),

        array(
            'name' => esc_html__( 'Very light gray', 'wp-sierra' ),
            'slug' => 'very-light-gray',
            'color' => '#eeeeee',
        ),

        array(
            'name' => esc_html__( 'Very dark gray', 'wp-sierra' ),
            'slug' => 'very-dark-gray',
            'color' => '#313131',
        ),

        array(
            'name' => esc_html__( 'Accent Color', 'wp-sierra' ),
            'slug' => 'wpsierra-accent',
            'color' => esc_html( get_theme_mod( 'accent_color', '#2962FF' ) ),
        ),

    ) );
}

if ( ! function_exists( 'wp_body_open' ) ) {
  function wp_body_open() {
    do_action( 'wp_body_open' );
  }
}


/**
 * Add custom colors to Gutenberg.
 */
function wpsierra_gutenberg_colors() {
	// Retrieve the accent color fro the Customizer.
	$accent = get_theme_mod( 'accent_color', '#2962FF' );
	// Build styles.
	$css  = '';
	$css .= '.has-wpsierra-accent-color { color: ' . esc_attr( $accent ) . ' !important; }';
	$css .= '.has-wpsierra-accent-background-color { background-color: ' . esc_attr( $accent ) . '; }';
	return wp_strip_all_tags( $css );
}
/**
 * Enqueue theme styles within Gutenberg.
 */
function wpsierra_gutenberg_styles() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'wpsierra-gutenberg', get_theme_file_uri( '/css/gutenberg.css' ), false, '', 'all' );
	// Add custom colors to Gutenberg.
	wp_add_inline_style( 'wpsierra-gutenberg', wpsierra_gutenberg_colors() );
}
add_action( 'enqueue_block_editor_assets', 'wpsierra_gutenberg_styles' );



load_theme_textdomain( 'wp-sierra', get_template_directory() . '/languages' );
//Registers an editor stylesheet for the theme.
function wpsierra_theme_add_editor_styles()
{
    add_editor_style( 'custom-editor-style.css' );
}

add_action( 'admin_init', 'wpsierra_theme_add_editor_styles' );
//Shortcodes in excerpt
add_filter( 'get_the_excerpt', 'shortcode_unautop' );
add_filter( 'get_the_excerpt', 'do_shortcode' );

// 6. Register menus
// Register nav menus
/* Add your nav menus function to the 'init' action hook. */
add_action( 'init', 'wpsierra_register_menus' );
function wpsierra_register_menus()
{
    register_nav_menus( array(
        'header-menu' => esc_html__( 'Header Menu', 'wp-sierra' ),
        'footer-menu' => esc_html__( 'Footer Menu', 'wp-sierra' ),
    ) );
}

// 7. Kirki Customizer options
if ( file_exists( dirname( __FILE__ ) . '/admin/kirki/kirki.php' ) ) {
    require_once get_template_directory() . '/admin/kirki/kirki.php';
}

// check for plugin using plugin name
if ( is_plugin_active( 'sierra-addons-pro/sierra-addons.php' ) ) {
  return;
} else {
  require_once get_template_directory() . '/inc/customizer-functions.php';
}
