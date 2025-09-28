<?php
if ( ! defined('ABSPATH') ) exit;

class HET_TSTM_Ajax {
  public function init() {
    add_action('wp_ajax_het_submit_testimony',    [$this, 'handle']);
    add_action('wp_ajax_nopriv_het_submit_testimony', [$this, 'handle']);
  }

  private function sanitize_text($v){ return sanitize_text_field( wp_strip_all_tags($v) ); }

  public function handle() {
    check_ajax_referer('het_tstm_nonce','nonce');

    $name    = $this->sanitize_text($_POST['name'] ?? '');
    $role    = $this->sanitize_text($_POST['role'] ?? '');
    $company = $this->sanitize_text($_POST['company'] ?? '');
    $rating  = (int) ($_POST['rating'] ?? 0);
    $email   = sanitize_email($_POST['email'] ?? '');
    $content = wp_kses_post($_POST['content'] ?? '');
    $hp      = $this->sanitize_text($_POST['website'] ?? ''); // honeypot

    if ($hp !== '') wp_send_json_error(['message'=>'Bot suspected'], 400);
    if (!$name || !$content) wp_send_json_error(['message'=>'שם ותוכן חובה'], 400);

    // יוצר פוסט Pending
    $post_id = wp_insert_post([
      'post_type'   => 'testimony',
      'post_status' => 'pending',
      'post_title'  => $name,
      'post_content'=> $content,
    ], true);

    if (is_wp_error($post_id)) {
      wp_send_json_error(['message'=>'שמירה נכשלה'], 500);
    }

    update_post_meta($post_id, 'het_tstm_name', $name);
    update_post_meta($post_id, 'het_tstm_role', $role);
    update_post_meta($post_id, 'het_tstm_company', $company);
    update_post_meta($post_id, 'het_tstm_rating', max(0,min(5,$rating)));
    update_post_meta($post_id, 'het_tstm_email', $email);
    update_post_meta($post_id, 'het_tstm_featured', false);

    // העלאת תמונת פרופיל (אופציונאלי)
    if ( !empty($_FILES['avatar']['name']) ) {
      require_once ABSPATH . 'wp-admin/includes/file.php';
      require_once ABSPATH . 'wp-admin/includes/image.php';
      $file = wp_handle_upload($_FILES['avatar'], ['test_form'=>false]);
      if (!isset($file['error'])) {
        $attach_id = wp_insert_attachment([
          'post_mime_type' => $file['type'],
          'post_title'     => sanitize_file_name($_FILES['avatar']['name']),
          'post_content'   => '',
          'post_status'    => 'inherit'
        ], $file['file'], $post_id);
        $attach_data = wp_generate_attachment_metadata($attach_id, $file['file']);
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($post_id, $attach_id);
      }
    }

    // מייל למנהל
    wp_mail(get_option('admin_email'),
      'הוגשה המלצה חדשה לאישור',
      "התקבלה המלצה חדשה מ- {$name}. לאישור: ".admin_url("post.php?post={$post_id}&action=edit")
    );

    wp_send_json_success(['message'=>'תודה! ההמלצה התקבלה ותפורסם לאחר אישור.']);
  }
}
