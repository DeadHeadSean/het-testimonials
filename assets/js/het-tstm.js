(function($){
    function initSwiper(scope){
      $(scope).find('.het-tstm--slider .het-swiper').each(function(){
        var $wrap = $(this).closest('.het-tstm--slider');
        var gap = parseInt(getComputedStyle($wrap[0]).getPropertyValue('--het-gap')) || 24;
        new Swiper(this, {
          slidesPerView: 'auto',     // רוחב נשלט ב-CSS (כולל is-double)
          spaceBetween: gap,
          slidesOffsetBefore: gap,
          slidesOffsetAfter: gap,
          slidesPerGroupAuto: true,  // לדלג נכון על כרטיס כפול
          navigation: {
            nextEl: $wrap.find('.het-next')[0],
            prevEl: $wrap.find('.het-prev')[0],
          }
        });
      });
    }

    $(function(){
      initSwiper(document);
    });

    window.addEventListener('elementor/frontend/init', function(){
      elementorFrontend.hooks.addAction('frontend/element_ready/shortcode.default', function($scope){
        initSwiper($scope[0]);
      });
    });
})(jQuery);
  