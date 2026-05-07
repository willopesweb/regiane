document.addEventListener("DOMContentLoaded", function () {
  const lazyImages = Array.from(
    document.querySelectorAll<HTMLImageElement>("img.lazy")
  );

  function loadImage(image: HTMLImageElement): void {
    if (image.dataset.src) image.src = image.dataset.src;
    if (image.dataset.srcset) image.srcset = image.dataset.srcset;

    image.addEventListener(
      "load",
      () => {
        image.classList.remove("lazy");
        image.classList.add("is-loaded");
      },
      { once: true }
    );

    image.addEventListener(
      "error",
      () => {
        image.classList.remove("lazy");
      },
      { once: true }
    );
  }

  // typeof evita o narrowing para `never` no else branch (strict: true + DOM lib)
  if (typeof IntersectionObserver !== "undefined") {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            loadImage(entry.target as HTMLImageElement);
            observer.unobserve(entry.target);
          }
        });
      },
      { rootMargin: "300px 0px" }
    );

    lazyImages.forEach((image) => observer.observe(image));
  } else {
    // Fallback para navegadores sem IntersectionObserver
    let throttleTimeout: ReturnType<typeof setTimeout> | null = null;
    let remaining = lazyImages.slice();

    const onScroll: EventListener = () => {
      if (throttleTimeout) clearTimeout(throttleTimeout);

      throttleTimeout = setTimeout(() => {
        const scrollTop = window.scrollY;

        remaining = remaining.filter((img) => {
          if (img.offsetTop < window.innerHeight + scrollTop + 300) {
            loadImage(img);
            return false;
          }
          return true;
        });

        if (remaining.length === 0) {
          document.removeEventListener("scroll", onScroll);
          window.removeEventListener("resize", onScroll);
          window.removeEventListener("orientationchange", onScroll);
        }
      }, 20);
    };

    onScroll(new Event("init")); // Carrega imagens já visíveis ao iniciar
    document.addEventListener("scroll", onScroll);
    window.addEventListener("resize", onScroll);
    window.addEventListener("orientationchange", onScroll);
  }
});
