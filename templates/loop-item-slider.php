<?php
// templates/loop-item-slider.php
$id = get_the_ID();
$name    = het_tstm_get_meta($id,'het_tstm_name') ?: get_the_title();
$role    = het_tstm_get_meta($id,'het_tstm_role');
$company = het_tstm_get_meta($id,'het_tstm_company');
$rating  = (int)het_tstm_get_meta($id,'het_tstm_rating', 0);

$content = get_the_content();
$is_long = mb_strlen( wp_strip_all_tags( $content ) ) > 350; // סף “ארוך”

?>
<div class="swiper-slide<?php echo $is_long ? ' is-double' : ''; ?>">
  <article class="het-tstm-item het-tstm-card">
    <div class="het-tstm-top">
      <div class="het-tstm-avatar"><?php if (has_post_thumbnail()) the_post_thumbnail('thumbnail'); ?></div>
      <div class="het-tstm-meta">
        <div class="het-tstm-name"><?php echo esc_html($name); ?></div>
        <?php if ($role || $company): ?>
          <div class="het-tstm-role"><?php echo esc_html(trim($role.' '.($company?'• '.$company:''))); ?></div>
        <?php endif; ?>
        <?php if ($rating>0): ?>
          <div class="het-tstm-stars" aria-label="<?php echo esc_attr($rating); ?>/5">
            <?php for($i=1;$i<=5;$i++): ?>
              <span class="star<?php echo $i<=$rating?' on':''; ?>">★</span>
            <?php endfor; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="het-tstm-body"><?php echo wpautop( wp_kses_post($content) ); ?></div>
  </article>
</div>
