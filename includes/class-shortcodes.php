<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_Shortcodes {
  public function init() {
    add_shortcode('het_testimony_form', [$this,'render_form']);
    add_shortcode('het_testimonials',   [$this,'render_list']);
  }

  public function render_form($atts = []) {
    ob_start();
    include HET_TSTM_PATH.'templates/form.php';
    return ob_get_clean();
  }

  public function render_list($atts = []) {
    $a = shortcode_atts([
      'limit'      => 6,
      'layout'     => 'grid',     // grid | slider
      'paginate'   => '0',
      'tag'        => '',         // slug(s) או שם/ים בפסיקים
      'span_long'  => '1',        // בסליידר: 1=עדות ארוכה רוחב כפול, 0=כיבוי
    ], $atts, 'het_testimonials');

    $tax_query = null;
    if (!empty($a['tag'])) {
      $raw   = array_filter(array_map('trim', explode(',', $a['tag'])));
      $slugs = array_map('sanitize_title', $raw);
      $tax_query = [
        'relation' => 'OR',
        [
          'taxonomy' => defined('HET_TSTM_TAXONOMY') ? HET_TSTM_TAXONOMY : 'post_tag',
          'field'    => 'slug',
          'terms'    => $slugs,
        ],
        [
          'taxonomy' => defined('HET_TSTM_TAXONOMY') ? HET_TSTM_TAXONOMY : 'post_tag',
          'field'    => 'name',
          'terms'    => $raw,
        ],
      ];
    }

    $paged = ($a['paginate'] === '1')
      ? max(1, get_query_var('paged') ?: get_query_var('page') ?: 1)
      : 1;

    $args = [
      'post_type'      => HET_TSTM_POST_TYPE,
      'post_status'    => 'publish',
      'posts_per_page' => (int) $a['limit'],
      'paged'          => $paged,
    ];
    if ($tax_query) $args['tax_query'] = $tax_query;

    $q = new WP_Query($args);

    ob_start();
    if ($q->have_posts()) {
      if ($a['layout'] === 'slider') {
        echo '<div class="het-tstm het-tstm--slider" dir="rtl">';
        echo '  <div class="het-swiper swiper"><div class="swiper-wrapper">';
        while ($q->have_posts()) { $q->the_post();
          include HET_TSTM_PATH.'templates/loop-item-slider.php';
        }
        echo '  </div></div>';
        echo '  <div class="het-nav"><button class="het-btn het-prev" aria-label="Previous">‹</button><button class="het-btn het-next" aria-label="Next">›</button></div>';
        echo '</div>';
      } else {
        echo '<div class="het-tstm het-tstm--grid">';
        while ($q->have_posts()) { $q->the_post();
          echo '<div class="het-tstm-item">';
          include HET_TSTM_PATH.'templates/loop-item.php';
          echo '</div>';
        }
        echo '</div>';

        if ($a['paginate'] === '1') {
          echo '<div class="het-tstm-pagination">'.
               paginate_links(['total' => $q->max_num_pages]) .
               '</div>';
        }
      }
      wp_reset_postdata();
    } else {
      echo '<p>אין עדיין המלצות להצגה.</p>';
    }
    return ob_get_clean();
  }
}
