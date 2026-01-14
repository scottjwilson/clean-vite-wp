<?php

/**
 * Register navigation menus
 */
function the_theme_register_menus() {
    register_nav_menus(array(
        'menuTop' => 'Top Navigation Menu',
    ));
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
}
add_action('after_setup_theme', 'the_theme_register_menus');

/**
 * Add preconnect hints for Google Fonts
 */
function the_theme_font_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'the_theme_font_preconnect', 1);
