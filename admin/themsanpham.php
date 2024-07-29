<?php
include_once("./includes/header.php");
// include_once "../classes/Database.php";
include_once "../classes/DanhMuc.php";
include_once "../classes/SanPham.php";
include_once "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['data']) && isset($_POST['ten'])) {
    $sp = new SanPham();
    $themSanPham = $sp->themSanPham($_POST);
}
?>


<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Thêm sản phẩm</h1>
        </div>
    </div>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" id="myForm" runat="server" class="p-6 bg-white shadow rounded-lg" style="background-color: #fff">
        <input name="id" type="text" id="id" class="sr-only bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

        <div class="mb-6">
            <label for="ten" class="block mb-2 text-sm font-medium text-gray-900 ">Tên sản phẩm</label>
            <input required name="ten" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
            <span class="errTen hidden text-red-500 md:text-base text-sm"></span>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2 ">
            <div>
                <label for="DanhMuc_id" class="block mb-2 text-sm font-medium text-gray-900 ">Danh mục</label>
                <select name="DanhMuc_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <?php
                    $dm = new DanhMuc();
                    $ds = $dm->layDanhMuc();
                    foreach ($ds as $item) { ?>
                        <option value="<?php echo  $item['id'] ?>"><?php echo  $item['ten'] ?></option>
                    <?php  }  ?>
                </select>
            </div>
            <div>
                <label for="gioitinh" class="block mb-2 text-sm font-medium text-gray-900 ">Giới tính</label>
                <select name="gioitinh" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="nam">Nam</option>
                    <option value="nữ">Nữ</option>
                    <option selected="" value="unisex">Unisex</option>
                </select>
            </div>

        </div>
        <div class="mb-6">
            <label for="gia" class="block mb-2 text-sm font-medium text-gray-900 ">Giá tiền</label>
            <input required name="gia" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
            <span class="errGia hidden text-red-500 md:text-base text-sm"></span>
        </div>
        <div class="mb-6">
            <label for="mota" class="block mb-2 text-sm font-medium text-gray-900 ">Mô tả</label>
            <textarea required name="mota" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 " placeholder=""></textarea>
            <span class="errMoTa hidden text-red-500 md:text-base text-sm"></span>
        </div>
        <div class="mb-6">
            <p class="block mb-2 text-sm font-medium text-gray-900 ">Hình ảnh</p>
            <label style="width: 100px; height: 100px;" for="file1" class="flex flex-col items-center justify-center  border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div id="frame_image1" class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg id="svg_upload1" class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"></path>
                    </svg>
                    <img id="img_upload1" class="hidden w-8 h-8" src="" />

                </div>
                <input onchange="uploadImage1(event)" id="file1" name="file1" type="file" class="hidden " />
            </label>
            <input id="image1" name="image1" type="text" class="hidden" />
            <div id="img_loading1" class="hidden">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
            <span class="errHinhAnh hidden text-red-500 md:text-base text-sm"></span>
        </div>
        <input type="text" name="data" class="sr-only" />
        <div class="mb-6 flex justify-between items-center">
            <label for="options" class="block mb-2 text-sm font-medium text-gray-900 ">Tùy chọn</label>
            <button type="button" id="btn_open" class="inline-flex px-4 py-2 text-base text-white bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 rounded-md ml-6 mb-3">
                <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-white -ml-1 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Thêm tùy chọn
            </button>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6">
            <table id="table_option" class="w-full text-sm text-left text-gray-200">
                <thead class="text-xs text-gray-50 uppercase bg-gray-700 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Ảnh
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Màu
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Size
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Số lượng
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Xóa
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="text-center py-4 bg-gray-200 text-gray-800">......</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="error" class="errTuyChon hidden mb-2 text-rose-500 sm:text-lg text-base">Vui lòng thêm tùy chọn!</div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
            Thêm
        </button>
    </form>
</main>
<div id="modal-option" class="hidden fixed inset-0 transition z-[200]">
    <div class="absolute inset-0"></div>
    <div id="container__search" class="bg-gray-600 bg-opacity-40 relative h-full w-full ml-auto z-[201] p-2 flex justify-center items-center">
        <div class="container mx-auto">
            <form id="form_options" class="p-6 bg-white shadow rounded-lg text-left" style="background-color: #fff">
                <div class="flex gap-6">
                    <div style=" width: 50%;">
                        <div class="mb-6">
                            <label for="ip_size" class="block mb-2 text-sm font-medium text-gray-900 ">Size</label>
                            <input type="text" name="ip_size" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="ip_quantity" class="block mb-2 text-sm font-medium text-gray-900 ">Số lượng</label>
                            <input type="number" name="ip_quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
                        </div>
                        <div class="flex items-center justify-start  space-x-2 gap-4 rounded-b dark:border-gray-600">
                            <button type="button" id="btn_createOpionValue" class="  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Thêm</button>
                        </div>
                    </div>
                    <div style="width: 50%;">
                        <div class="mb-6">
                            <label for="ip_color" class="block mb-2 text-sm font-medium text-gray-900 ">Màu sắc</label>
                            <input name="ip_color" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="" required="">
                        </div>
                        <div class="mb-6">
                            <p class="block mb-2 text-sm font-medium text-gray-900 ">Ảnh</p>
                            <label style="width: 100px; height: 100px;" for="file" class="flex flex-col items-center justify-center  border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div id="frame_image" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg id="svg_upload" class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"></path>
                                    </svg>
                                    <img id="img_upload" class="hidden" src="https://firebasestorage.googleapis.com/v0/b/fashion-app-84f9f.appspot.com/o/images%2F11111111111111111111111.PNG-Tue%20Jan%2030%202024%2016%3A47%3A35%20GMT%2B0700%20(Gi%E1%BB%9D%20%C4%90%C3%B4ng%20D%C6%B0%C6%A1ng)?alt=media&amp;token=1dc2c393-b94a-4301-adf6-2bd71ec5d5ad" />

                                </div>
                                <input onchange="uploadImage(event)" id="file" name="file" type="file" class="hidden" />
                            </label>
                            <input id="image" name="image" type="text" class="hidden" />
                            <div id="img_loading" class="hidden">
                                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <table id="table_optionValue" class="w-full text-sm text-left text-gray-200">
                            <thead class="text-xs text-gray-50 uppercase bg-gray-700 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Size
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Số lượng
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Xóa
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-center py-4 bg-gray-200 text-gray-800">......</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="my-2">
                    <span id="err_craeteOptionValue" class="hidden mb-2 text-rose-500 sm:text-lg text-base ">Vui lòng điền đẩy đủ màu sắc, hình ảnh, size và số lượng!</span>
                </div>
                <div style="padding-top: 24px;" class="flex items-center justify-end space-x-2 border-t border-gray-200 gap-4 rounded-b dark:border-gray-600">
                    <button id="btn_close" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">Hủy</button>
                    <button id="btn-createOption" type="button" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modal-edit_option" class="hidden fixed inset-0 transition z-[200]">
    <div class="absolute inset-0"></div>
    <div id="" class="bg-gray-600 bg-opacity-40 relative h-full w-full ml-auto z-[201] p-2 flex justify-center items-center">
        <div class="container mx-auto">
            <div class="bg-white shadow rounded-lg" style="width: 50%; margin: 0 auto;">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t ">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Sửa tùy chọn
                    </h3>
                </div>
                <!-- Modal body -->
                <form id="edit_form_options" class="p-6 bg-white shadow rounded-lg text-left" style="background-color: #fff">
                    <div class="mb-6">
                        <label for="ip_edit_size" class="block mb-2 text-sm font-medium text-gray-900 ">Size</label>
                        <input type="text" name="ip_edit_size" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
                    </div>
                    <div class="mb-6">
                        <label for="ip_edit_quantity" class="block mb-2 text-sm font-medium text-gray-900 ">Số lượng</label>
                        <input name="ip_edit_quantity" type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="">
                    </div>
                    <div class="mb-2">
                        <span id="err_editOption" class="hidden mb-2 text-rose-500 sm:text-lg text-base ">Vui lòng điền đẩy đủ màu sắc, hình ảnh, size và số lượng!</span>
                    </div>
                    <div style="padding-top: 24px;" class="flex items-center justify-end space-x-2 border-t border-gray-200 gap-4 rounded-b dark:border-gray-600">
                        <button id="btn-close_edit_option" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 ">Hủy</button>
                        <button data-edit_option_id="" data-edit_option_value_id="" id="btn-edit_option" type="button" class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Lưu</button>
                    </div>
                </form>
                <!-- Modal footer -->
            </div>
        </div>
    </div>
</div>
<div id="modal_nofi" class="<?php echo isset($themSanPham) ? "" : "hidden" ?> relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen ">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button id="close_nofi" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <?php if (isset($themSanPham)) {
                        if ($themSanPham) { ?>
                            <svg class="mx-auto mb-4 text-green-500 bg-white  w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        <?php } else { ?>
                            <svg class="mx-auto mb-4 text-red-500 bg-white  w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                    <?php }
                    }
                    ?>

                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"><?php if (isset($themSanPham)) {
                                                                                                if ($themSanPham) {
                                                                                                    echo "Thêm sản phẩm thành công!";
                                                                                                } else {
                                                                                                    echo "Đã xảy ra lỗi, vui lòng thực hiện lại!";
                                                                                                }
                                                                                            } ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script>
    // firebase
    const firebaseConfig = {
        apiKey: "<?php echo FIREBASE_APIKEY ?>",
        authDomain: "<?php echo FIREBASE_AUTHDOMAIN ?>",
        projectId: "<?php echo FIREBASE_PROJECTID ?>",
        storageBucket: "<?php echo FIREBASE_storageBucket ?>",
        messagingSenderId: "<?php echo FIREBASE_messagingSenderId ?>",
        appId: "<?php echo FIREBASE_appId ?>",
        measurementId: "<?php echo FIREBASE_measurementId ?>"
    };

    const app = firebase.initializeApp(firebaseConfig);

    const storage = firebase.storage();
    let uploadedFileName;
    const uploadImage = (e) => {
        let file = e.target.files[0];
        let fileName = file.name + "-" + new Date();
        const storageRef = storage.ref().child("images");
        const folderRef = storageRef.child(fileName);
        const uploadtask = folderRef.put(file);
        const loading = document.querySelector("#img_loading");
        loading.classList.remove("hidden");
        uploadtask.on(
            "state_changed",
            (snapshot) => {
                console.log("Snapshot", snapshot.ref.name);
                uploadedFileName = snapshot.ref.name;

            },
            (error) => {
                console.log(error);
            },
            () => {
                storage
                    .ref("images")
                    .child(uploadedFileName)
                    .getDownloadURL()
                    .then((url) => {
                        loading.classList.add("hidden");
                        document.querySelector("#image").value = url;
                        const img = document.querySelector("#img_upload");
                        document.querySelector("#svg_upload").classList.add("hidden");
                        img.classList.remove("hidden");
                        img.src = url;
                        loader.classList.remove("active");
                    });
                console.log("File Uploaded Successfully");
            }
        );
    };


    const uploadImage1 = (e) => {
        let file = e.target.files[0];
        let fileName = file.name + "-" + new Date();
        const storageRef = storage.ref().child("images");
        const folderRef = storageRef.child(fileName);
        const uploadtask = folderRef.put(file);
        const loading = document.querySelector("#img_loading1");
        loading.classList.remove("hidden");
        uploadtask.on(
            "state_changed",
            (snapshot) => {
                console.log("Snapshot", snapshot.ref.name);
                uploadedFileName = snapshot.ref.name;

            },
            (error) => {
                console.log(error);
            },
            () => {
                storage
                    .ref("images")
                    .child(uploadedFileName)
                    .getDownloadURL()
                    .then((url) => {
                        loading.classList.add("hidden");
                        document.querySelector("#image1").value = url;
                        const img = document.querySelector("#img_upload1");
                        document.querySelector("#svg_upload1").classList.add("hidden");
                        img.classList.remove("hidden");
                        img.src = url;
                        loader.classList.remove("active");
                    });
            }
        );
    };
</script>
<script>
    document.querySelector("#close_nofi").addEventListener("click", () => {
        document.querySelector("#modal_nofi").classList.add("hidden");
    })
</script>
<script type="text/javascript" src="./js/productOption.js"></script>
<?php
include_once("./includes/footer.php")
?>