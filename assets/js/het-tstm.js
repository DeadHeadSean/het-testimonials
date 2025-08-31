(function($){
    function initReadMore(scope){
      $(scope).find('.het-tstm-card .het-tstm-more').off('click.het').on('click.het', function(){
        var $card = $(this).closest('.het-tstm-card');
        $card.toggleClass('is-open');
        var open = $card.hasClass('is-open');
        $(this).text(open ? 'סגור/י' : 'קרא/י עוד').attr('aria-expanded', open ? 'true' : 'false');
      });
    }
  
    function initSwiper(scope){
      $(scope).find('.het-tstm--slider .het-swiper').each(function(){
        var $wrap = $(this).closest('.het-tstm--slider');
        var gap = parseInt($wrapgetComputedStyle($wrap[0]).getProprtyValue('--het-gap')) || 16;
        new Swiper(this, {
          slidesPerView: 'auto',     // רוחב נשלט ב-CSS (כולל is-double)
          spaceBetween: gap,
          slidesOffsetAfter: gap,
          slidesPerGroupAuto: true,
          navigation: {
            nextEl: $wrap.find('.het-next')[0],
            prevEl: $wrap.find('.het-prev')[0],
          }
        });
      });
    }
  
    $(function(){
      initReadMore(document);
      initSwiper(document);
    });
  
    window.addEventListener('elementor/frontend/init', function(){
      elementorFrontend.hooks.addAction('frontend/element_ready/shortcode.default', function($scope){
        initReadMore($scope[0]);
        initSwiper($scope[0]);
      });
    });
  })(jQuery);
  