<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_Assets {
  public function init() {
    add_action('wp_enqueue_scripts', [$this, 'enqueue']);
  }
  public function enqueue() {
    wp_enqueue_style('het-testimonials', HET_TSTM_URL.'assets/css/testimonials.css', [], HET_TSTM_VER);
    wp_enqueue_script('het-testimonials', HET_TSTM_URL.'assets/js/testimonials.js', ['jquery'], HET_TSTM_VER, true);
    wp_localize_script('het-testimonials', 'HET_TSTM', [
      'ajax'  => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('het_tstm_nonce'),
    ]);
  }
}
