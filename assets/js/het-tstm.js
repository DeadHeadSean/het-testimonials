(function($){  
    function initSwiper(scope){
        $(scope).find('.het-tstm--slider .het-swiper').each(function(){
          var $wrap = $(this).closest('.het-tstm--slider');
          var gap = parseInt(getComputedStyle($wrap[0]).getPropertyValue('--het-gap')) || 24;
          new Swiper(this, {
            slidesPerView: 3,
            slidesPerGroup: 1,
            centeredSlides: false,
            spaceBetween: gap,
            navigation: {
              nextEl: $wrap.find('.het-next')[0],
              prevEl: $wrap.find('.het-prev')[0],
            },
            breakpoints: {
              0: { slidesPerView: 1 },
              768: { slidesPerView: 2 },
              1024: { slidesPerView: 3 }
            }
          });
        });
      }

      $(function(){
        initSwiper(document);

        $(document).on('click', '.het-tstm-more', function(){
          var full = $(this).next('.het-tstm-full').html();
          var title = $(this).closest('.het-tstm-card').find('.het-tstm-name').text();
          title = $('<div>').text(title).html();
          var $modal = $('<div class="het-tstm-modal"><div class="het-tstm-modal-content"><button type="button" class="het-btn het-tstm-modal-close" aria-label="Close">&times;</button><div class="het-tstm-name">'+ title +'</div>'+ full +'</div></div>');
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
  