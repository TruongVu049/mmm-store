const user = (function () {
  const modal = document.querySelector("#modal-address");
  const btnOpen = document.querySelector("#btn-open-modalAd");
  const btnClose = document.querySelector("#btn-close-modalAd");
  const form = document.querySelector("#formAd");
  const ipPhone = form.elements["addPhone"];
  const ipSetDault = form.elements["macdinh"];
  const ipAddressDetails = form.elements["addressDetails"];
  const slProvince = form.elements["province"];
  const slDistrict = form.elements["district"];
  const slCommune = form.elements["commune"];
  const userId = document.getElementById("userId");
  const err = document.querySelector(".errModal");
  const list = document.querySelector(".listAddress");
  let isUpdate = false;
  let idUpdate = null;
  let arrProvince,
    arrDistrict,
    arrCommune = [];
  let arrAddress = [];
  return {
    async getAddress(type) {
      const res = await fetch(
        `https://vietnam-administrative-division-json-server-swart.vercel.app/${type}`
      );
      return await res.json();
    },
    showAddress(data, selectElm, id) {
      data.forEach((item) => {
        const elm = document.createElement("option");
        elm.appendChild(document.createTextNode(item.name));
        elm.setAttribute("value", item[id]);
        elm.setAttribute("data-name", item.name);
        selectElm.appendChild(elm);
      });
    },
    removeOptions(selectElm) {
      const op = selectElm.options[0];
      selectElm.innerHTML = "";
      selectElm.appendChild(op);
    },
    addErr(elm, mes) {
      elm.classList.add("border", "border-red-500");
      elm.nextElementSibling.innerHTML = mes;
      elm.nextElementSibling.classList.remove("hidden");
    },
    removeErr(elm) {
      elm.classList.remove("border", "border-red-500");
      elm.nextElementSibling.classList.add("hidden");
    },
    removeAllErr() {
      this.removeErr(ipPhone);
      this.removeErr(slProvince);
      this.removeErr(slDistrict);
      this.removeErr(slCommune);
      err.classList.add("hidden");
    },
    async fetchDataPost(
      id,
      phone,
      address,
      addressDetails,
      defaultAdd,
      userId
    ) {
      const res = await fetch(
        `${isUpdate ? "api/capnhatdiachi.php" : "api/themdiachi.php"}`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json; charset=utf-8",
          },
          body: JSON.stringify({
            id: id,
            phone: phone,
            address: address,
            addressDetails: addressDetails,
            defaultAdd: defaultAdd,
            userId: userId,
          }),
        }
      );
      const data = await res.json();
      return data;
    },
    async getList(id) {
      const res = await fetch(`api/laydiachi.php?userid=${id}`);
      return await res.json();
    },
    showList(data) {
      list.innerHTML = "";
      data.forEach((item) => {
        const elmContent = document.createElement("div");
        elmContent.classList.add(
          "flex",
          "justify-between",
          "items-start",
          "p-4",
          "text-gray-800"
        );
        elmContent.innerHTML = `
        <div>
            <h6>+${item.sdt}</h6>
            <p>${item.diachicuthe}, ${item.diachi}</p>
            ${
              parseInt(item.macdinh) === 1
                ? '<span class="mt-2 inline-block py-0.5 px-1 text-xs text-red-500 border border-red-500 rounded-md">Mặc định</span>'
                : '<span class="mt-2 inline-block py-0.5 px-1 text-xs text-gray-400 border border-gray-400 rounded-md">Địa chỉ lấy hàng</span>'
            }
        </div>
        <div>
            <button data-update-id="${
              item.id
            }" class="py-1.5 px-3 text-blue-600 hover:text-blue-500" type="button">Cập nhật </button>
            |
            ${
              parseInt(item.macdinh) === 0
                ? `<button data-remove-id="${item.id}" class="py-1.5 px-3 text-blue-600 hover:text-blue-500" type="button"> Xóa</button>`
                : ""
            }
        </div>
        `;
        list.appendChild(elmContent);
      });
    },
    async loadlist() {
      arrAddress = await this.getList(userId.value ?? 0);
      this.showList(arrAddress);
    },
    fillToForm(address) {
      ipPhone.value = address["sdt"];
      ipAddressDetails.value = address["diachicuthe"];
      ipSetDault.checked = parseInt(address["macdinh"]) && 1;
      let [_province, _district, _commune] = address["diachi"].split(",");
      this.showAddress(arrProvince, slProvince, "idProvince");
      let provinceId = arrProvince.find(
        (item) => item["name"] === _province.trim()
      )["idProvince"];
      slProvince.value = provinceId;

      let _arrDistrict = arrDistrict.filter(
        (item) => item.idProvince === slProvince.value
      );
      this.showAddress(_arrDistrict, slDistrict, "idDistrict");
      let districtId = _arrDistrict.find(
        (item) => item["name"] === _district.trim()
      )["idDistrict"];
      slDistrict.value = districtId;

      let _arrCommune = arrCommune.filter(
        (item) => item.idDistrict === slDistrict.value
      );
      this.showAddress(_arrCommune, slCommune, "idCommune");
      let communetId = _arrCommune.find(
        (item) => item["name"] === _commune.trim()
      )["idCommune"];
      slCommune.value = communetId;
    },
    async removeAddress(id) {
      const res = await fetch("api/xoadiachi.php", {
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
    async init() {
      //load
      this.loadlist();

      window.addEventListener("load", ()=>{
        Promise.all([
          this.getAddress("province"),
          this.getAddress("district"),
          this.getAddress("commune"),
        ])
          .then((results) => {
            [arrProvince, arrDistrict, arrCommune] = results;
          })
          .catch((err) => {})
          .finally(() => {});
      })

      // open modal
      btnOpen.addEventListener("click", () => {
        this.removeAllErr();
        form.reset();
        modal.classList.remove("hidden");
        modal.classList.add("fixed");
        this.showAddress(arrProvince, slProvince, "idProvince");
      });

      list.addEventListener("click", async (e) => {
        try {
          if (e.target.tagName === "BUTTON") {
            if (
              e.target.dataset.updateId &&
              typeof e.target.dataset.updateId === "string"
            ) {
              isUpdate = true;
              idUpdate = parseInt(e.target?.dataset?.updateId);
              this.removeAllErr();
              this.fillToForm(
                arrAddress.find(
                  (item) =>
                    parseInt(item.id) === parseInt(e.target?.dataset?.updateId)
                )
              );
              modal.classList.remove("hidden");
              modal.classList.add("fixed");
            } else if (
              e.target.dataset.removeId &&
              typeof e.target.dataset.removeId === "string"
            ) {
              document
                .getElementById("modal-spinner")
                .classList.remove("hidden");
              this.removeAddress(e.target.dataset.removeId)
                .then((res) => {
                  if (res) {
                    this.loadlist();
                  }
                })
                .catch(() => {
                  alert("Đã có lỗi xảy ra. Vui lòng thực hiện lại!");
                })
                .finally(() => {
                  document
                    .getElementById("modal-spinner")
                    .classList.add("hidden");
                });
            }
          }
        } catch (err) {}
      });

      // close modal
      btnClose.addEventListener("click", () => {
        if (isUpdate) {
          isUpdate = false;
          idUpdate = null;
        }
        modal.classList.remove("fixed");
        modal.classList.add("hidden");
      });

      slProvince.addEventListener("input", () => {
        this.removeOptions(slDistrict);
        this.removeOptions(slCommune);
        let res = arrDistrict.filter(
          (item) => item.idProvince === slProvince.value
        );
        this.showAddress(res, slDistrict, "idDistrict");
      });

      slDistrict.addEventListener("input", () => {
        this.removeOptions(slCommune);
        let res = arrCommune.filter(
          (item) => item.idDistrict === slDistrict.value
        );
        this.showAddress(res, slCommune, "idCommune");
      });

      form.addEventListener("submit", async (e) => {
        e.preventDefault();
        let isValid = true;
        if (!/^[0-9]{9,11}$/.test(ipPhone.value)) {
          isValid = false;
          this.addErr(ipPhone, "Số điện thoại không hợp lệ!");
        }
        if (slProvince.value === "") {
          isValid = false;
          this.addErr(slProvince, "Số chọn tỉnh/thành!");
        }
        if (slDistrict.value === "") {
          isValid = false;
          this.addErr(slDistrict, "Số chọn quận/huyện!");
        }
        if (slCommune.value === "") {
          isValid = false;
          this.addErr(slCommune, "Số chọn phường/xã!");
        }
        if (isValid) {
          let strProvince = slProvince.querySelector(
            `option[value='${slProvince.value}']`
          ).dataset.name;
          let strDistrict = slDistrict.querySelector(
            `option[value='${slDistrict.value}']`
          ).dataset.name;
          let strCommune = slCommune.querySelector(
            `option[value='${slCommune.value}']`
          ).dataset.name;
          const res = await this.fetchDataPost(
            idUpdate ?? -999,
            ipPhone.value,
            `${strProvince}, ${strDistrict}, ${strCommune}`,
            ipAddressDetails.value,
            ipSetDault.checked ? 1 : 0,
            userId.value ?? 0
          );
          if (!res) {
            this.addErr(err, "Đã có lỗi xảy ra. Vui lòng thực hiện lại!");
          } else {
            this.loadlist();
            modal.classList.remove("fixed");
            modal.classList.add("hidden");
          }
        }
      });

      ipPhone.addEventListener("input", () => {
        this.removeErr(ipPhone);
      });
      slProvince.addEventListener("input", () => {
        this.removeErr(slProvince);
      });
      slDistrict.addEventListener("input", () => {
        this.removeErr(slDistrict);
      });
      slCommune.addEventListener("input", () => {
        this.removeErr(slCommune);
      });
    },
  };
})();

user.init();
