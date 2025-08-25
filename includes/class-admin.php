<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_Admin {
  public function init() {
    add_action('init', [$this,'register_meta']);
    add_action('add_meta_boxes', [$this,'add_metabox']);
    add_action('save_post', [$this,'save_metabox']);
  }

  public function register_meta() {
    register_post_meta(HET_TSTM_POST_TYPE,'het_tstm_featured',[
      'type'=>'boolean','single'=>true,'show_in_rest'=>true,'auth_callback'=>'__return_true'
    ]);
  }

  public function add_metabox() {
    add_meta_box('het_tstm_featured_mb','Featured',[$this,'metabox_cb'],HET_TSTM_POST_TYPE,'side');
  }

  public function metabox_cb($post){
    $val = (bool) get_post_meta($post->ID,'het_tstm_featured', true);
    wp_nonce_field('het_tstm_featured','het_tstm_featured_n');
    echo '<label><input type="checkbox" name="het_tstm_featured" '.checked($val,true,false).'> הצג כאייטם מומלץ (Featured)</label>';
  }

  public function save_metabox($post_id){
    if( !isset($_POST['het_tstm_featured_n']) || !wp_verify_nonce($_POST['het_tstm_featured_n'],'het_tstm_featured') ) return;
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if( get_post_type($post_id) !== HET_TSTM_POST_TYPE ) return;
    update_post_meta($post_id,'het_tstm_featured', isset($_POST['het_tstm_featured']));
  }
}
