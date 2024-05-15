import AjaxFilter from "./module/ajaxFilter.js";
import Swiper from "swiper/bundle";
import { initializeAggregatorSwiper } from "./slider/aggregator.js";
import { initializeBigSwiper } from "./slider/gallery-big.js";
import { initializeProductSwiper } from "./slider/product.js";
import PriceManager from "./module/priceManager.js";
import ImageCustomizationSwitch from "./module/imageCustomizationSwitch.js";
import LazyBackgroundLoader from "./module/lazyLoad.js";
import { initializeMediumSwiper } from "./slider/gallery-medium.js";

document.addEventListener("DOMContentLoaded", function () {
  // Inizializzazione degli Swiper
  const swiperAggregator = initializeAggregatorSwiper();
  if (swiperAggregator) new AjaxFilter(".contentlist", swiperAggregator);

  const swiperBig = initializeBigSwiper();
  const swiperProduct = initializeProductSwiper();
  const swiperMedium = initializeMediumSwiper();



  new ImageCustomizationSwitch(".component.product-customization");

  new LazyBackgroundLoader();

  new PriceManager();

  // Gestione dei Pin nelle immagini, se presenti
  const imageWithPin = document.querySelector(".image-with-pin");
  if (imageWithPin) {
    imageWithPin.querySelectorAll(".pin").forEach((pin) => {
      pin.addEventListener("click", function (event) {
        event.stopPropagation();
        const popup = this.querySelector(".pin-popup");
        if (popup.style.display === "block") {
          popup.style.display = "none";
        } else {
          popup.style.display = "block";
        }
      });
    });

    document.addEventListener("click", function () {
      document.querySelectorAll(".pin-popup").forEach((popup) => {
        popup.style.display = "none";
      });
    });
  }

  
});

// document.addEventListener("DOMContentLoaded", function() {
//   // Seleziona il menu a discesa
//   var select = document.getElementById('varianti');

//   // Recupera il prezzo base dal elemento specifico e lo memorizza
//   var basePriceElement = document.getElementById('base_price');
//   var basePrice = parseFloat(basePriceElement.value);

//   // Funzione per aggiornare il prezzo e l'etichetta della variante
//   function updatePriceAndLabel() {
//       // Prende il valore aggiuntivo dall'opzione selezionata
//       var addPrice = parseFloat(select.options[select.selectedIndex].value);

//       // Trova tutti gli elementi con data-type="price"
//       var priceElements = document.querySelectorAll('[data-type="price"]');

//       priceElements.forEach(function(element) {
//           // Calcola il nuovo prezzo utilizzando sempre il prezzo base originale
//           var newPrice = basePrice + addPrice;

//           // Formatta il nuovo prezzo per riportarlo al formato originale con la virgola e due decimali
//           var formattedPrice = newPrice.toFixed(2).replace('.', ',') + '€';

//           // Aggiorna il display del prezzo
//           element.textContent = formattedPrice;
//       });

//       // Aggiorna l'etichetta della variante selezionata
//       document.getElementById('selected_variant').textContent = select.options[select.selectedIndex].text;
//   }

//   // Aggiungi un event listener per il cambio di selezione
//   select.addEventListener('change', updatePriceAndLabel);
// });

document.addEventListener("scroll", function () {
  var button = document.querySelector(".product-feature .component.button");
  var newElement = document.querySelector(".component.product-price-sticky");
  var buttonRect = button.getBoundingClientRect();

  // Controlla se l'elemento è uscito completamente dalla viewport dall'alto
  if (buttonRect.bottom < 0) {
    newElement.style.top = "4.375rem"; // Scivola in vista dall'alto
  } else {
    newElement.style.top = "-100%"; // Ritorna fuori dalla vista
  }
});
