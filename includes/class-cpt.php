<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_CPT {
  public function init() {
    add_action('init', [$this, 'register_cpt']);
    add_action('init', [$this, 'register_meta']);
  }

  public function register_cpt() {
    if (post_type_exists(HET_TSTM_POST_TYPE)) return; // אם כבר קיים ה-CPT, לא נרשום אותו שוב
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

    register_post_type(HET_TSTM_POST_TYPE, [
      'labels' => $labels,
      'public' => true,
      'supports' => ['title','editor','thumbnail'],
      'menu_icon' => 'dashicons-testimonial',
      'has_archive' => true,
      'rewrite' => ['slug' => 'testimonials'],
      'show_in_rest' => true,
      'taxonomies' => [HET_TSTM_TAXONOMY ],
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
      register_post_meta(HET_TSTM_POST_TYPE, 'het_tstm_name', [
        'type'         => $type,
        'single'       => true,
        'show_in_rest' => true,
        'auth_callback'=> '__return_true',
      ]);
    }
  }
}
