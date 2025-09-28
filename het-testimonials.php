<?php
/**
 * Plugin Name: HET Testimonials
 * Description: CPT המלצות + טופס הגשה בפרונט + ניהול Featured + שורטקודים לתצוגה.
 * Author: HET
 * Version: 1.0.0
 */

if ( ! defined('ABSPATH') ) exit;

define('HET_TSTM_PATH', plugin_dir_path(__FILE__));
define('HET_TSTM_URL',  plugin_dir_url(__FILE__));
define('HET_TSTM_VER',  '1.0.0');

require_once HET_TSTM_PATH . 'includes/class-cpt.php';
require_once HET_TSTM_PATH . 'includes/class-ajax.php';
require_once HET_TSTM_PATH . 'includes/class-shortcodes.php';
require_once HET_TSTM_PATH . 'includes/class-assets.php';
require_once HET_TSTM_PATH . 'includes/helpers.php';

add_action('plugins_loaded', function() {
  (new HET_TSTM_CPT())->init();
  (new HET_TSTM_Ajax())->init();
  (new HET_TSTM_Shortcodes())->init();
  (new HET_TSTM_Assets())->init();
});
