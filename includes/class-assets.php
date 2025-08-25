<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_Assets {

  public function init() {
    add_action('wp_enqueue_scripts', [$this, 'enqueue']);
  }

  public function enqueue() {
    // Google Font
    wp_enqueue_style(
      'het-varela',
      'https://fonts.googleapis.com/css2?family=Varela+Round&display=swap',
      [],
      null
    );

    // Swiper (לסליידר)
    wp_enqueue_style(
      'swiper',
      'https://unpkg.com/swiper@10/swiper-bundle.min.css',
      [],
      '10'
    );
    wp_enqueue_script(
      'swiper',
      'https://unpkg.com/swiper@10/swiper-bundle.min.js',
      [],
      '10',
      true
    );

    // CSS/JS של התוסף
    wp_enqueue_style(
      'het-testimonials',
      HET_TSTM_URL . 'assets/css/testimonials.css',
      [],
      HET_TSTM_VER
    );
    wp_enqueue_script(
      'het-testimonials',
      HET_TSTM_URL . 'assets/js/testimonials.js',
      ['jquery', 'swiper'], // תלות ב־swiper אם יש סליידר
      HET_TSTM_VER,
      true
    );

    wp_localize_script('het-testimonials', 'HET_TSTM', [
      'ajax'  => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('het_tstm_nonce'),
    ]);
  }
}
