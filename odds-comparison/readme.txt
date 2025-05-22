=== Odds Comparison Plugin ===
Contributors: yourname
Tags: sports, betting, odds, comparison, api, shortcode, gutenberg
Requires at least: 5.5
Tested up to: 6.5
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display live odds from multiple bookmakers via The Odds API. Includes Gutenberg block and shortcode support.

== Description ==

This plugin allows WordPress users to fetch and display real-time sports betting odds using The Odds API. Users can customize which bookmakers and markets to show, and the data is automatically cached for performance.

Features include:
* Display odds in a clean comparison table
* Supports Gutenberg blocks and shortcode rendering
* Admin settings to choose bookmakers and markets
* Uses WordPress transients for caching

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/odds-comparison` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the **Odds Comparison** block in the Gutenberg editor or place `[odds_comparison]` in a post or page.

== Frequently Asked Questions ==

= Which API does this plugin use? =
It uses [The Odds API](https://the-odds-api.com/) to fetch bookmaker odds.
https://api.the-odds-api.com/v4/sports/upcoming/odds/?regions=uk&markets=h2h&oddsFormat=decimal&apiKey=your-apiKey

= Is it customizable? =
Yes. You can choose which bookmakers and markets to show from the plugin settings.
otherwise it will show all data.
note: this is free api and it changes data daily so for testing bookmakers you need to check which bookmakers it is providing today.

== Screenshots ==

1. Example of the odds table in the frontend
2. Admin settings page
3. Gutenberg block in the editor

== Changelog ==

= 1.0 =
* Initial release with basic odds comparison functionality

== License ==

This plugin is licensed under the GPLv2 or later.
