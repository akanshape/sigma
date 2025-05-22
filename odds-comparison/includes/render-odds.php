<?php
function ocp_render_odds() {
    // $odds_data = ocp_fetch_odds_data();
    // if (isset($odds_data['error'])) return "<p>Error: {$odds_data['error']}</p>";

    // $selected_bookmakers = explode(',', get_option('ocp_selected_bookmakers', ''));
    // $output = '<div class="ocp-odds-table">';

    // foreach ($odds_data as $match => $bookmakers) {
    //     $output .= "<h4>$match</h4><table><thead><tr><th>Bookmaker</th>";

    //     $first = reset($bookmakers);
    //     if (!is_array($first)) continue;

    //     foreach ($first as $team => $price) {
    //         $output .= "<th>" . esc_html($team) . "</th>";
    //     }

    //     $output .= "</tr></thead><tbody>";

    //     foreach ($bookmakers as $bookmaker => $odds) {
    //         if (!in_array(strtolower($bookmaker), $selected_bookmakers)) continue;

    //         $output .= "<tr><td>" . esc_html($bookmaker) . "</td>";
    //         foreach ($odds as $team => $price) {
    //             $output .= "<td>" . esc_html($price) . "</td>";
    //         }
    //         $output .= "</tr>";
    //     }

    //     $output .= "</tbody></table><br>";
    // }

    // $output .= '</div>';
    // return $output;



        $odds_data = ocp_fetch_odds_data();

    if (isset($odds_data['error'])) {
        return '<p>' . esc_html($odds_data['error']) . '</p>';
    }

    if (empty($odds_data)) {
        return '<p>No odds found.</p>';
    }

    $output = '<div class="ocp-odds-table">';

    foreach ($odds_data as $match => $bookmakers) {
        $output .= "<h3>" . esc_html($match) . "</h3>";
        $output .= "<table border='1' cellpadding='5' cellspacing='0'>";
        $output .= "<thead><tr><th>Bookmaker</th>";

        // Get all possible outcome names (e.g., Home, Away, Draw)
        $all_outcomes = [];

        foreach ($bookmakers as $bk_data) {
            foreach ($bk_data as $outcome_name => $_) {
                $all_outcomes[$outcome_name] = true;
            }
        }

        $columns = array_keys($all_outcomes);

        foreach ($columns as $col) {
            $output .= "<th>" . esc_html($col) . "</th>";
        }

        $output .= "</tr></thead><tbody>";

        foreach ($bookmakers as $bookmaker_name => $outcomes) {
            $output .= "<tr><td>" . esc_html($bookmaker_name) . "</td>";

            foreach ($columns as $col) {
                $price = $outcomes[$col] ?? '-';
                $output .= "<td>" . esc_html($price) . "</td>";
            }

            $output .= "</tr>";
        }

        $output .= "</tbody></table><br>";
    }

    $output .= '</div>';
    return $output;

}
