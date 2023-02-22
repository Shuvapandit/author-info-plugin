<?php
/*
* Plugin Name: Author Info Plugin
 * Description: Adds author info after every post and provides a shortcode to display it anywhere in the post.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:          Shuva chakraborty
 * Author URI:       https://github.com/Shuvapandit
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:       https://github.com/Shuvapandit
*/

//Add Css
function add_author_info_plugin_styles() {
    wp_enqueue_style( 'author-info-plugin-styles', plugins_url( 'css/sstt-style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'add_author_info_plugin_styles' );

// Add author info after post content
add_filter( 'the_content', 'add_author_info_after_post' );

function add_author_info_after_post( $content ) {
    if ( is_singular( 'post' ) ) {
        $author_info = author_info_shortcode();
        $content .= '<div class="author-info">' . $author_info . '</div>';
    }
    return $content;
}

// Shortcode for author info
add_shortcode( 'author_info', 'author_info_shortcode' );

function author_info_shortcode() {
    $author_id = get_the_author_meta( 'ID' );
    $author_name = get_the_author_meta( 'display_name' );
    $author_avatar = get_avatar( $author_id, 96 );
    $author_website = get_the_author_meta( 'user_url' );
    
    ob_start();
    ?>
    <div class="author-info-shortcode">
        <p><strong>Name:</strong> <?php echo $author_name; ?></p>
        <p><strong>Avatar:</strong> <?php echo $author_avatar; ?></p>
        <?php if ( $author_website ) { ?>
            <p><strong>Website:</strong> <a href="<?php echo esc_url( $author_website ); ?>"><?php echo esc_url( $author_website ); ?></a></p>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}