<?php
// Simple testimonial form
?>
<form id="het-tstm-form" class="het-tstm-form">
  <input type="hidden" name="action" value="het_submit_testimony">
  <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce('het_tstm_nonce') ); ?>">
  <input type="text" name="website" value="" class="hp" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;">
  <div class="row">
    <label>שם מלא *</label>
    <input type="text" name="name" required>
  </div>
  <div class="row">
    <label>דוא״ל (לא יוצג)</label>
    <input type="email" name="email">
  <div class="row">
    <label>המלצה *</label>
    <textarea name="content" rows="5" required></textarea>
  </div>
  <button type="submit" class="het-btn">שלחי</button>
  <div class="het-tstm-msg" aria-live="polite"></div>
</form>
