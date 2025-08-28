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

jQuery(function($){
  function getGap(){
    return parseInt(getComputedStyle(document.documentElement).getPropertyValue('--gap'),
    10);
  }

  $('.het-swiper').each(function(){
    var $wrap = $(this);
    var swiper = new Swiper($warp[0], {
      slidesPreview: 'auto',
      slidesBetween: getGap(),
      grabCursor: true,
      rtl: $('html').attr('dir') === 'rtl',
      navigation: {
        nextEl: $warp.find('.het-next')[0],
        prevEl: $warp.find('.het-prev')[0],
      }
  });

  $(window).on('resize', function(){
    var gap = getGap();
    if (swiper.param.spaceBetween !== gap){
      swiper.params.spaceBetween = gap;
      swiper.update();
    }
  });
});

document.addEventListener('click', function(e){
  var btn = e.target.closest('.het-tstm-more');
  if (!btn) return;
  var card = btn.closest('.het-tstm-card');
  card.classList.toggle('is-open');
  btn.textContent = card.classList.contains('is-open') ? 'סגור/י' : 'קרא/י עוד';
});

});
