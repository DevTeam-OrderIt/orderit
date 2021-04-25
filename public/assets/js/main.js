(function($) {
	'use strict';
	jQuery(document).on('ready', function(){
		
		// Mean Menu
		 jQuery('.mean-menu').meanmenu({
			meanScreenWidth: "991"
        });

		// Preloader
		jQuery(window).on('load', function() {
            $('.preloader').fadeOut();
		});

		// Home Slides
		$('.home-slides').owlCarousel({
			loop: true,
			nav: false,
			dots: true,
			autoplayHoverPause: true,
            autoplay: true,
            smartSpeed: 1000,
            animateOut: "slideOutDown",
            animateIn: "slideInDown",
            items: 1,
            navText: [
                "<i class='flaticon-left-chevron'></i>",
                "<i class='flaticon-right-chevron'></i>"
            ]
		});
		
		// Home Slides Two
		$('.home-slides-four').owlCarousel({
			loop: true,
			nav: true,
			dots: true,
			autoplayHoverPause: true,
            autoplay: true,
            smartSpeed: 1000,
            animateOut: "fadeOut",
            items: 1,
            navText: [
                "<i class='flaticon-left-chevron'></i>",
                "<i class='flaticon-right-chevron'></i>"
            ]
        });
        $(".home-slides").on("translate.owl.carousel", function(){
            $(".main-banner-content span").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content p").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content h1").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content .banner-btn").removeClass("animated fadeInUp").css("opacity", "0");
        });
        $(".home-slides").on("translated.owl.carousel", function(){
            $(".main-banner-content span").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content p").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content h1").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content .banner-btn").addClass("animated fadeInUp").css("opacity", "1");
		});

        $(".home-slides-four").on("translate.owl.carousel", function(){
            $(".main-banner-content span").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content p").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content h1").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content .banner-btn").removeClass("animated fadeInUp").css("opacity", "0");
        });
        $(".home-slides-four").on("translated.owl.carousel", function(){
            $(".main-banner-content span").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content p").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content h1").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content .banner-btn").addClass("animated fadeInUp").css("opacity", "1");
		});

		

		
		// Header Sticky
        $(window).on('scroll', function() {
            if ($(this).scrollTop() >150){  
                $('.navbar-area').addClass("is-sticky");
            }
            else{
                $('.navbar-area').removeClass("is-sticky");
            }
		});

		// Banner Image Slider
		$('.banner-image-slider').owlCarousel({
			loop: true,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
            autoplay: true,
            smartSpeed: 1000,
            navText: [
                "<i class='flaticon-left'></i>",
                "<i class='flaticon-right'></i>"
            ],
            responsive: {
				0: {
					items: 1
				},
				576: {
					items: 1
				},
				768: {
					items: 1
				},
				1200: {
					items: 1
				}
			}
		});
		
		

		// Event Slider
		$('.event-slider').owlCarousel({
			loop: true,
			nav: false,
			dots: true,
			autoplayHoverPause: true,
            autoplay: true,
            smartSpeed: 1000,
            margin: 30,
            navText: [
                "<i class='flaticon-left'></i>",
                "<i class='flaticon-right'></i>"
            ],
            responsive: {
				0: {
					items: 1
				},
				576: {
					items: 1
				},
				768: {
					items: 2
				},
				1200: {
					items: 2
				}
			}
		});
		
		// Testimonials Slider
		$('.testimonials-slider').owlCarousel({
			loop: true,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
            autoplay: true,
            smartSpeed: 1000,
            margin: 30,
            navText: [
                "<i class='flaticon-left'></i>",
                "<i class='flaticon-right'></i>"
            ],
            responsive: {
				0: {
					items: 1
				},
				576: {
					items: 1
				},
				768: {
					items: 2
				},
				991: {
					items: 1
				},
				1200: {
					items: 1
				}
			}
		});
		
		// Testimonials Slider Two
		$('.testimonials-slider-two').owlCarousel({
			loop: true,
			nav: false,
			dots: false,
			autoplayHoverPause: true,
            autoplay: true,
            smartSpeed: 1000,
            margin: 30,
            navText: [
                "<i class='flaticon-left'></i>",
                "<i class='flaticon-right'></i>"
            ],
            responsive: {
				0: {
					items: 1
				},
				576: {
					items: 1
				},
				768: {
					items: 2
				},
				1200: {
					items: 2
				}
			}
		});
		
		// Feature Slider
		$('.feature-slider').owlCarousel({
			loop: true,
			nav: false,
			dots: true,
			autoplayHoverPause: true,
            autoplay: true,
            smartSpeed: 1000,
			margin: 30,
            responsive: {
				0: {
					items: 1
				},
				576: {
					items: 1
				},
				768: {
					items: 2
				},
				1200: {
					items: 3
				}
			}
        });
		
		
		// Preloader
		jQuery(window).on('load', function () {
			$('#preloader').fadeOut()
		})



	});

})(jQuery);