<?php
// שימי לב: השורטקוד מציג את ה-HTML; את הפופ-אפ עצמו פותחים דרך Elementor.
?>
<form id="het-tstm-form" class="het-tstm-form" enctype="multipart/form-data">
  <input type="hidden" name="action" value="het_submit_testimony">
  <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce('het_tstm_nonce') ); ?>">
  <!-- honeypot -->
  <input type="text" name="website" value="" class="hp" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;">

  <div class="row">
    <label>שם מלא *</label>
    <input type="text" name="name" required>
  </div>
  <div class="row">
    <label>דוא״ל (לא יוצג)</label>
    <input type="email" name="email">
  </div>
  <div class="row">
    <label>תפקיד/הקשר</label>
    <input type="text" name="role" placeholder="אמא ל־3 / מנכ״לית עמותה / בעלת עסק...">
  </div>
  <div class="row">
    <label>ארגון/עסק</label>
    <input type="text" name="company">
  </div>
  <div class="row">
    <label>דירוג (0–5)</label>
    <input type="number" name="rating" min="0" max="5" step="1">
  </div>
  <div class="row">
    <label>תמונת פרופיל (אופציונלי)</label>
    <input type="file" name="avatar" accept="image/*">
  </div>
  <div class="row">
    <label>המלצה *</label>
    <textarea name="content" rows="5" required></textarea>
  </div>

  <button type="submit" class="het-btn">שלחי המלצה</button>
  <div class="het-tstm-msg" aria-live="polite"></div>
</form>
