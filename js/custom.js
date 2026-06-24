"use strict";

(function ($) {

  if (typeof Lenis !== "undefined") {
    new Lenis({ autoRaf: true });
  }

  $(window).on("load", function () {
    var preloader = $("#preloader");
    if (preloader.length) preloader.hide();
    $("body").css("overflow", "visible");
  });

  // Tooltip
  if (typeof bootstrap !== "undefined") {
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
      new bootstrap.Tooltip(el);
    });
  }

  // Offcanvas Menu
  var offcanvasBtn = $(".offcanvas-nav-btn");
  var offcanvasNav = $(".navbar:not(.navbar-clone) .offcanvas-nav");

  if (offcanvasNav.length && typeof bootstrap !== "undefined") {
    var offcanvas = new bootstrap.Offcanvas(offcanvasNav[0], { scroll: true });

    offcanvasBtn.on("click", function () {
      if (offcanvas) {
        offcanvas._isShown ? offcanvas.hide() : offcanvas.show();
      }
    });
  }

  // Button hover effect
  $(".btn").on("mouseenter mouseout", function (event) {
    var offset = $(this).offset();
    var x = event.pageX - offset.left;
    var y = event.pageY - offset.top;
    $(this).find("span").css({ top: y, left: x });
  });

  // Sticky Header
  $(window).on("scroll", function () {
    var stickyHeight = $(".sticky-height");
    var header = $(".header-nav-wrapper");

    if (header.length) {
      var headerHeight = header.outerHeight();
      var headerTop = $(".header-top");
      var scrollPoint = (headerTop.length ? headerTop.outerHeight() : 0) + 200;

      if ($(window).scrollTop() > scrollPoint) {
        header.addClass("scroll-on");
        stickyHeight.length && stickyHeight.css("height", headerHeight + "px");
      } else {
        header.removeClass("scroll-on");
        stickyHeight.length && stickyHeight.css("height", "0");
      }
    }
  });

  // Jarallax
  $(document).ready(function () {
    if (typeof jarallax !== "undefined" && document.querySelectorAll(".jarallax").length) {
      jarallax(document.querySelectorAll(".jarallax"), { speed: 0.5 });
    }
  });

  // Fancybox
  if (typeof Fancybox !== "undefined" && Fancybox.bind) {
    Fancybox.bind("[data-fancybox]", {
      Thumbs: { autoStart: false },
      Toolbar: { display: ["close"] },
      animated: true
    });
  }

  // Counter
  if (typeof PureCounter !== "undefined") {
    new PureCounter({ decimals: 0 });
  }

  // Hero Slider 1
  if (document.querySelector(".hero-slider") && typeof Swiper !== "undefined") {
    new Swiper(".hero-slider", {
      slidesPerView: 1,
      autoplay: { delay: 4000, disableOnInteraction: false },
      loop: true,
      spaceBetween: 0,
      effect: "creative",
      speed: 1500,
      creativeEffect: {
        prev: { scale: 1, opacity: 0, translate: [0, 0, 0] },
        next: { scale: 1.2, opacity: 0, translate: [0, 0, 0] }
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
      }
    });
  }

  // Hero Slider 2 - FIXED GSAP ERROR
  if (document.querySelector(".hero-slider2") && typeof Swiper !== "undefined") {
    new Swiper(".hero-slider2", {
      autoplay: { delay: 4000, disableOnInteraction: false },
      loop: true,
      spaceBetween: 0,
      effect: "creative",
      speed: 1500,
      creativeEffect: {
        prev: { scale: 1.1, opacity: 0, translate: [0, 0, 0] },
        next: { scale: 1.3, opacity: 0, translate: [0, 0, 0] }
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
      },
      on: {
        slideChangeTransitionStart: function () {
          if (typeof gsap === "undefined") return;

          var activeSlide = document.querySelector(".hero-slider2 .swiper-slide-active");
          if (!activeSlide) return;

          var slideContent = activeSlide.querySelectorAll(".slide-content > *");
          var absImgs = activeSlide.querySelectorAll(".abs-img");

          if (slideContent.length) {
            gsap.set(slideContent, { opacity: 0, y: 30 });
          }

          if (absImgs.length) {
            gsap.set(absImgs, { opacity: 0, y: 30 });
          }
        },

        slideChangeTransitionEnd: function () {
          if (typeof gsap === "undefined") return;

          var activeSlide = document.querySelector(".hero-slider2 .swiper-slide-active");
          if (!activeSlide) return;

          var slideContent = activeSlide.querySelectorAll(".slide-content > *");
          var absImgs = activeSlide.querySelectorAll(".abs-img");

          if (slideContent.length) {
            gsap.to(slideContent, {
              opacity: 1,
              y: 0,
              duration: 0.8,
              stagger: 0.15,
              ease: "power3.out"
            });
          }

          if (absImgs.length) {
            gsap.to(absImgs, {
              opacity: 1,
              y: 0,
              duration: 0.8,
              stagger: 0.15,
              ease: "power3.out"
            });
          }
        }
      }
    });
  }

  // Other Sliders
  if (typeof Swiper !== "undefined") {

    if (document.querySelector(".service-slider2")) {
      new Swiper(".service-slider2", {
        slidesPerView: "auto",
        loop: true,
        speed: 600,
        autoplay: true,
        spaceBetween: 30,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        }
      });
    }

    if (document.querySelector(".services-carousel")) {
      new Swiper(".services-carousel", {
        loop: true,
        spaceBetween: 30,
        speed: 600,
        autoplay: true,
        pagination: {
          el: ".ct-pagination .swiper-pagination",
          clickable: true
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        },
        breakpoints: {
          0: { slidesPerView: 1 },
          768: { slidesPerView: 2 },
          992: { slidesPerView: 3 },
          1400: { slidesPerView: "auto" }
        }
      });
    }

    if (document.querySelector(".brands-carousel")) {
      new Swiper(".brands-carousel", {
        loop: true,
        autoplay: true,
        speed: 600,
        spaceBetween: 30,
        breakpoints: {
          0: { slidesPerView: 1 },
          768: { slidesPerView: 4 },
          992: { slidesPerView: 6 }
        }
      });
    }

    if (document.querySelector(".review-slider")) {
      new Swiper(".review-slider", {
        loop: true,
        autoplay: true,
        speed: 800,
        slidesPerView: 1,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true
        }
      });
    }
  }

  // Marquee
  if ($(".marque-active").length && $.fn.marquee) {
    $(".marque-active").marquee({
      gap: 48,
      speed: 80,
      delayBeforeStart: 0,
      direction: "left",
      duplicated: true,
      pauseOnHover: true,
      startVisible: true
    });
  }

  // Fade animation
  if (typeof gsap !== "undefined") {
    $(".fadeInUp").length > 0 &&
      gsap.utils.toArray(".fadeInUp").forEach(function (el) {
        var offset = el.getAttribute("data-fade-offset") || 40;
        var duration = el.getAttribute("data-duration") || 0.75;
        var from = el.getAttribute("data-fade-from") || "bottom";
        var onScroll = el.getAttribute("data-on-scroll") || 1;
        var delay = el.getAttribute("data-delay") || 0.15;

        var animation = {
          opacity: 0,
          ease: el.getAttribute("data-ease") || "power2.out",
          duration: duration,
          delay: delay,
          x: from === "left" ? -offset : from === "right" ? offset : 0,
          y: from === "top" ? -offset : from === "bottom" ? offset : 0
        };

        if (onScroll == 1 && typeof ScrollTrigger !== "undefined") {
          animation.scrollTrigger = {
            trigger: el,
            start: "top 85%"
          };
        }

        gsap.from(el, animation);
      });
  }

  // Nice select
  if ($.fn.niceSelect) {
    $(".tv-select").niceSelect();
  }

  // Timepicker / Datepicker
  if ($.fn.timepicker) {
    $("#ship_time").timepicker({
      timeFormat: "h:mm p",
      interval: 60
    });
  }

  if ($.fn.datepicker) {
    $("#ship_date").datepicker({
      format: "mm-dd-yyyy"
    });
  }

})
// Disable right click
document.addEventListener('contextmenu', function (e) {
    e.preventDefault();
});

// Disable inspect shortcuts
document.addEventListener('keydown', function (e) {
    if (
        e.key === 'F12' ||
        (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key.toUpperCase())) ||
        (e.ctrlKey && e.key.toLowerCase() === 'u')
    ) {
        e.preventDefault();
        return false;
    }
});
(jQuery);