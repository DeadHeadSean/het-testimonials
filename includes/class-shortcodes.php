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
      'featured_only' => '0',
      'layout' => 'grid', // grid | slider
      'paginate' => '0',
    ], $atts);

    $meta_query = [];
    if ($a['featured_only'] === '1') {
      $meta_query[] = [
        'key' => 'het_tstm_featured',
        'value' => true,
        'compare' => '='
      ];
    }

    $paged = ( $a['paginate'] === '1' ) ? max(1, get_query_var('paged') ?: get_query_var('page') ?: 1 ) : 1;

    $q = new WP_Query([
      'post_type' => 'testimony',
      'post_status' => 'publish',
      'posts_per_page' => (int)$a['limit'],
      'meta_query' => $meta_query ?: null,
      'paged' => $paged
    ]);

    ob_start();
    $items = [];
    if ($q->have_posts()) {
      echo '<div class="het-tstm het-tstm--'.$a['layout'].'">';
      while ($q->have_posts()) { $q->the_post();
        include HET_TSTM_PATH.'templates/loop-item.php';
      }
      echo '</div>';

      if ($a['paginate'] === '1') {
        echo '<div class="het-tstm-pagination">'.paginate_links([
          'total' => $q->max_num_pages
        ]).'</div>';
      }
      wp_reset_postdata();
    } else {
      echo '<p>אין עדיין המלצות להצגה.</p>';
    }

    return ob_get_clean();
  }
}
