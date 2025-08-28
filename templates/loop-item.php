<?php
if ( ! defined('ABSPATH') ) exit;

$id      = get_the_ID();
$name    = het_tstm_get_meta($id,'het_tstm_name') ?: get_the_title();
$role    = het_tstm_get_meta($id,'het_tstm_role');
$company = het_tstm_get_meta($id,'het_tstm_company');
$rating  = (int)het_tstm_get_meta($id,'het_tstm_rating', 0);

$meta_featured = (bool)het_tstm_get_meta($id,'het_tstm_featured', false);
$term_featured = function_exists('has_term')
  ? has_term('featured', defined('HET_TSTM_TAXONOMY') ? HET_TSTM_TAXONOMY : 'post_tag', $id)
  : false;
$is_featured   = $meta_featured || $term_featured;
?>
<article class="het-tstm-card het-tstm-item<?php echo $is_featured ? ' is-featured' : ''; ?>"
         data-featured="<?php echo $is_featured ? '1' : '0'; ?>">

  <div class="het-tstm-top">
    <div class="het-tstm-avatar">
      <?php if (has_post_thumbnail()) { the_post_thumbnail('thumbnail'); } ?>
    </div>

    <div class="het-tstm-meta">
      <div class="het-tstm-name"><?php echo esc_html($name); ?></div>

      <?php if ($role || $company): ?>
        <div class="het-tstm-role">
          <?php
            $parts = [];
            if ($role)    $parts[] = $role;
            if ($company) $parts[] = $company;
            echo esc_html(implode(' • ', $parts));
          ?>
        </div>
      <?php endif; ?>

      <?php if ($rating > 0): ?>
        <div class="het-tstm-stars" aria-label="<?php echo esc_attr($rating); ?>/5">
          <?php for ($i=1; $i<=5; $i++): ?>
            <span class="star<?php echo ($i <= $rating) ? ' on' : ''; ?>">★</span>
          <?php endfor; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="het-tstm-body">
    <div class="het-tstm-excerpt">
      <?php the_content(); ?>
    </div>

    <button class="het-tstm-more" type="button" aria-expanded="false">קרא/י עוד</button>
  </div>
</article>
