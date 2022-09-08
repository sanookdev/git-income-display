<?
if (isset($_POST["Import"])) {
    $connect = mysqli_connect("192.168.66.1", "root", "medadmin", "_receipt_vat");
    mysqli_set_charset($connect, "utf8");
    $extension = end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
    $allowed_extension = array("xlsx", "csv"); //allowed extension
    if (in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
    {
        $data_arr = array();
        $msg_status = false;
        $id_upload_type = $_POST['upload_type'];
        $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
        include("PHPExcel/Classes/PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
        $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $i = 0;
            for ($row = 2; $row <= $highestRow; $row++) {
                $j = 0;
                if($id_upload_type == '1'){
                    if(mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue()) != ''){
                        $date_imp = date('Y-m-d');
                        $data_arr[$i] = array(
                            'date_imp' => $date_imp,
                            'id_card' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue()),
                            'sarary' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue()),
                            'col' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue()),
                            'sumPlus' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue()),
                            'vat' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue()),
                            'social_secure' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue()),
                            'provident_fund' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(9, $row)->getValue()),
                            'sloan_fund' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(10, $row)->getValue()),
                            'cooperative' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(11, $row)->getValue()),
                            'net' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(12, $row)->getValue()),
                            'acc_num' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(13, $row)->getValue()),
                            'name_bank' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(14, $row)->getValue()),
                            'department' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(15, $row)->getValue()),
                        );
                        $cell = $worksheet->getCell('Q' . $row);
                        $date_Pay = $cell->getValue();
                        $date_Pay = PHPExcel_Shared_Date::ExcelToPHPObject($date_Pay)->format('Y-m-d');
                        $modify = explode('-', $date_Pay);
                        $modify[0] = $modify[0] - 543;
                        $date_Pay = $modify[0] . "-" . $modify[1] . "-" . $modify[2];
                        $data_arr[$i]['date_Pay'] = $date_Pay;
                        $data_arr[$i]['acc_num'] = trim($data_arr[$i]['acc_num']);
                        $i++;  
                    }
                }else{
                    if(mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+3, $row)->getValue()) != ''){
                        $date_imp = date('Y-m-d');
                        $cell = $worksheet->getCell('J' . $row);
                        $date_Pay = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+10, $row)->getValue());
                        $date_Pay = $cell->getValue();
                        $date_Pay = PHPExcel_Shared_Date::ExcelToPHPObject($date_Pay)->format('Y-m-d');
                        $modify = explode('-', $date_Pay);
                        $modify[0] = $modify[0] - 543;
                        $date_Pay = $modify[0] . "-" . $modify[1] . "-" . $modify[2];
                        $data_arr[$i] = array(
                            'id_upload_type' => $id_upload_type,
                            'fullname' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+1, $row)->getValue()),
                            'position' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+2, $row)->getValue()),
                            'id_card' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+3, $row)->getValue()),
                            'amount' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+4, $row)->getValue()),
                            'vat' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+5, $row)->getValue()),
                            'total' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+6, $row)->getValue()),
                            'name_bank' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+7, $row)->getValue()),
                            'acc_num' => mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($j+8, $row)->getValue()),
                            'pay_date' => $date_Pay,
                        );
                        $i++;
                    }
                    
                }
            }
        }
        // $query = "";
        
        // OTHER RECEIPT 
        if((isset($data_arr) && count($data_arr) > 0) && (isset($id_upload_type) && $id_upload_type != '1')){
            $query = "";
            for($i = 0 ; $i < count($data_arr) ; $i++){
                $MED_UPLOAD = $_SESSION['_IDCARD'];
                if($i != 0){
                    $query .= ",(";
                }else{
                    $query = "INSERT INTO receipt_other(id_upload_type,fullname,position,ID_CARD,amount,vat,total,
                    name_bank,acc_num,pay_date,MED_UPLOAD) VALUES " ;
                    $query .= "(";
                }  
                $query .= @"'".$data_arr[$i]['id_upload_type']."',";
                $query .= @"'".$data_arr[$i]['fullname']."',";
                $query .= @"'".$data_arr[$i]['position']."',";
                $query .= @"'".$data_arr[$i]['id_card']."',";
                $query .= @"'".$data_arr[$i]['amount']."',";
                $query .= @"'".$data_arr[$i]['vat']."',";
                $query .= @"'".$data_arr[$i]['total']."',";
                $query .= @"'".$data_arr[$i]['name_bank']."',";
                $query .= @"'".$data_arr[$i]['acc_num']."',";
                $query .= @"'".$data_arr[$i]['pay_date']."',";
                $query .= @"'".$MED_UPLOAD."'";
                $query .= @')';
            }
            if($query != ""){
                $query .= ";";
            }
            // echo $query;
            if(mysqli_query($connect, $query)){
                echo "<script>window.location.reload()</script>";
            }
        }else if ((isset($data_arr) && count($data_arr) > 0) && (isset($id_upload_type) && $id_upload_type == '1')){
            for($i = 0 ; $i < count($data_arr) ; $i++){
                $MED_UPLOAD = $_SESSION['_IDCARD'];
                $query = "INSERT into sarary(date_imp,id_card,sarary,col,sumPlus,vat,social_secure,provident_fund,
                sloan_fund,cooperative,net,acc_num,name_bank,date_Pay,MED_UPLOAD) 
                VALUES (";
                $query .= "'".$data_arr[$i]['date_imp']."',";
                $query .= "'".$data_arr[$i]['id_card']."',";
                $query .= "'".$data_arr[$i]['sarary']."',";
                $query .= "'".$data_arr[$i]['col']."',";
                $query .= "'".$data_arr[$i]['sumPlus']."',";
                $query .= "'".$data_arr[$i]['vat']."',";
                $query .= "'".$data_arr[$i]['social_secure']."',";
                $query .= "'".$data_arr[$i]['provident_fund']."',";
                $query .= "'".$data_arr[$i]['sloan_fund']."',";
                $query .= "'".$data_arr[$i]['cooperative']."',";
                $query .= "'".$data_arr[$i]['net']."',";
                $query .= "'".$data_arr[$i]['acc_num']."',";
                $query .= "'".$data_arr[$i]['name_bank']."',";
                $query .= "'".$data_arr[$i]['date_Pay']."',";
                $query .= "'".$MED_UPLOAD."'";
                $query .= ')';
                if($data_arr[$i]['id_card'] != ""){
                    mysqli_query($connect, $query);
                }
            }
        }
    } else {
        echo "<script>alert('รูปแบบไฟล์ไม่ถูกต้อง  *** ไฟล์ต้องเป็น (.xlxs) หรือ (.csv) เท่านั้น กรุณา โหลดไฟล์ตัวอย่าง')</script>";
    }
}
?>