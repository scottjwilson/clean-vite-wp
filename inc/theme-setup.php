<?php
/**
 * Theme Setup
 *
 * Core theme configuration, menus, and theme supports.
 */

/**
 * Register theme supports and navigation menus
 */
function the_theme_setup(): void {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    register_nav_menus(array(
        'menuTop' => 'Top Navigation Menu',
    ));
}
add_action('after_setup_theme', 'the_theme_setup');

/**
 * Add preconnect hints for Google Fonts
 */
function the_theme_font_preconnect(): void {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'the_theme_font_preconnect', 1);

/**
 * Enqueue base styles and scripts
 */
function the_theme_enqueue_assets(): void {
    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap',
        array(),
        null
    );

    // Main stylesheet (required by WordPress)
    wp_enqueue_style('the-theme-style', get_stylesheet_uri());

    // Check if Vite handles assets
    if (function_exists('the_theme_detect_vite_server')) {
        $vite = the_theme_detect_vite_server();
        $has_manifest = file_exists(get_theme_file_path('dist/manifest.json'));

        if ($vite['running'] || $has_manifest) {
            return;
        }
    }

    // Fallback: enqueue CSS directly if Vite is not available
    wp_enqueue_style('variables', get_template_directory_uri() . '/css/variables.css', array('google-fonts'), '1.0.0');
    wp_enqueue_style('base', get_template_directory_uri() . '/css/base.css', array('variables'), '1.0.0');
    wp_enqueue_style('header', get_template_directory_uri() . '/css/header.css', array('base'), '1.0.0');
    wp_enqueue_style('footer', get_template_directory_uri() . '/css/footer.css', array('base'), '1.0.0');

    if (is_front_page()) {
        wp_enqueue_style('front-page', get_template_directory_uri() . '/css/front-page.css', array('base'), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'the_theme_enqueue_assets');

/**
 * Custom excerpt length
 *
 * @param int $length Default excerpt length
 * @return int Modified excerpt length
 */
function the_theme_excerpt_length(int $length): int {
    return 15;
}
add_filter('excerpt_length', 'the_theme_excerpt_length', 999);
