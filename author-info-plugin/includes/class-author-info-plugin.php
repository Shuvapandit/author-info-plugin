<?php




defined( 'ABSPATH' ) or exit;

class Author_Info_Plugin {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
    }

    public function init() {
        add_shortcode( 'author_info', array( $this, 'author_info_shortcode' ) );
    }

    public function plugins_loaded() {
        add_filter( 'the_content', array( $this, 'add_author_info_after_post' ) );
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'author-info-plugin-styles', plugins_url( 'css/style.css', __FILE__ ) );
    }
   

    public function add_author_info_after_post( $content ) {
        if ( is_singular( 'post' ) ) {
            global $post;
            $author = get_user_by( 'ID', $post->post_author );
            $author_details_html = $this->generate_author_details_html( $author );
            $content .= $author_details_html;
        }

        return $content;
    }

    public function author_info_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'id' => get_the_author_meta( 'ID' ),
        ), $atts, 'author_info' );

        $author = get_user_by( 'ID', $atts['id'] );
        return $this->generate_author_details_html( $author );
    }

    public function generate_author_details_html( $author ) {
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
}



   
?>
