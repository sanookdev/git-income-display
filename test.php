<?
    $db_server = "192.168.66.1";
	$db_user = "root";
	$db_pwd = "medadmin";
	$db_name = "personal";

	$conn = new mysqli($db_server, $db_user, $db_pwd, $db_name);
	$conn->query("set char set utf8");

	$qryChk = "SELECT 
										* 
										, (SELECT DESCRIPTION FROM appm_section WHERE SECTION_CODE = appm_personnel.SECTION_CODE ) AS secName
									FROM 
											appm_personnel 
									WHERE 
											 ID_CODE != ''";
	$rsChk = $conn->query($qryChk) or die($conn->error);

	$arr = array();

	while ($data = $rsChk->fetch_object()) {

		$arrTmp = array('medCODE' => $data->USERNAME, 'stdFname' => $data->TFNAME, 'stdLname' => $data->TLNAME, 'secName' => $data->secName, 'eMail' => $data->EMAIL);

		$arr[strtoupper($data->USERNAME)] = $arrTmp;
	}


    // ******************************** NEWS *************************
    $hostDb = "192.168.66.1";
    $userDb = "root";
    $passDb = "medadmin";
    $nameDb0 = "other_personal";
    $nameDb = "other_menu_handle";
    $nameDb2 = "personal";

    $id_card = array();

    $arr_news = array();
    //other_personal
    $conn = new mysqli($hostDb, $userDb, $passDb, $nameDb0); mysqli_set_charset($conn,"utf8"); if($conn->connect_error) {alert('connect db error');}


    $sql = "SELECT ID_CODE,TFNAME,TLNAME  FROM appm_personnel WHERE EMP_STATUS = '1'";

    $result = $conn->query($sql);
    
    while($row = $result->fetch_assoc()){

        $id_card[] = $row['ID_CODE'];
        
    }

    //other_menu_handle
    $conn = new mysqli($hostDb, $userDb, $passDb, $nameDb); mysqli_set_charset($conn,"utf8"); if($conn->connect_error) {alert('connect db error');}
    for($i = 0 ; $i < count($id_card) ; $i++){

        $id = $id_card[$i];

        $sql = "SELECT * FROM authorise 
                            WHERE authorise_idcard = '$id' AND authorise_idcard != '' AND medcode != ''";

        $result = $conn->query($sql);

        while($data = $result->fetch_object()){
            $arrTmp = array('medCODE' => strtoupper($data->medcode), 'stdFname'=>$data->TFNAME,'stdLname' => $data->TLNAME , 'secName' =>$data->secName,'eMail' => $data->EMAIL );
			$arr_news[strtoupper($id)] = $arrTmp;
        }
    }

    //other_personal__ DB
    $conn = new mysqli($hostDb, $userDb, $passDb, $nameDb0); mysqli_set_charset($conn,"utf8"); if($conn->connect_error) {alert('connect db error');}
    foreach ($arr_news as $k => $v){
        $sql = "SELECT * FROM appm_personnel WHERE ID_CODE = '$k'";
        $result = $conn->query($sql);
        
        while($data = $result->fetch_object()){
            $arr_news[$k]['stdFname'] = $data->TFNAME;
            $arr_news[$k]['stdLname'] = $data->TLNAME;
            $arr_news[$k]['eMail'] = $data->EMAIL;
        }
    }

    
    //personal__ DB
    $conn = new mysqli($hostDb, $userDb, $passDb, $nameDb2); mysqli_set_charset($conn,"utf8"); if($conn->connect_error) {alert('connect db error');}
    
    $chk = 0;
    foreach ($arr_news as $k => $v) {

        // UPDATE medCODE
        $sql = "SELECT * FROM appm_personnel WHERE ID_CODE = '$k'";
        $result = $conn->query($sql);

        while($data = $result->fetch_object()){
            $arr_news[$k]['medCODE'] = $data->USERNAME;
        }



        // UPDATE secName
        $substr = strtoupper(substr($arr_news[$k]['medCODE'],1,2));
        $sql = "SELECT * FROM appm_section AS a WHERE section_ID = '$substr'";

        $result = $conn->query($sql);

        while($data = $result->fetch_object()){
            $arr_news[$k]['secName'] = $data->DESCRIPTION;
            $arr_news[$arr_news[$k]['medCODE']] = $arr_news[$k];
            unset($arr_news[$k]); // UPDATE news ARRAY and DELETE old ARRAY
        }
    }


    $chk = array();
    // ลบ USER ที่เป็นตัวเลขล้วน และอัพเดต arr 
    foreach ($arr_news as $k => $v) {
		if(strlen($k) != 7){
            unset($arr_news[$k]);
        }else{
            $chk[] = $k;
        }
    }
    foreach ($arr as $k => $v) {
		if(isset($arr_news[$k])){
            unset($arr_news[$k]);
        }
    }
    foreach ($arr_news as $k => $v) {
		$arr[] = $arr_news[$k];
    }


    // ******************************** NEWS ( END ) *************************
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?
    // foreach ($arr as $k => $v) {
	// 	if ($arr[$k]['medCODE'] != $k) {
	// 		unset($arr[$k]);
	// 	}
	// }
    echo count($arr).": arr<br>".count($arr_news).": arr_news<br>";
    echo "<pre>";
    print_r($arr_news);
    echo "</pre>";
?>

</body>

</html>