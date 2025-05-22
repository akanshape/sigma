<?php
/*
Plugin Name: Odds Comparison
Description: Fetch and display live betting odds.
Version: 1.0
Author: Your Name
*/

require_once plugin_dir_path(__FILE__) . 'includes/fetch-odds.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/render-odds.php';
require_once plugin_dir_path(__FILE__) . 'includes/odds-conversion.php';
// require_once plugin_dir_path(__FILE__) . 'includes/helpers.php';
require_once plugin_dir_path(__FILE__) . 'includes/gutenberg-block.php';

add_shortcode('odds_comparison', 'ocp_render_odds');
// Register admin menu
add_action('admin_menu', 'ocp_register_admin_menu');

// Init Gutenberg block
// add_action('init', 'ocp_register_odds_block');