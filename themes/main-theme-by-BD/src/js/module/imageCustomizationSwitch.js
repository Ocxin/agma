export default class ImageCustomizationSwitch {
  constructor(selector) {
    this.customizationComponent = document.querySelector(selector);
    if (!this.customizationComponent) {
      return;
    }

    this.init();
  }

  init() {
    const formItems =
      this.customizationComponent.querySelectorAll(".form-item");

    formItems.forEach((formItem) => {
      formItem.querySelectorAll(".form-check-input").forEach((radio) => {
        radio.addEventListener("change", () =>
          this.handleRadioChange(radio, formItem)
        );
      });
    });
  }

  handleRadioChange(radio, formItem) {
    const variantsExist = formItem.querySelectorAll(".variant").length > 0;

    if (!variantsExist) {
      return;
    }
    if (radio.id === "no") {
      this.hideAllVariantImages(formItem);
      this.showDefaultImage(formItem);
    } else {
      this.hideAllImages(formItem);
      if (radio.checked) {
        this.showSelectedVariantImage(radio.id, formItem);
      }
    }
  }

  hideAllVariantImages(formItem) {
    const allVariantImages = formItem.querySelectorAll(".variant");
    allVariantImages.forEach((img) => (img.style.display = "none"));
  }

  showDefaultImage(formItem) {
    const defaultImage = formItem.querySelector(".default-image");
    if (defaultImage) {
      defaultImage.style.display = "block";
    }
  }

  hideAllImages(formItem) {
    const allImages = formItem.querySelectorAll("img");
    allImages.forEach((img) => (img.style.display = "none"));
  }

  showSelectedVariantImage(selectedVariantId, formItem) {
    const variantImage = formItem.querySelector(
      `.variant.${selectedVariantId}`
    );
    if (variantImage) {
      variantImage.style.display = "block";
    }
  }
}
