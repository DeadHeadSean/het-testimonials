(function($){
    function initSwiper(scope){
        $(scope).find('.het-tstm--slider .het-swiper').each(function(){
          var $wrap = $(this).closest('.het-tstm--slider');
          var gap = parseInt(getComputedStyle($wrap[0]).getPropertyValue('--het-gap')) || 24;
          new Swiper(this, {
            slidesPerView: 'auto',
            spaceBetween: gap,
            navigation: {
              nextEl: $wrap.find('.het-next')[0],
              prevEl: $wrap.find('.het-prev')[0],
            }
          });
        });
      }

      $(function(){
        initSwiper(document);

        $(document).on('click', '.het-tstm-more', function(){
          var full = $(this).next('.het-tstm-full').html();
          var $modal = $('<div class="het-tstm-modal"><div class="het-tstm-modal-content"><button class="het-tstm-modal-close" aria-label="Close">&times;</button>'+ full +'</div></div>');
          $('body').append($modal);
        });

        $(document).on('click', '.het-tstm-modal-close, .het-tstm-modal', function(e){
          if(e.target !== this && !$(e.target).hasClass('het-tstm-modal-close')) return;
          $(this).closest('.het-tstm-modal').remove();
        });
      });

    window.addEventListener('elementor/frontend/init', function(){
      elementorFrontend.hooks.addAction('frontend/element_ready/shortcode.default', function($scope){
        initSwiper($scope[0]);
      });
    });
})(jQuery);
  