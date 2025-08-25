<?php
if ( ! defined('ABSPATH') ) exit;

function het_tstm_get_meta($id,$key,$default='') {
  $v = get_post_meta($id, $key, true);
  return $v !== '' ? $v : $default;
}
