<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_CPT {
  public function init() {
    add_action('init', [$this, 'register_cpt']);
    add_action('init', [$this, 'register_meta']);
  }

  public function register_cpt() {
    if (post_type_exists('HET_TSTM_POST_TYPE')) return; // אם כבר קיים ה-CPT, לא נרשום אותו שוב
    $labels = [
      'name' => 'המלצות',
      'singular_name' => 'המלצה',
      'add_new' => 'הוספת המלצה',
      'add_new_item' => 'הוספת המלצה חדשה',
      'edit_item' => 'עריכת המלצה',
      'new_item' => 'המלצה חדשה',
      'view_item' => 'צפייה בהמלצה',
      'search_items' => 'חיפוש המלצות',
      'not_found' => 'לא נמצאו המלצות',
      'menu_name' => 'המלצות',
    ];

    register_post_type('testimony', [
      'labels' => $labels,
      'public' => true,
      'supports' => ['title','editor','thumbnail'],
      'menu_icon' => 'dashicons-testimonial',
      'has_archive' => true,
      'rewrite' => ['slug' => 'testimonials'],
      'show_in_rest' => true,
    ]);
  }

  public function register_meta() {
    $metas = [
      'het_tstm_name'     => 'string', // אם רוצים להפריד "שם מלא" מכותרת
      'het_tstm_role'     => 'string',
      'het_tstm_company'  => 'string',
      'het_tstm_rating'   => 'number',
      'het_tstm_featured' => 'boolean',
      'het_tstm_email'    => 'string', // לא מוצג בפרונט
    ];
    foreach ($metas as $key => $type) {
      register_post_meta('testimony', $key, [
        'type'         => $type,
        'single'       => true,
        'show_in_rest' => true,
        'auth_callback'=> '__return_true',
      ]);
    }
  }
}

add_action('add_meta_boxes', function(){
  add_meta_box('het_tstm_featured_mb','Featured','het_tstm_featured_mb_cb', HET_TSTM_POST_TYPE,'side');
});
function het_tstm_featured_mb_cb($post){
  $val = (bool) get_post_meta($post->ID,'het_tstm_featured', true);
  wp_nonce_field('het_tstm_featured','het_tstm_featured_n');
  echo '<label><input type="checkbox" name="het_tstm_featured" '.checked($val,true,false).'> הצג כאייטם מומלץ (Featured)</label>';
}
add_action('save_post', function($post_id){
  if( !isset($_POST['het_tstm_featured_n']) || !wp_verify_nonce($_POST['het_tstm_featured_n'],'het_tstm_featured') ) return;
  update_post_meta($post_id,'het_tstm_featured', isset($_POST['het_tstm_featured']));
});
