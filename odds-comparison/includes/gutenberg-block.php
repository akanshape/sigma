<?php
function ocp_register_odds_block() {
    if (!function_exists('register_block_type')) {
        return;
    }

    // Absolute path for filemtime()
    $block_js_path = plugin_dir_path(__FILE__) . '../blocks/odds-block.js';

    // Public URL for wp_register_script()
    $block_js_url = plugins_url('blocks/odds-block.js', dirname(__FILE__));

    wp_register_script(
        'ocp-odds-block',
        $block_js_url,
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-i18n', 'wp-block-editor'),
        filemtime($block_js_path),
        true
    );

    register_block_type('ocp/odds-block', array(
        'editor_script' => 'ocp-odds-block',
        'render_callback' => 'ocp_render_odds_block',
    ));
}

add_action('init', 'ocp_register_odds_block');

function ocp_render_odds_block() {
    return ocp_render_odds();
}

