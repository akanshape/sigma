<?php
function ocp_register_admin_menu() {
    add_menu_page('Odds Comparison', 'Odds Comparison', 'manage_options', 'odds-comparison', 'ocp_admin_settings_page');
}

function ocp_admin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Odds Comparison Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('ocp_settings_group');
            do_settings_sections('odds-comparison');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'ocp_register_settings');

function ocp_register_settings() {
    register_setting('ocp_settings_group', 'ocp_selected_bookmakers');
    register_setting('ocp_settings_group', 'ocp_selected_markets');

    add_settings_section('ocp_main_section', 'Main Settings', null, 'odds-comparison');

    add_settings_field('ocp_selected_bookmakers', 'Bookmakers (comma-separated keys)', 'ocp_bookmaker_field', 'odds-comparison', 'ocp_main_section');
    add_settings_field('ocp_selected_markets', 'Markets (comma-separated)', 'ocp_market_field', 'odds-comparison', 'ocp_main_section');
}

function ocp_bookmaker_field() {
    $bookmakers = get_option('ocp_selected_bookmakers', 'draftkings,bovada');
    if (is_array($bookmakers)) $bookmakers = implode(',', $bookmakers);
    $value = esc_attr($bookmakers);

    echo "<input type='text' name='ocp_selected_bookmakers' value='$value' />";
}

function ocp_market_field() {
    $markets = get_option('ocp_selected_markets', 'h2h');
if (is_array($markets)) $markets = implode(',', $markets);
$value = esc_attr($markets);

    echo "<input type='text' name='ocp_selected_markets' value='$value' />";
}
