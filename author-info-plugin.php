<?php
/**
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

defined( 'ABSPATH' ) or exit;

// Include the plugin class
require_once plugin_dir_path( __FILE__ ) . 'includes/class-author-info-plugin.php';

// Instantiate the plugin class
$author_info_plugin = new Author_Info_Plugin();

?>