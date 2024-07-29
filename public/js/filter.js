(() => {
  const btnOpen = document.querySelector("#btn-open-filter");
  const modal = document.querySelector("#modal-filter");
  btnOpen.addEventListener("click", () => {
    modal.classList.toggle("hidden");
  });
  modal.addEventListener("click", function (e) {
    
    if (e.target.id === "filter-overlay" || e.target.id === "btn-close-filter")
      modal.classList.toggle("hidden");
    else {
      if (e.target.tagName == "path" || e.target.tagName == "svg")
        modal.classList.toggle("hidden");
    }
  });
})();
const customRangeInput = () => {
  let rangeMax = document.querySelector("#ip_gia_ln");
  let rangeMin = document.querySelector("#ip_gia_nn");
  let outputRangeMax = document.querySelector(".gia_ln");
  let outputRangeMin = document.querySelector(".gia_nn");
  
  rangeMax.addEventListener("input", function () {
    
    if (parseInt(this.value) - parseInt(rangeMin.value) < 100000) {
      rangeMin.value = parseInt(rangeMin.value) - 100000;
    }
    outputRangeMax.innerHTML = rangeMax.value;
    outputRangeMin.innerHTML = rangeMin.value;
  });
  rangeMin.addEventListener("input", function () {
    if (parseInt(rangeMax.value) - parseInt(this.value) < 100000) {
      rangeMax.value = parseInt(rangeMax.value) + 100000;
    }
    outputRangeMax.innerHTML = rangeMax.value;
    outputRangeMin.innerHTML = rangeMin.value;
  });
};
customRangeInput();
