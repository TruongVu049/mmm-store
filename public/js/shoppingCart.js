const shoppingCart = (function () {
  const form = document.querySelector("#form_shoppingcart");
  const container = document.querySelector(".container-shoppingcart");
  const containerContent = document.querySelector(".container-content");
  const userId = document.querySelector("#checkLogin")?.value ?? 0;
  const loader = document.querySelector(".loader");
  const quantity = document.querySelector(".quantity");
  const sum = document.querySelector(".sum");
  const err = document.querySelector(".err-shoppingcart");
  let isLoading = false;
  let currentPage = 1;
  const limit = 5;
  let total = 0;
  let products = [];
  let productChecked = [];
  let idTimeOut = null;
  return {
    async getProducts(page, limit) {
      const res = await fetch(
        `api/layspgiohang.php?userid=${userId}&sort=&limit=${
          (page - 1) * limit
        },${limit}`
      );
      return await res.json();
    },
    formatPrice(n) {
      let parts = n.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return `₫ ${parts.join(",")}`;
    },
    showProducts(data) {
      data.forEach((item) => {
        const elmContent = document.createElement("div");
        elmContent.classList.add(
          "flex",
          "items-center",
          "hover:bg-gray-100",
          "-mx-8",
          "px-6",
          "py-5"
        );
        elmContent.innerHTML = `
            <div class="flex w-2/5 md:flex-row flex-col">
                <div class="flex items-center gap-2 ">
                    <input name='sps[]' value="${
                      item.kcspid
                    }" type="checkbox" name="checkbox" class="accent-green-400 w-6 h-6  bg-gray-100 border-gray-300 rounded">
                    <div class="md:h-24 md:w-24 h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                        <img src="${item.hinhanh}">
                    </div>
                </div>
                <div class="flex flex-col justify-between ml-4 flex-grow">
                    <span class="font-medium md:text-sm text-xs line-clamp-2 hover:text-[#00c16a]">${
                      item.ten
                    }</span>
                    <span class=" md:text-sm text-xs">Size: ${
                      item.kichco
                    } </span>
                </div>
            </div>
            <div class="relative flex items-center max-w-[8rem]">
              <button data-decrease-qt="${
                item.kcspid
              }" type="button"  class="bg-gray-100    hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100  focus:ring-2 focus:outline-none">
                  <svg data-decrease-qt='${
                    item.kcspid
                  }' class="w-3 h-3 text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                      <path data-decrease-qt='${
                        item.kcspid
                      }' stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                  </svg>
              </button>
              <input disabled data-input-${item.kcspid} type="text" value="${
          item.soluong
        }" class="bg-gray-50 border border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 " />
              <button data-increase-qt="${
                item.kcspid
              }" type="button"  class="bg-gray-100    hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100  focus:ring-2 focus:outline-none">
                  <svg data-increase-qt='${
                    item.kcspid
                  }' class="w-3 h-3 text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                      <path data-increase-qt='${
                        item.kcspid
                      }' stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                  </svg>
              </button>
          </div>
            <span class="text-center w-1/5 font-semibold text-rose-500 text-sm">${this.formatPrice(
              parseFloat(item.gia)
            )}</span>
            <span data-kcspid-${item.kcspid} class="text-center w-1/5 font-semibold text-rose-500 text-sm">${this.formatPrice(
              parseFloat(item.gia) * parseInt(item.soluong)
            )}</span>
            
            <button type="button" data-remove-product="${
              item.kcspid
            }" class="text-center p-4 font-semibold text-sm text-gray-800 hover:text-red-500 cursor-pointer">
                <svg data-remove-product="${
                  item.kcspid
                }" class="w-6 h-6  " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path data-remove-product="${
                      item.kcspid
                    }" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>
            </button>
        `;
        containerContent.appendChild(elmContent);
      });
    },
    hideLoader() {
      loader.classList.add("hidden");
    },
    showLoader() {
      loader.classList.remove("hidden");
    },
    async loadProducts(page, limit) {
      this.showLoader();
      setTimeout(async () => {
        try {
          if (total === 0 || total === limit) {
            isLoading = true;
            const response = await this.getProducts(page, limit);
            if (response.length == 0) {
              total = 100;
            } else {
              total = response.length;
              products.push(...response);
            }
            this.showProducts(response);
          }
        } catch (error) {
          isLoading = false;
          console.log(error.message);
        } finally {
          isLoading = false;
          this.hideLoader();
        }
      }, 500);
    },
    async updateQt(id, type, qt) {
      const res = await fetch("api/capnhatslgiohang.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify({
          id: id,
          type: type,
          qt: qt,
        }),
      });
      const data = await res.json();
      return data;
    },
    async removePd(id) {
      const res = await fetch("api/xoaspgiohang.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify({
          id: id,
        }),
      });
      const data = await res.json();
      return data;
    },
    async fetchQuantity(userId) {
      const res = await fetch(`api/layslgiohang.php?userid=${userId}`);
      const data = await res.json();
      return data;
    },
    init() {
      container.addEventListener(
        "scroll",
        () => {
          if (isLoading) return;
          if (
            Math.ceil(container.clientHeight + container.scrollTop) >=
            container.scrollHeight - 1
          ) {
            if (total === limit) {
              currentPage++;
              this.loadProducts(currentPage, limit);
            }
          }
        },
        {
          passive: true,
        }
      );
      this.loadProducts(currentPage, limit);

      containerContent.addEventListener("click", (e) => {
        if (e.target.tagName == "INPUT" && e.target.name === "sps[]") {
          if (!err.classList.contains("hidden")) {
            err.classList.add("hidden");
          }
          const kcspid = e.target.value;
          if (e.target.checked) {
            productChecked.push(
              products.find(
                (item) => parseInt(item.kcspid) === parseInt(kcspid)
              )
            );
          } else {
            productChecked = productChecked.filter(
              (item) => !(parseInt(item.kcspid) === parseInt(kcspid))
            );
          }
          //uUI
          quantity.innerHTML = "Đã chọn: " + productChecked.length;
          sum.innerHTML = this.formatPrice(
            productChecked.reduce((prev, curv) => {
              return prev + curv.gia * curv.soluong;
            }, 0)
          );
        } else if (
          e.target.tagName === "BUTTON" ||
          e.target.tagName === "svg" ||
          e.target.tagName === "path"
        ) {
          if (e.target.dataset.increaseQt || e.target.dataset.decreaseQt) {
            const data = {
              id: null,
              type: null,
            };
            if (e.target.dataset.decreaseQt) {
              data.id = e.target.dataset.decreaseQt;
              data.type = "decrease";
            } else if (e.target.dataset.increaseQt) {
              data.id = e.target.dataset.increaseQt;
              data.type = "increase";
            }
            const productItem = products.find(
              (item) => parseInt(item.kcspid) === parseInt(data.id)
            );
            const elm = document.querySelector(`[data-input-${data.id}`);
            if (data.type === "decrease") {
              if (productItem.soluong === 1) {
                return;
              }
            }

            document.getElementById("modal-spinner").classList.remove("hidden");
            this.updateQt(
              productItem.kcspid,
              data.type === "decrease" ? "giam" : "tang",
              productItem.soluong
            )
              .then((res) => {
                if (res) {
                  data.type === "decrease"
                      ? (productItem.soluong = productItem.soluong - 1)
                      : (productItem.soluong = productItem.soluong + 1);
                    elm.value = productItem.soluong;
                    products = products.map((item) => {
                      if (item.kcspid === productItem.kcspid) {
                        return productItem;
                      }
                      return item;
                    });
                    document.querySelector(
                      "[data-button-change"
                    ).dataset.buttonChange = "true";
                    let itemGh = products.find(e=>parseInt(e.kcspid) === parseInt(productItem.kcspid));
                    if(itemGh){
                      document.querySelector(`[data-kcspid-${productItem.kcspid}]`).innerHTML = this.formatPrice(parseFloat(itemGh.gia) * parseFloat(itemGh.soluong));
                    }
                    productChecked = productChecked.map(item=>{
                      if(parseInt(item.kcspid) === parseInt(itemGh.kcspid))
                        return itemGh
                      return item;
                    })
                    sum.innerHTML = this.formatPrice(
                      productChecked.reduce((prev, curv) => {
                        return prev + curv.gia * curv.soluong;
                      }, 0)
                    );
                }
              })
              .catch((err) => {})
              .finally(() => {
                if(idTimeOut) clearTimeout(idTimeOut);
                  idTimeOut = setTimeout(() => {
                    document
                    .getElementById("modal-spinner")
                    .classList.add("hidden");
                  }, 250);
              });
          } else {
            document.getElementById("modal-spinner").classList.remove("hidden");
            this.removePd(e.target.dataset.removeProduct)
              .then((res) => {
                if (res) {
                  products = products.filter((item) => {
                    return (
                      parseInt(item.kcspid) !==
                      parseInt(e.target.dataset.removeProduct)
                    );
                  });
                  productChecked = productChecked.filter((item) => {
                    return (
                      parseInt(item.kcspid) !==
                      parseInt(e.target.dataset.removeProduct)
                    );
                  });
                  document.querySelector(
                    "[data-button-change"
                  ).dataset.buttonChange = "true";
                  quantity.innerHTML = "Đã chọn: " + productChecked.length;
                  if(productChecked.length == 0){
                    sum.innerHTML = 0;
                  }else{
                    sum.innerHTML = this.formatPrice(
                      productChecked.reduce((prev, curv) => {
                        return prev + curv.gia * curv.soluong;
                      }, 0)
                    );
                  }
                }
              })
              .catch((err) => {})
              .finally(async () => {
                if(idTimeOut) clearTimeout(idTimeOut);
                  idTimeOut = setTimeout(async () => {
                    document
                    .getElementById("modal-spinner")
                    .classList.add("hidden");
                    this.showLoader();
                    containerContent.innerHTML = "";
                    const cqt = await this.fetchQuantity(
                      document.querySelector("#checkLogin")?.value ?? 0
                    );
                    document.querySelector(".cart-drawer__view").innerHTML =
                      parseInt(cqt["sl"]) > 99 ? "99+" : cqt["sl"];
                    this.showProducts(products);

                    this.hideLoader();
                  }, 250);
              });
          }
        }
      });

      form.addEventListener("submit", (e) => {
        e.preventDefault();
        if (productChecked.length === 0) {
          err.innerHTML =
            "Vui lòng chọn vào sản phẩm trước khi tiến hành thanh toán!";
          err.classList.remove("hidden");
        } else {
          HTMLFormElement.prototype.submit.call(form);
        }
      });
    },
  };
})();

shoppingCart.init();
