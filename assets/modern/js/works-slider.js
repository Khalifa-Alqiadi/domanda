(function () {
    "use strict";

    const initWorksSliders = () => {
        if (typeof Swiper === "undefined") {
            return;
        }

        const prefersReducedMotion = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;

        document.querySelectorAll(".modern-works-slider").forEach((slider) => {
            if (slider.classList.contains("swiper-initialized")) {
                return;
            }

            const slideCount = slider.querySelectorAll(".swiper-slide").length;
            const controls = slider.querySelector(".modern-works-slider-controls");
            const isMagazine = slider.classList.contains("modern-works-slider--magazine");
            const isVideos = slider.classList.contains("modern-works-slider--videos");
            const isProducts = slider.classList.contains("doman-products-slider");
            const isSpecialSlider = isMagazine || isVideos || isProducts;

            if (slideCount <= 1) {
                slider.classList.add("is-static");
            }

            const swiper = new Swiper(slider, {
                speed: isProducts ? 850 : 700,
                slidesPerView: isProducts ? 1.08 : 1,
                spaceBetween: isProducts ? 14 : 16,
                watchOverflow: true,
                centerInsufficientSlides: true,
                grabCursor: slideCount > 1,
                loop: !isSpecialSlider && slideCount > 2,
                rewind: isProducts ? slideCount > 1 : (isVideos ? slideCount > 4 : (isMagazine ? slideCount > 3 : (slideCount > 1 && slideCount <= 2))),
                autoplay: slideCount > 1 && !prefersReducedMotion ? {
                    delay: isProducts ? 5200 : 4500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                } : false,
                keyboard: {
                    enabled: true,
                    onlyInViewport: true
                },
                navigation: {
                    prevEl: slider.querySelector(".modern-works-slider-prev"),
                    nextEl: slider.querySelector(".modern-works-slider-next")
                },
                pagination: {
                    el: slider.querySelector(".modern-works-slider-pagination"),
                    clickable: true
                },
                breakpoints: isProducts ? {
                    768: { slidesPerView: 2, spaceBetween: 20 },
                    1200: { slidesPerView: 3, spaceBetween: 22 }
                } : {
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 18
                    }
                }
            });

            const syncLockedState = () => {
                slider.classList.toggle("is-locked", swiper.isLocked);
            };

            syncLockedState();
            swiper.on("lock", syncLockedState);
            swiper.on("unlock", syncLockedState);
            swiper.on("breakpoint", syncLockedState);

            if (controls) {
                controls.addEventListener("focusin", () => {
                    if (swiper.autoplay && swiper.autoplay.running) {
                        swiper.autoplay.stop();
                    }
                });

                controls.addEventListener("focusout", () => {
                    if (swiper.autoplay && !prefersReducedMotion) {
                        swiper.autoplay.start();
                    }
                });
            }
        });
    };

    window.addEventListener("load", initWorksSliders);
})();
