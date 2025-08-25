<?php
/**
 * Plugin Name: HET Testimonials
 * Description: CPT המלצות + טופס הגשה בפרונט + ניהול Featured + שורטקודים לתצוגה.
 * Author: HET
 * Version: 1.0.0
 */


 if ( ! defined('ABSPATH') ) exit;

 if ( ! defined('HET_TSTM_POST_TYPE') ){
  define('HET_TSTM_POST_TYPE','testimonials');} // ה-slug מ-CPT UI

 if ( ! defined('HET_TSTM_TAXONOMY') ){
   define('HET_TSTM_TAXONOMY', 'post_tag');} // או ה-slug של הטקסונומיה שלך



define('HET_TSTM_PATH', plugin_dir_path(__FILE__));
define('HET_TSTM_URL',  plugin_dir_url(__FILE__));
define('HET_TSTM_VER',  '1.0.0');

require_once HET_TSTM_PATH . 'includes/class-cpt.php';
require_once HET_TSTM_PATH . 'includes/class-ajax.php';
require_once HET_TSTM_PATH . 'includes/class-shortcodes.php';
require_once HET_TSTM_PATH . 'includes/class-assets.php';
require_once HET_TSTM_PATH . 'includes/helpers.php';
require_once HET_TSTM_PATH . 'includes/class-admin.php';

add_action('plugins_loaded', function() {
  $cpt = new HET_TSTM_CPT();
  add_action('init', [$cpt, 'register_meta']); 
  
  (new HET_TSTM_Ajax())->init();
  (new HET_TSTM_Shortcodes())->init();
  (new HET_TSTM_Assets())->init();
  (new HET_TSTM_Admin())->init();
});
