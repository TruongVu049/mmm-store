(() => {
  const navbar = document.querySelector("#navbar-mb");
  const btnOpen = document.querySelector("[data-button-open]");
  btnOpen &&
    btnOpen.addEventListener("click", () => {
      navbar.classList.remove("invisible");
      navbar.classList.add("visible");
      navbar.firstElementChild.nextElementSibling.classList.remove(
        "translate-x-[100%]"
      );
      navbar.firstElementChild.nextElementSibling.classList.add(
        "translate-x-[0]"
      );
    });
  navbar.addEventListener("click", function (e) {
    if (
      e.target.id === "svg" ||
      e.target.id === "btn-close-nav" ||
      e.target.id === "navbar-overlay" ||
      e.target.tagName == "path"
    ) {
      this.classList.remove("visible");
      this.classList.add("invisible");
      this.firstElementChild.nextElementSibling.classList.remove(
        "translate-x-[0]"
      );
      this.firstElementChild.nextElementSibling.classList.add(
        "translate-x-[100%]"
      );
    }
  });
})();

(() => {
  const btnOpen = document.querySelector("[data-button-opensearch]");
  const modal = document.querySelector("#modal-search");
  const form = document.querySelector("#form-search");
  const input = document.querySelector("input[name='s']");
  btnOpen.addEventListener("click", (e) => {
    modal.classList.toggle("hidden");
    input.value = "";
    input.focus();
  });
  modal.addEventListener("click", (e) => {
    if (e.target.id === "container__search") {
      input.value = "";
      modal.classList.toggle("hidden");
    }
  });
  input.addEventListener("input", function () {
    if (this.value !== "") {
      input.setCustomValidity("");
    }
  });
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    
    if (input.value === "") {
      input.setCustomValidity("Vui lòng điền vào ô tìm kiếm!");
    } else {
      this.submit();
    }
  });
})();
