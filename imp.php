<?
include "./config/connect.php";
$myImp = array();
$myCheck = array();

// $sql = "UPDATE active_menu
// SET active_write = '0' WHERE active_authorise_id != '3130700229519' AND active_mhd_id = '195'";
// $conn3->query($sql);

// $sql = "SELECT active_authorise_id FROM active_menu WHERE active_mhd_id = '195'";
// $result = $conn3->query($sql);
// echo $result->num_rows ."<br>";
// if($result->num_rows >0){
//     $j = 0;
//     while($row = $result->fetch_assoc()){
//         $myCheck[$j] = $row['active_authorise_id'];
//         $j++;
//     }
// }

// $sql = "SELECT ID_CODE FROM appm_personnel WHERE EMP_STATUS = '1' AND ID_CODE != ''";
// $result = $conn2->query($sql);
// echo $result->num_rows ."<br>";
// if($result->num_rows >0){
//     $j = 0;
//     while($row = $result->fetch_assoc()){
//         $isErr = false;
//         for($i = 0 ; $i < count($myCheck) ;$i++){
//             if($row['ID_CODE'] == $myCheck[$i]){
//                 $isErr = true;
//                 $j -= 1;
//             }
//         }
//         if($isErr != true){
//             $myImp[$j] = $row['ID_CODE'];
//         }
//         $j++;
//     }
// }
// echo "<pre>";
// print_r($myImp);
// echo "</pre>";
// for($i = 0 ; $i < count($myImp) ; $i++){
//     $data = $myImp[$i];
//     if($data != '3130700229519' && $data != '1103000076902' && $data != '3100600175212' && $data != '3130100331452'){
//         $sql = "INSERT INTO active_menu (active_authorise_id,active_mhd_id,active_report,active_write) VALUE ('$data','197','1','0')";
//         $conn3->query($sql); 
//     }
// }



// print_r($myImp);

?>