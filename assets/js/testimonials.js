jQuery(function($){
  $('#het-tstm-form').on('submit', function(e){
    e.preventDefault();
    var $form = $(this);
    var formData = new FormData(this);
    formData.append('action', 'het_submit_testimony');
    formData.append('nonce', HET_TSTM.nonce);

    $form.find('button').prop('disabled', true);
    $form.find('.het-tstm-msg').text('שולח/ת...');

    $.ajax({
      url: HET_TSTM.ajax,
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false
    }).done(function(res){
      if(res.success){
        $form[0].reset();
        $form.find('.het-tstm-msg').text(res.data.message);
      } else {
        $form.find('.het-tstm-msg').text(res.data && res.data.message ? res.data.message : 'שגיאה בשליחה');
      }
    }).fail(function(){
      $form.find('.het-tstm-msg').text('שגיאה בלתי צפויה');
    }).always(function(){
      $form.find('button').prop('disabled', false);
    });
  });
});
