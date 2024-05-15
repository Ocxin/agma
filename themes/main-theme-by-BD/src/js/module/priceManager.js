export default class PriceManager {
  constructor() {
    this.$ = jQuery;
    this.basePrice = parseFloat(this.$("#base_price").val());
    console.debug("PriceManager initialized with base price:", this.basePrice);
    this.variantChanged = false;
    this.initEvents();
  }

  initEvents() {
    this.$("#varianti").change((e) => {
      this.variantChanged = true;
      this.changeVariant();
      this.updateTotalPrice();
    });

    this.$(
      ".accessories_wrapper [type=radio], .accessories_wrapper [type=checkbox]"
    ).change((e) => {
      this.variantChanged = false;
      this.handleAccessoryChange(jQuery(e.target));
      this.updateTotalPrice();
    });
  }

  handleAccessoryChange($input) {
    let id =
      $input.attr("type") === "checkbox"
        ? $input.attr("id")
        : $input.data("id");
    let label = $input.data("lable");
    let price = this.formatPrice(parseFloat($input.data("price")));
    let htmlString = this.generateString(label, price, id);
    let popupString = this.generateStringForPopup(label, price, id);

    if ($input.is(":checked")) {
      if ($input.attr("type") === "radio") {
        let name = $input.attr("name");
        this.$(`input[name="${name}"]`)
          .not($input)
          .each((i, elem) => {
            this.$(`#${this.$(elem).data("id")}`, "#addons").remove();
            this.$(`#${this.$(elem).data("id")}`, "#poup_addons").remove();
          });
      }
      this.$("#addons").prepend(htmlString);
      this.$("#poup_addons").append(popupString);
      this.setAccordionBackground($input, "rgba(212,224,224,0.5)");
    } else {
      this.$(`#${id}`, "#addons").remove();
      this.$(`#${id}`, "#poup_addons").remove();
      this.setAccordionBackground($input, "");
    }
  }
  changeVariant() {
    // Ottiene il label e il prezzo della variante selezionata
    let label = this.$("#varianti option:selected").text();
    let variantPrice = parseFloat(this.$("#varianti option:selected").val());
    console.debug("Variant changed to:", label, variantPrice);
    
    let partialPrice = variantPrice - this.basePrice;
    console.debug("Partial price:", partialPrice);
    let price = this.basePrice + partialPrice;
    console.debug("New price:", price);
    let id = this.$("#varianti").id;

    // Aggiorna il prezzo corrente e il testo della variante corrente
    this.$(".current-price").text(price.toFixed(2) + " €");
    this.$("#selected_variant").text(label);
    this.$("#selected_variant_sticky").text(label);


    let popupString = this.generateStringForPopup(label, price, id);
    console.debug(popupString);

    this.$(`#${id}`, "#poup_addons").remove();
    this.$("#poup_addons").append(popupString);
    this.$("#popup_base_price").remove();
  }

  updateTotalPrice() {
    // Prezzo base originale
    let basePrice = parseFloat(this.$("#base_price").val()) || 0;
    console.log("Base price:", basePrice);
  
    // Prezzo della variante selezionata, verifica se il valore è valido
    let variantValue = this.$("#varianti option:selected").val();
    let variantPrice = parseFloat(variantValue);
    if (!isNaN(variantPrice)) { // Controlla se il prezzo della variante è un numero valido
      if (this.variantChanged) {
        // Se 'variantChanged' è true e c'è una variante valida, sostituisci il basePrice con il variantPrice
        console.log("Variant changed, updating base price with variant price");
        basePrice = variantPrice;
      } else {
        // Altrimenti aggiungi il prezzo della variante al prezzo base, se valido
        console.log("Variant added to base price");
        basePrice += variantPrice;
      }
    }
  
    // Aggiungi il prezzo degli accessori selezionati
    this.$(".accessories_wrapper [type=radio]:checked, .accessories_wrapper [type=checkbox]:checked").each((i, elem) => {
      let accessoryPrice = parseFloat(this.$(elem).data("price"));
      if (accessoryPrice > 0) {
        basePrice += accessoryPrice;
      }
    });
  
    // Formatta il prezzo totale e aggiorna i campi appropriati
    let formattedPrice = basePrice.toFixed(2).replace(".", ",") + " €";
    console.debug("Total price updated to:", formattedPrice);
    this.$("#subtotal, #subtotal_popup").html(formattedPrice);
  
    // Aggiorna i dettagli dell'ordine
    this.updateOrderDetails();
  }
    
  generateString(label, price, id) {
    console.debug("Generating string for:", label, price, id);

    return `<div id="${id}" class="d-flex justify-content-between view-product__container__purchase__price"><div class="view-product__container__purchase__price__paragraph"><p>${label}</p></div><div class="view-product__container__purchase__price__paragraph"><p>€${price}</p></div></div>`;
  }

  generateStringForPopup(label, price, id) {
    return `<div id="${id}" class="d-flex justify-content-between align-items-center purchase-phases__content__list__item"><div class="purchase-phases__content__list__item__paragraph"><p>${label}</p></div><div class="purchase-phases__content__list__item__paragraph"><p>€${price}</p></div></div>`;
  }

  updateOrderDetails() {
    let data = this.$("#items_of_order")
      .serialize()
      .replaceAll("%20", " ")
      .replaceAll("on", "Si")
      .replaceAll("=", "  ");
    let dataString = data.replaceAll("&", "\n");
    console.debug("Order details updated:", dataString);
    this.$("#order_details").val(dataString);
  }

  setAccordionBackground($element, color) {
    $element.closest('div[class^="accordion-item"]').css({ background: color });
  }
  formatPrice(price) {
    // Assicurati che price sia una stringa
    if (typeof price === "number") {
      // Se price è un numero, convertilo in stringa per la formattazione
      price = price.toString();
    }

    if (typeof price === "string") {
      // Rimuovi il simbolo dell'euro e gli spazi, e sostituisci la virgola con il punto
      let numericPrice = parseFloat(
        price.replace("€", "").trim().replace(",", ".")
      );

      // Controlla se il risultato è NaN o non è un numero, e imposta a 0 se vero
      if (isNaN(numericPrice)) {
        numericPrice = 0;
      }

      // Ritorna il numero formattato come stringa nel formato valuta locale
      return numericPrice.toLocaleString("it-IT", { minimumFractionDigits: 2 });
    } else {
      // Se price non è una stringa e non è stato convertito in numero, imposta a 0
      return (0).toLocaleString("it-IT", { minimumFractionDigits: 2 });
    }
  }
}
