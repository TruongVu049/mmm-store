<?php
ob_start();
include_once("./includes/header.php");
require_once("../classes/Database.php");

$db = new Database();

if(isset($_POST['themdanhmuc'])){
    $tendm = $_POST['tendanhmuc'];
    if(isset($tendm)){
        $sql = "ALTER TABLE danhmuc AUTO_INCREMENT=1; INSERT INTO danhmuc(ten) VALUES (:ten)";
        try{

            $statement = $db->conn->prepare($sql);
    
            $data = [
                'ten' => $tendm
            ];
        
            $insertStatus = $statement->execute($data);

            header('Location: danhmuc.php');


        }catch(Exception $exception){
            
        }
        
    }
    
}

?>
<main class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-semibold mb-2">Thêm danh mục</h1>
        </div>
    </div>

    <div>
        <form action="themdanhmuc.php" method="post" class="bg-white">
            <div class="grid gap-2 mb-6 md:grid-cols-2">
                <label class="mt-5 ml-4  font-semibold">Tên danh mục</label><br>

                <input type="text" name="tendanhmuc" class=" mt-1 ml-6 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tên danh mục" required />
            </div>

            <input type="submit" name="themdanhmuc" value="Thêm danh mục" class="ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 mb-5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">



        </form>
    </div>


</main>
<script>
</script>

<?php
include_once("./includes/footer.php");
ob_end_flush();

?>