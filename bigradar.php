<?php

/**
 *
 * @link              https://www.bigradar.io
 * @since             1.0.0
 * @package           Bigradar
 *
 * @wordpress-plugin
 * Plugin Name:       BigRadar - Free Chatbot, Live Chat, Email Marketing
 * Plugin URI:        https://www.bigradar.io/
 * Description:       Free live chat software to chat with visitors on your website. Send targetted messages to increase sales, conversion and support. 
 * Version:           1.0.0
 * Author:            BigRadar
 * Author URI:        https://www.bigradar.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bigradar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BIGRADAR_VERSION', '1.0.0' );

require(__DIR__ . '/admin.php');
new BigRadarSettings();
