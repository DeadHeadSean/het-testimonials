<?php
/**
 * Plugin Name: HET Testimonials
 * Description: CPT המלצות + טופס הגשה בפרונט + ניהול Featured + שורטקודים לתצוגה.
 * Author: Sean Roisentul | HET
 * Version: 1.0.0
 */
if ( ! defined('ABSPATH') ) exit;

if ( ! defined('HET_TSTM_POST_TYPE') ) define('HET_TSTM_POST_TYPE','testimony');
if ( ! defined('HET_TSTM_TAXONOMY') ) define('HET_TSTM_TAXONOMY','post_tag');

define('HET_TSTM_PATH', plugin_dir_path(__FILE__));
define('HET_TSTM_URL',  plugin_dir_url(__FILE__));
define('HET_TSTM_VER',  '1.0.0');

require_once HET_TSTM_PATH.'includes/class-cpt.php';
require_once HET_TSTM_PATH.'includes/class-ajax.php';
require_once HET_TSTM_PATH.'includes/class-shortcodes.php';
require_once HET_TSTM_PATH.'includes/class-assets.php';
require_once HET_TSTM_PATH.'includes/helpers.php';
require_once HET_TSTM_PATH.'includes/class-admin.php';

/** Init classes */
$cpt = new HET_TSTM_CPT();
$cpt->init();                       // wires register_cpt + register_meta on 'init'

$short = new HET_TSTM_Shortcodes();
$short->init();                     // registers add_shortcode() NOW (no hook timing issues)

add_action('plugins_loaded', function () {
  (new HET_TSTM_Ajax())->init();
  (new HET_TSTM_Assets())->init();
  (new HET_TSTM_Admin())->init();
});