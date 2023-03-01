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

//add Css
function add_author_info_plugin_styles() {
    wp_enqueue_style( 'author-info-plugin-styles', plugins_url( 'css/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'add_author_info_plugin_styles' );


/*

 * Generate HTML for author details.

 */
function generate_author_details_html( $author ) {
    $author_id = is_object( $author ) ? $author->ID : (int) $author;
    $author_data = get_userdata( $author_id );

    if ( ! $author_data ) {
        return '';
    }

    $output = '<div class="author-details">';
    $output .= '<div class="author-avatar author-avatar-img">' . get_avatar( $author_id ) . '</div>';
    $output .= '<div class="author-name">' . esc_html( $author_data->display_name ) . '</div>';
    $output .= '<div class="author-website"><a href="' . esc_url( $author_data->user_url ) . '">' . esc_html( $author_data->user_url ) . '</a></div>';
    $output .= '</div>';

    return $output;
}

/*
 * Add author details after post content.
 
 */
function add_author_info_after_post( $content ) {
    if ( is_singular( 'post' ) ) {
        global $post;
        $author = get_user_by( 'ID', $post->post_author );
        $author_details_html = generate_author_details_html( $author );
        $content .= $author_details_html;
    }

    return $content;
}

add_filter( 'the_content', 'add_author_info_after_post' );



/*  
* Author info shortcode. 
*/
 
function author_info_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'id' => get_the_author_meta( 'ID' ),
    ), $atts, 'author_info' );

    $author = get_user_by( 'ID', $atts['id'] );
    return generate_author_details_html( $author );
}

add_shortcode( 'author_info', 'author_info_shortcode' );

   
?>