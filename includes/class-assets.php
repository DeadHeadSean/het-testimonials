<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_Assets {

  public function init() {
    add_action('wp_enqueue_scripts', [$this,'enqueue']);
    // טעינה גם בתצוגה מקדימה של אלמנטור
    add_action('elementor/frontend/after_register_scripts', [$this,'enqueue']);
    add_action('elementor/frontend/after_enqueue_scripts', [$this,'enqueue']);
  }

  public function enqueue() {
    // CSS התוסף
    wp_register_style('het-tstm', HET_TSTM_URL.'assets/css/het-tstm.css', [], HET_TSTM_VER);
    wp_enqueue_style('het-tstm');

    // JS התוסף
    wp_register_script('het-tstm', HET_TSTM_URL.'assets/js/het-tstm.js', ['jquery'], HET_TSTM_VER, true);
    wp_enqueue_script('het-tstm');

    // Swiper (רק אם נמצא מרקר בדף — חסכוני, אבל בטוח לטעון תמיד אם רוצים)
    if ( ! wp_script_is('swiper', 'registered') ) {
      wp_register_style('swiper', 'https://unpkg.com/swiper@9/swiper-bundle.min.css', [], '9');
      wp_register_script('swiper', 'https://unpkg.com/swiper@9/swiper-bundle.min.js', [], '9', true);
    }
    // נטען תמיד — פשוט יותר
    wp_enqueue_style('swiper');
    wp_enqueue_script('swiper');
  }
}
