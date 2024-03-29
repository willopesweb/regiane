document.addEventListener("DOMContentLoaded", function () {
  let lazyloadImages: NodeListOf<HTMLImageElement>;

  if ("IntersectionObserver" in window && typeof document !== "undefined") {
    lazyloadImages = document.querySelectorAll(".lazy");
    const imageObserver = new IntersectionObserver(function (
      entries,
      observer
    ) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          const image = entry.target as HTMLImageElement;
          image.src = image.dataset.src!;
          image.classList.remove("lazy");
          imageObserver.unobserve(image);
        }
      });
    });

    lazyloadImages.forEach(function (image) {
      imageObserver.observe(image);
    });
  } else {
    let lazyloadThrottleTimeout: NodeJS.Timeout;
    lazyloadImages = document?.querySelectorAll(".lazy") || [];

    function lazyload() {
      if (lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }

      lazyloadThrottleTimeout = setTimeout(function () {
        const scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function (img) {
          if (img.offsetTop < window.innerHeight + scrollTop) {
            img.src = img.dataset.src!;
            img.classList.remove("lazy");
          }
        });
        if (lazyloadImages.length == 0) {
          document?.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationchange", lazyload);
        }
      }, 20);
    }

    document?.addEventListener("scroll", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationchange", lazyload);
  }
});
