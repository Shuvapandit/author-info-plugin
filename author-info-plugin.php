<?php
/**
 * Plugin Name: Author Info Plugin
 * Description: Adds author info after every post and provides a shortcode to display it anywhere in the post.
 * Version: 1.0.0
 * Author: Shuva chakraborty
 * Author URI: https://your-website.com
 */
//Add Css
function add_author_info_plugin_styles() {
    wp_enqueue_style( 'author-info-plugin-styles', plugins_url( 'css/sstt-style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'add_author_info_plugin_styles' );

// Add author info after every post
function add_author_info_after_post() {
    $author_id = get_the_author_meta('ID');
    $author_name = get_the_author_meta('display_name');
    $author_avatar = get_avatar_url($author_id);
    $author_website = get_the_author_meta('user_url');
    ?>
    <div class="author-info">
        
        <h3><?php echo esc_html  ($author_name); ?></h3>
        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" />
        <p><?php echo esc_html($author_website); ?></p>
    </div>
    <?php
}
add_action('wp_footer', 'add_author_info_after_post');

// Create shortcode to display author info
function author_info_shortcode() {
    $author_id = get_the_author_meta('ID');
    $author_name = get_the_author_meta('display_name');
    $author_avatar = get_avatar_url($author_id);
    $author_website = get_the_author_meta('user_url');
    ob_start(); ?>
    <div class="author-info">
        <h3><?php echo esc_html($author_name); ?></h3>
        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>" />
        <p><?php echo esc_html($author_website); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('author_info', 'author_info_shortcode');
