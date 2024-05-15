class AjaxFilter {
  constructor(containerSelector) {
    this.url = "/wp-admin/admin-ajax.php";
    this.container = document.querySelector(containerSelector);
    this.filter = this.container.querySelector(".filters");
    this.linkElement = this.container.querySelector(".component.button.secondary"); // Added reference to the link
    this.initEvents();
  }

  initEvents() {
    const buttons = this.container.querySelectorAll(".filter-btn");
    buttons.forEach((button) => {
      button.addEventListener("click", () => {
        buttons.forEach((btn) => btn.classList.remove("active"));
        button.classList.add("active");

        const categorySlug = button.getAttribute("data-filter");
        const termId = button.getAttribute("data-term-id");
        const postType = this.filter.dataset.postType;
        const isSlider = this.filter.dataset.isSlider;
        const layoutTile = this.filter.dataset.layoutTile;
        const filterFor = this.filter.dataset.filterFor;
        this.updateLinkHref(categorySlug);

        this.fetchData(
          categorySlug,
          termId,
          postType,
          isSlider,
          layoutTile,
          filterFor
        );
      });
    });
  }
  
  updateLinkHref(categorySlug) {
    this.linkElement.href = `case-categories/${encodeURIComponent(categorySlug)}/`;
  }


  fetchData(categorySlug, termId, postType, isSlider, layoutTile, filterFor) {
    const params = this.collectParams(
      categorySlug,
      termId,
      postType,
      isSlider,
      layoutTile,
      filterFor
    );
    const queryParams = new URLSearchParams({
      action: "filter_posts",
      ...params,
    }).toString();

    fetch(`${this.url}?${queryParams}`)
      .then((response) => response.json())
      .then((data) => this.updateContent(data))
      .catch((error) => console.error("Error fetching data:", error));
  }

  collectParams(
    categorySlug,
    termId,
    postType,
    isSlider,
    layoutTile,
    filterFor
  ) {
    return {
      "term-slug": encodeURIComponent(categorySlug),
      "term-id": encodeURIComponent(termId),
      "post-type": encodeURIComponent(postType),
      "is-slider": encodeURIComponent(isSlider),
      "layout-tile": encodeURIComponent(layoutTile),
      "filter-for": encodeURIComponent(filterFor),
    };
  }

  updateContent(response, swiper) {
    const slides = response.data.html; // Assicurati di riferirti al percorso corretto basato sulla struttura della risposta
    const container = this.container.querySelector(".swiper-wrapper");
    container.innerHTML = ""; // Pulisci il contenuto esistente

    if (slides.length === 0) {
      container.innerHTML =
        '<div class="swiper-slide">Nessun post trovato.</div>';
    } else {
      slides.forEach((htmlSlide) => {
        container.innerHTML += htmlSlide; // Aggiungi direttamente l'HTML ricevuto al container
      });
    }

    if (swiper) {
      swiper.update();
      swiper.params.loop = true;
    }
    document.dispatchEvent(new CustomEvent('contentUpdated'));

  }
}

export default AjaxFilter;
