<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_Shortcodes {
  public function init() {
    add_shortcode('het_testimony_form',     [$this,'render_form']);
    add_shortcode('het_testimonials',       [$this,'render_list']);
  }

  public function render_form($atts=[]) {
    ob_start();
    include HET_TSTM_PATH.'templates/form.php';
    return ob_get_clean();
  }

  public function render_list($atts=[]) {
    $a = shortcode_atts([
      'limit' => 6,
      'layout' => 'grid',      // grid | slider
      'paginate' => '0',
      'tag' => '',             // סינון לפי תגית (למשל: Featured)
    ], $atts);
  
    $tax_query = [];
    if ( !empty($a['tag']) ) {
      $terms = array_map('trim', explode(',', $a['tag']));
      $tax_query[] = [
        'taxonomy' => defined('HET_TSTM_TAXONOMY') ? HET_TSTM_TAXONOMY : 'post_tag',
        'field'    => 'name',
        'terms'    => $terms,
      ];
    }
  
    $paged = ($a['paginate']==='1') ? max(1, get_query_var('paged') ?: get_query_var('page') ?: 1) : 1;
  
    $q = new WP_Query([
      'post_type'      => HET_TSTM_POST_TYPE,
      'post_status'    => 'publish',
      'posts_per_page' => (int)$a['limit'],
      'tax_query'      => $tax_query ?: null,
      'paged'          => $paged,
    ]);
  
    ob_start();
    if ($q->have_posts()) {
      if ($a['layout']==='slider') {
        echo '<div class="het-tstm het-tstm--slider">';
        echo '  <div class="het-swiper swiper"><div class="swiper-wrapper">';
        while ($q->have_posts()) { $q->the_post();
          echo '<div class="swiper-slide">';
          include HET_TSTM_PATH.'templates/loop-item.php';
          echo '</div>';
        }
        echo '  </div>';
        echo '  <div class="het-nav"><button class="het-btn het-prev">‹</button><button class="het-btn het-next">›</button></div>';
        echo '  </div>';
        echo '</div>';
      } else {
        echo '<div class="het-tstm het-tstm--grid">';
        while ($q->have_posts()) { $q->the_post(); include HET_TSTM_PATH.'templates/loop-item.php'; }
        echo '</div>';
        if ($a['paginate']==='1') { echo '<div class="het-tstm-pagination">'.paginate_links(['total'=>$q->max_num_pages]).'</div>'; }
      }
      wp_reset_postdata();
    } else {
      echo '<p>אין עדיין המלצות להצגה.</p>';
    }
    return ob_get_clean();
  }
}