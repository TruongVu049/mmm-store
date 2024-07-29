<?php
include "./helpers/view.php";
ob_start();
view('header', ['title' => 'Liên hệ']);
?>

<div>
    <div class="isolate bg-white md:px-6 px-1 md:py-24 py-8 sm:py-32 lg:px-8">
        <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]" aria-hidden="true">
            <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%);"></div>
        </div>
        <div class="container mx-auto px-4 md:flex justify-center lg:gap-40 md:gap-12  ">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Gửi Phản Hồi</h2>
                <form action="send-email.php" method="post" class="md:min-w-96 mt-8 sm:mt-10 shadow-xl p-4 bg-white">
                    <div>
                        <label class="mt-5 font-semibold">Họ và Tên
                            <input type="text" name="tenkhachhang" class="w-full mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Tên Khách Hàng" required />
                        </label><br>
                    </div>
                    <div>
                        <label class="mt-5  font-semibold">Email
                            <input type="text" name="email" class="w-full mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Email" required />
                        </label><br>
                    </div>
                    <div>
                        <label class="mt-5  font-semibold">Số điện thoại
                            <input type="text" name="sdt" class="w-full mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Số điện thoại" required />
                        </label><br>
                    </div>
                    <div>
                        <label class="mt-5   font-semibold">Ý Kiến
                            <textarea id="message" name="content" rows="4" class="block p-2.5 w-full text-sm 
                            text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 
                            focus:border-blue-500 
                            " placeholder="">
                        </textarea>
                        </label><br>

                    </div>
                    <input type="submit" name="submit" value="Gửi" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mb-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                </form>
            </div>
            <div class="md:mt-0 mt-14">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Thông Tin Liên Lạc</h2>
                <div class=" mt-8 max-w-xl sm:mt-10 shadow-xl p-4">
                    <div class="flex items-center gap-5 mb-4"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" class="text-2xl" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <h5 class="font-semibold">Địa chỉ</h5><span>"51/20 Lê Trọng Tấn"</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-5 mb-4"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" class="text-2xl" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M877.1 238.7L770.6 132.3c-13-13-30.4-20.3-48.8-20.3s-35.8 7.2-48.8 20.3L558.3 246.8c-13 13-20.3 30.5-20.3 48.9 0 18.5 7.2 35.8 20.3 48.9l89.6 89.7a405.46 405.46 0 0 1-86.4 127.3c-36.7 36.9-79.6 66-127.2 86.6l-89.6-89.7c-13-13-30.4-20.3-48.8-20.3a68.2 68.2 0 0 0-48.8 20.3L132.3 673c-13 13-20.3 30.5-20.3 48.9 0 18.5 7.2 35.8 20.3 48.9l106.4 106.4c22.2 22.2 52.8 34.9 84.2 34.9 6.5 0 12.8-.5 19.2-1.6 132.4-21.8 263.8-92.3 369.9-198.3C818 606 888.4 474.6 910.4 342.1c6.3-37.6-6.3-76.3-33.3-103.4zm-37.6 91.5c-19.5 117.9-82.9 235.5-178.4 331s-213 158.9-330.9 178.4c-14.8 2.5-30-2.5-40.8-13.2L184.9 721.9 295.7 611l119.8 120 .9.9 21.6-8a481.29 481.29 0 0 0 285.7-285.8l8-21.6-120.8-120.7 110.8-110.9 104.5 104.5c10.8 10.8 15.8 26 13.3 40.8z"></path>
                        </svg>
                        <div>
                            <h5 class="font-semibold">SĐT</h5><span>"SĐT: 0774429227"</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-5 mb-4"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" class="text-2xl" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M928 160H96c-17.7 0-32 14.3-32 32v640c0 17.7 14.3 32 32 32h832c17.7 0 32-14.3 32-32V192c0-17.7-14.3-32-32-32zm-40 110.8V792H136V270.8l-27.6-21.5 39.3-50.5 42.8 33.3h643.1l42.8-33.3 39.3 50.5-27.7 21.5zM833.6 232L512 482 190.4 232l-42.8-33.3-39.3 50.5 27.6 21.5 341.6 265.6a55.99 55.99 0 0 0 68.7 0L888 270.8l27.6-21.5-39.3-50.5-42.7 33.2z"></path>
                        </svg>
                        <div>
                            <h5 class="font-semibold">Liên Hệ Qua Email</h5><span>truongvu@gmail.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="google-map-area w-100"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62712.548892307255!2d106.62261175853781!3d10.77032870322712!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f2bb9fdd5c5%3A0x5dffe6586647193b!2sFelix%20luxury!5e0!3m2!1svi!2s!4v1682176756370!5m2!1svi!2s" width="100%" height="450" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="border: 0px;"></iframe></div>
    </div>
</div>

<?php
include_once("./includes/footer.php")
?>
ob_end_flush();