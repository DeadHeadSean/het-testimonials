<?php
if ( ! defined('ABSPATH') ) exit;

function het_tstm_get_meta($id,$key,$default='') {
  $v = get_post_meta($id, $key, true);
  return $v !== '' ? $v : $default;
}

if ( ! function_exists('het_tstm_is_long') ) {
  function het_tstm_is_long($post_id = null, $chars = 420) {
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field('post_content', $post_id);
    $len     = mb_strlen( wp_strip_all_tags($content) );
    return ($len > $chars);
  }
}

