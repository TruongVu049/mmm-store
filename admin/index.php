<?php
include_once("./includes/header.php");
include_once("../classes/Database.php");
$db = new Database();
$dataBD = $db->selectNonParam("select MONTH(ngaysua) as thang, sum(tongtien) as tongtien
	from donhang 
	where YEAR(CURDATE()) = year(ngaysua) and donhang.TrangThaiDonHang_id = 3
	group by MONTH(ngaysua) 
	order by thang");

// Số lượng sản phẩm
$sql_products = "SELECT COUNT(*) FROM sanpham";
$statement_products = $db->conn->query($sql_products);
$count_products = $statement_products->fetchColumn();

// Số lượng khách hàng
$sql_customers = "SELECT COUNT(*) FROM khachhang";
$statement_customers = $db->conn->query($sql_customers);
$count_customers = $statement_customers->fetchColumn();

// Số lượng đơn hàng
$sql_orders = "SELECT COUNT(*) FROM donhang";
$statement_orders = $db->conn->query($sql_orders);
$count_orders = $statement_orders->fetchColumn();

// Truy vấn SQL để tính tổng số tiền của mỗi hóa đơn
$sql_total_all_orders = "SELECT SUM(tongtien)  FROM donhang where donhang.TrangThaiDonHang_id = 3";
$statement_total_all_orders = $db->conn->query($sql_total_all_orders);
$total_all_orders = $statement_total_all_orders->fetchColumn();
if ($total_all_orders === null) {
    $total_all_orders = 0;
}

$dsKhachHang = $db->selectNonParam("
select khachhang.id, khachhang.ten, sum(donhang.tongtien) as tongtien
from khachhang
INNER join donhang on donhang.KhachHang_id = khachhang.id
where donhang.TrangThaiDonHang_id = 3
group by khachhang.id, khachhang.ten
");

?>

<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Tổng Quan</h1>
        </div>

    </div>
    <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="flex items-center p-8 bg-white shadow rounded-lg">
            <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-purple-600 bg-purple-100 rounded-full mr-6">
                <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold"><?php echo $count_customers ?? "1" ?></span>
                <span class="block text-gray-500">Khách hàng</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-white shadow rounded-lg">
            <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-blue-600 bg-blue-100 rounded-full mr-6">
                <svg class="w-6 h-6 text-blue-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                    <path d="M10.013 4.175 5.006 7.369l5.007 3.194-5.007 3.193L0 10.545l5.006-3.193L0 4.175 5.006.981l5.007 3.194ZM4.981 15.806l5.006-3.193 5.006 3.193L9.987 19l-5.006-3.194Z" />
                    <path d="m10.013 10.545 5.006-3.194-5.006-3.176 4.98-3.194L20 4.175l-5.007 3.194L20 10.562l-5.007 3.194-4.98-3.211Z" />
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold"><?php echo $count_products ?? "1" ?></span>
                <span class="block text-gray-500">Sản phẩm</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-white shadow rounded-lg">
            <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-green-600 bg-green-100 rounded-full mr-6">

                <svg class="w-6 h-6 text-green-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 15a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0h8m-8 0-1-4m9 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-9-4h10l2-7H3m2 7L3 4m0 0-.792-3H1" />
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold"><?php echo $count_orders ?? "1" ?></span>
                <span class="block text-gray-500">Đơn hàng</span>
            </div>
        </div>
        <div class="flex items-center p-8 bg-white shadow rounded-lg">
            <div class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-red-600 bg-teal-100 rounded-full mr-6">
                <svg class="w-6 h-6 text-teal-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 12v5m5-9v9m5-5v5m5-9v9M1 7l5-6 5 6 5-6" />
                </svg>
            </div>
            <div>
                <span class="inline-block text-2xl font-bold">đ <?php echo number_format($total_all_orders, 0, ',', '.') ?? '0' ?></span>
                <span class="block text-gray-500">Tổng tiền hàng</span>
            </div>
        </div>

    </section>
    <section class="xl:grid xl:grid-cols-4  gap-6">
        <div class="xl:col-span-3 flex flex-col bg-white shadow rounded-lg">
            <div class="px-6 py-5 font-semibold border-b border-gray-100">Doanh thu năm 2024</div>
            <div class="p-4 flex-grow">
                <div class="phppot-container ">
                    <div class="w-full md:h-[70vh] sm:h-[60vh] h-[50vh]">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="xl:col-span-1 xl:mt-0 mt-6 bg-white shadow rounded-lg">
            <div class="flex items-center justify-between px-6 py-5 font-semibold border-b border-gray-100">
                <span>Xếp hạng khách hàng</span>
            </div>
            <div class="overflow-y-auto" style="max-height: 24rem;">
                <ul class="p-6 space-y-6">
                    <?php if(isset($dsKhachHang)): ?>
                        
                        <?php foreach($dsKhachHang as $kh): ?>
                            <li data-user-id="<?php echo $kh['id'] ?? ""?>" class="flex items-center">
                                <div class="h-10 w-10 mr-3 bg-gray-100 rounded-full overflow-hidden">
                                    <svg class="h-full w-full object-cover text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 11 14H9a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 10 19Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                                <span class="text-gray-600"><?php echo $kh['ten'] ?? ""?></span>
                                <span class="ml-auto font-semibold">đ <?php echo number_format($kh['tongtien'], 0, ',', '.') ?? '0' ?></span>
                            </li> 
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
        </div>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>
<script>
    <?php


    // @foreach(var item in ViewBag.order) {

    //     <
    //     text >
    //         dataChart.push({
    //             month: @(item.Month),
    //             total: @(item.Total),
    //         }) <
    //         /text>
    // };
    $dataBD = json_encode($dataBD);
    echo "const dataChart = $dataBD";
    ?>

    let myChart;
    const arrMonth = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];
    const backgroundColor = [
        'rgba(255, 99, 132, 0.5)',
        'rgba(255, 159, 64, 0.5)',
        'rgba(255, 205, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(201, 203, 207, 0.5)',
        'rgba(201, 203, 188, 0.5)',
        'rgba(201, 103, 188, 0.5)',
        'rgba(261, 230, 188, 0.5)',
        'rgba(241, 230, 158, 0.5)',
        'rgba(121, 170, 128, 0.5)',
    ]
    const borderColor = [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)',
        'rgba(201, 203, 188)',
        'rgba(201, 103, 188)',
        'rgba(261, 230, 188)',
        'rgba(241, 230, 158)',
        'rgba(121, 170, 128)',
    ]

    const _data = dataChart.slice();
    myChart = new Chart(document.getElementById("line-chart"), {
        type: "bar",
        data: {
            labels: dataChart.map(item => {
                return arrMonth[item.thang - 1];
            }),
            datasets: [{
                label: 'Tổng doanh thu',
                data: _data.map(item => item.tongtien),
                backgroundColor: backgroundColor.splice(0, dataChart.length),
                borderColor: borderColor.splice(0, dataChart.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: "Chart GA",
            },
        },
    });
</script>
<?php
include_once("./includes/footer.php")
?>