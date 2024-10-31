<?php
/*
Plugin Name: SAN Technologies Breaking News
Plugin URI: http://www.idevelopwebsite.com
Description: Show Sticky Breaking News Bar On the Top/Footer of the website easily
Author: Nabaz Maaruf - idevelopwebsite
Version: 1.0
Text Domain: santechno-breaking-news
Author URI: http://www.idevelopwebsite.com
License: GPLv2 or later
*/
// Exit if accessed directly
if (!defined('SANTECH_THEME_DIR'))
    define('SANTECH_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('SANTECH_PLUGIN_NAME'))
    define('SANTECH_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('SANTECH_PLUGIN_DIR'))
    define('SANTECH_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . SANTECH_PLUGIN_NAME);

if (!defined('SANTECH_PLUGIN_URL'))
    define('SANTECH_PLUGIN_URL', WP_PLUGIN_URL . '/' . SANTECH_PLUGIN_NAME);
if ( ! defined( 'ABSPATH' ) ) echo 'cannot access redirect';

require_once (dirname(__FILE__).'/include/santechno-bn-init.php');

require_once (dirname(__FILE__).'/admin/santechno-admin-settings.php');







