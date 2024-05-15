class NoAjaxFilter {
  constructor(containerSelector, filterSelector, swiper = null) {
    this.container = document.querySelector(containerSelector);
    this.filterButtons = document.querySelectorAll(filterSelector);
    this.swiper = swiper; // L'istanza di Swiper è ora opzionale

    this.addEventListeners();
  }

  addEventListeners() {
    this.filterButtons.forEach((button) =>
      button.addEventListener("click", (e) =>
        this.filterCards(e.target.dataset.filter)
      )
    );
  }

  filterCards(filter) {
    const cards = this.container.querySelectorAll(".tile");
    let visibleCount = 0;

    cards.forEach((card) => {
      if (filter === "all") {
        card.style.display = "block"; // Mostra tutte le card
        visibleCount++; // Conta le card visibili
      } else {
        const categories = card.dataset.category.split(" ");
        if (categories.includes(filter)) {
          card.style.display = "block"; // Mostra la card se corrisponde al filtro
          visibleCount++; // Conta le card visibili
        } else {
          card.style.display = "none"; // Nasconde la card se non corrisponde
        }
      }
    });

    this.updateActiveButton(filter);
    if (this.swiper) {
      this.updateSwiperConfiguration(visibleCount);
      this.swiper.update();
    }
  }

  updateActiveButton(activeFilter) {
    this.filterButtons.forEach((button) => {
      button.classList.remove("active");
      if (button.dataset.filter === activeFilter) {
        button.classList.add("active");
      }
    });
  }
  
  updateSwiperConfiguration(visibleCount) {
    if (visibleCount < 5) {
      this.swiper.params.loop = false;
    } else {
      this.swiper.params.loop = true;
    }
  }
}

export default NoAjaxFilter;
