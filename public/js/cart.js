const cart = (function () {
  const cartCT = document.querySelector("#cart");
  const cart = document.querySelector(".cart-drawer__container");
  const quantity = document.querySelector(".cart-drawer__view");
  const btn = document.querySelector("[data-button-openCart]");
  const userId = document.querySelector("#checkLogin")?.value ?? 0;
  const btnClose = document.querySelector("[data-button-closeCart]");
  return {
    async fetchQuantity(userId) {
      const res = await fetch(`api/layslgiohang.php?userid=${userId}`);
      const data = await res.json();
      return data;
    },
    async fetchProduct(userId) {
      const res = await fetch(
        `api/layspgiohang.php?userid=${userId}&sort=desc&limit=4`
      );
      const data = await res.json();
      return data;
    },
    setLoading() {
      cart.classList.add("animate-pulse");
      cart.innerHTML = "";
      new Array(3).fill(1).forEach((item) => {
        cart.innerHTML += `
        <div class="flex py-6 justify-between">
          <div class="flex items-start gap-4  ">
              <div class="h-24 w-24 bg-gray-300 rounded-md">
              </div>
              <div>
                  <div class="h-2.5 bg-gray-300 rounded-full  w-32 mb-2.5"></div>
                  <div class="h-2.5 bg-gray-300 rounded-full  w-40 mb-2.5"></div>
                  <div class="h-2.5 bg-gray-300 rounded-full  w-48 mb-2.5"></div>
              </div>
          </div>
          <div>
              <div class="h-2.5 bg-gray-300 rounded-full  w-12"></div>
          </div>
      </div>
        `;
      });
    },
    openCartCT() {
      cartCT.classList.remove("invisible");
      cartCT.classList.add("visible");
      cartCT.firstElementChild.nextElementSibling.classList.remove(
        "translate-x-[100%]"
      );
      cartCT.firstElementChild.nextElementSibling.classList.add(
        "translate-x-[0]"
      );
    },
    closeCartCT() {
      cartCT.classList.remove("visible");
      cartCT.classList.add("invisible");
      cartCT.firstElementChild.nextElementSibling.classList.remove(
        "translate-x-[0]"
      );
      cartCT.firstElementChild.nextElementSibling.classList.add(
        "translate-x-[100%]"
      );
    },
    renderData(data) {
      // select sanpham.id as spid, loaisanpham.id as lspid, kichcosanpham.id as kcspid,, loaisanpham.hinhanh, kichcosanpham.kichco, giohang.soluong
      return data
        .map((item) => {
          return `
          <li class="flex py-6">
            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                <img src="${item.hinhanh}">
            </div>
            <div class="ml-4 flex flex-1 flex-col">
                <div>
                    <div class=" flex justify-between text-base font-medium text-gray-900 gap-4">
                        <h3 class="line-clamp-2 hover:text-[#00c16a]">
                            <a href="chitietsanpham.php?spid=${item.spid}">${
            item.ten
          }</a>
                            
                        </h3>
                        <p class="ml-4 text-rose-500">${this.formatPrice(
                          item.gia
                        )}</p>
                    </div>
                    <span class="text-gray-500">${item.kichco}</span>
                    <p class="text-gray-500">X ${item.soluong}</p>
                </div>
            </div>
        </li>
      `;
        })
        .join(" ");
    },
    formatPrice(n) {
      let parts = n.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return `₫ ${parts.join(",")}`;
    },
    async init() {
      // load
      let data = await this.fetchQuantity(userId);
      quantity.innerHTML = parseInt(data["sl"]) > 99 ? "99+" : data["sl"];
      //
      btn.addEventListener("click", async () => {
        this.openCartCT();
        const isChange = JSON.parse(
          document.querySelector("[data-button-change").dataset.buttonChange
        );
        if (isChange) {
          this.setLoading();
          document.querySelector("[data-button-change").dataset.buttonChange =
            "false";
          this.fetchProduct(userId)
            .then((data) => {
              if (data.length != 0) {
                str = this.renderData(data);
                cart.innerHTML = str;
              } else {
                cart.innerHTML = "";
              }
            })
            .catch(() => {})
            .finally(() => {
              cart.classList.remove("animate-pulse");
            });
        }
      });
      //
      //close
      btnClose && btnClose.addEventListener("click", this.closeCartCT);
    },
  };
})();
if (!isNaN(parseInt(document.querySelector("#checkLogin")?.value))) {
  cart.init();
}

// ${
//   item.KhuyenMai_id != null
//     ? item.thoigian_kt != null
//       ? new Date(item.thoigian_kt) <
//         new Date(
//           new Date().getFullYear() +
//             "-" +
//             (new Date().getMonth() + 1) +
//             "-" +
//             new Date().getDate()
//         )
//         ? this.formatPrice(parseFloat(item.gia))
//         : this.formatPrice(
//             parseFloat(item.gia) -
//               parseFloat(item.gia) *
//                 (parseFloat(item.phantram) / 100)
//           )
//       : this.formatPrice(
//           parseFloat(item.gia) -
//             parseFloat(item.gia) *
//               (parseFloat(item.phantram) / 100)
//         )
//     : this.formatPrice(parseFloat(item.gia))
// }
