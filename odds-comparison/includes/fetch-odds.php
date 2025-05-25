<?php

// function ocp_fetch_odds_data() {
//     $cached = get_transient('ocp_cached_odds');
//     if ($cached !== false) return $cached;

//     $api_key = '21407342e93c9511101a478358515288'; // Your API key
//     $url = "https://api.the-odds-api.com/v4/sports/upcoming/odds/?regions=uk&markets=h2h&oddsFormat=decimal&apiKey=$api_key";

//     $response = wp_remote_get($url);
//     if (is_wp_error($response)) {
//         return ['error' => 'Failed to fetch odds.'];
//     }

//     $body = wp_remote_retrieve_body($response);
//     $data = json_decode($body, true);

//     if (!is_array($data)) {
//         return ['error' => 'Invalid API response.'];
//     }

//     $odds_data = [];

//     foreach ($data as $match) {
//         $home = $match['home_team'] ?? null;
//         $away = $match['away_team'] ?? null;
//         if (!$home || !$away || empty($match['bookmakers'])) continue;

//         $match_title = "$away vs $home";

//         foreach ($match['bookmakers'] as $bookmaker) {
//             $name = $bookmaker['title'] ?? 'Unknown';

//             foreach ($bookmaker['markets'] as $market) {
//                 if ($market['key'] !== 'h2h') continue;

//                 foreach ($market['outcomes'] as $outcome) {
//                     $outcome_name = $outcome['name'];
//                     $price = $outcome['price'];
//                     $odds_data[$match_title][$name][$outcome_name] = $price;
//                 }
//             }
//         }
//     }

//     set_transient('ocp_cached_odds', $odds_data, 300); // 5 min cache
//     return $odds_data;
// }

// function ocp_render_odds() {
//     $odds_data = ocp_fetch_odds_data();

//     if (isset($odds_data['error'])) {
//         return '<p>' . esc_html($odds_data['error']) . '</p>';
//     }

//     if (empty($odds_data)) {
//         return '<p>No odds found.</p>';
//     }

//     $output = '<div class="ocp-odds-table">';

//     foreach ($odds_data as $match => $bookmakers) {
//         $output .= "<h3>" . esc_html($match) . "</h3><table border='1' cellpadding='5'>";
//         $output .= "<thead><tr><th>Bookmaker</th>";

//         // Use first bookmaker's outcomes to set header
//         $first = reset($bookmakers);
//         $columns = array_keys($first);
//         foreach ($columns as $col) {
//             $output .= "<th>" . esc_html($col) . "</th>";
//         }

//         $output .= "</tr></thead><tbody>";

//         foreach ($bookmakers as $bookmaker_name => $outcomes) {
//             $output .= "<tr><td>" . esc_html($bookmaker_name) . "</td>";

//             foreach ($columns as $col) {
//                 $price = $outcomes[$col] ?? '-';
//                 $output .= "<td>" . esc_html($price) . "</td>";
//             }

//             $output .= "</tr>";
//         }

//         $output .= "</tbody></table><br>";
//     }

//     $output .= '</div>';
//     return $output;
// }
// function ocp_fetch_odds_data() {
//     $cached = get_transient('ocp_cached_odds');
//     if ($cached !== false) return $cached;

//     // Admin-selected options
//     $allowed_bookmakers = get_option('ocp_bookmakers', []);
//     $allowed_markets = get_option('ocp_markets', []);

//     // Sanitize: convert CSV string to array if needed
//     if (!is_array($allowed_bookmakers)) {
//         $allowed_bookmakers = array_map('trim', explode(',', $allowed_bookmakers));
//     }
//     if (!is_array($allowed_markets)) {
//         $allowed_markets = array_map('trim', explode(',', $allowed_markets));
//     }

//     $api_key = '21407342e93c9511101a478358515288';
//     $url = "https://api.the-odds-api.com/v4/sports/upcoming/odds/?regions=uk&markets=h2h&oddsFormat=decimal&apiKey=$api_key";

//     $response = wp_remote_get($url);
//     if (is_wp_error($response)) {
//         return ['error' => 'Failed to fetch odds.'];
//     }

//     $body = wp_remote_retrieve_body($response);
//     $data = json_decode($body, true);

//     if (!is_array($data)) {
//         return ['error' => 'Invalid API response.'];
//     }

//     $odds_data = [];

//     foreach ($data as $match) {
//         $home = $match['home_team'] ?? null;
//         $away = $match['away_team'] ?? null;
//         if (!$home || !$away || empty($match['bookmakers'])) continue;

//         $match_title = "$away vs $home";

//         foreach ($match['bookmakers'] as $bookmaker) {
//             $bookmaker_key = $bookmaker['key'] ?? '';
//             $bookmaker_name = $bookmaker['title'] ?? 'Unknown';

//             // FILTER: Only allow selected bookmakers
//             if (!in_array($bookmaker_key, $allowed_bookmakers)) continue;

//             foreach ($bookmaker['markets'] as $market) {
//                 $market_key = $market['key'];
//                 // FILTER: Only allow selected markets
//                 if (!in_array($market_key, $allowed_markets)) continue;

//                 foreach ($market['outcomes'] as $outcome) {
//                     $outcome_name = $outcome['name'];
//                     $price = $outcome['price'];
//                     $odds_data[$match_title][$bookmaker_name][$outcome_name] = $price;
//                 }
//             }
//         }
//     }

//     set_transient('ocp_cached_odds', $odds_data, 300); // Cache for 5 min
//     return $odds_data;
// }


function ocp_fetch_odds_data() {
    $cached = get_transient('ocp_cached_odds');
    if ($cached !== false) return $cached;

    $api_key = '21407342e93c9511101a478358515288';
    $url = "https://api.the-odds-api.com/v4/sports/upcoming/odds/?regions=uk&markets=h2h&oddsFormat=decimal&apiKey=$api_key";

    $response = wp_remote_get($url);
    if (is_wp_error($response)) {
        return ['error' => 'Failed to fetch odds.'];
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if (!is_array($data)) {
        return ['error' => 'Invalid API response.'];
    }

    //  Get admin settings
    $selected_bookmakers = get_option('ocp_selected_bookmakers', []);
    $selected_markets = get_option('ocp_selected_markets', []);

    // Convert comma-separated settings to arrays
    if (is_string($selected_bookmakers)) {
        $selected_bookmakers = array_map('trim', explode(',', $selected_bookmakers));
    }

    if (is_string($selected_markets)) {
        $selected_markets = array_map('trim', explode(',', $selected_markets));
    }

    $odds_data = [];

    foreach ($data as $match) {
        $home = $match['home_team'] ?? null;
        $away = $match['away_team'] ?? null;
        if (!$home || !$away || empty($match['bookmakers'])) continue;

        $match_title = "$away vs $home";

        foreach ($match['bookmakers'] as $bookmaker) {
            $bookmaker_key = $bookmaker['key'] ?? '';
            $name = $bookmaker['title'] ?? 'Unknown';

            // ✅ Filter out unwanted bookmakers
            // if (!in_array($bookmaker_key, $selected_bookmakers)) continue;

            foreach ($bookmaker['markets'] as $market) {
                $market_key = $market['key'] ?? '';

                // ✅ Filter out unwanted markets
                if (!in_array($market_key, $selected_markets)) continue;

                foreach ($market['outcomes'] as $outcome) {
                    $outcome_name = $outcome['name'];
                    $price = $outcome['price'];
                    $odds_data[$match_title][$name][$outcome_name] = $price;
                }
            }
        }
    }

    set_transient('ocp_cached_odds', $odds_data, 300);
    return $odds_data;
}

