<?
    session_start();
    if($_SESSION['user'] == ""){
        echo "<script>window.location = '../../'</script>";
    } else {
        $id_card = $_SESSION['_IDCARD'];
        require_once "config/userPassDb.php";
        $conn2 = new mysqli($hostDb, $userDb, $passDb, 'menu_handle'); mysqli_set_charset($conn2,"utf8");
            if($conn2->connect_error) {
                    // echo "<script> console.log('Cannot connect DB') </script>";
            } else {
            // echo "<script> console.log('db2 Connect') </script>" ;
            }
        $sql = "SELECT * FROM menu_handle.active_menu WHERE active_authorise_id = '$id_card' AND active_mhd_id = '197' LIMIT 1";
        $result = $conn2->query($sql);
        if($result->num_rows >0){
            while($row = $result->fetch_assoc()){
                // echo $row['active_write']. " " . $row['active_report']. "<br>";
                $_SESSION['report'] = $row['active_report'];
                $_SESSION['write'] = $row['active_write'];
            }
        }else if($_SESSION['_LOGIN'] == 'admin'){
            $_SESSION['report'] = 1;
            $_SESSION['write'] = 1;
        }

         $conn = new mysqli($hostDb, $userDb, $passDb, $nameDb2); mysqli_set_charset($conn,"utf8");
            if($conn->connect_error) {
                    echo "<script> console.log('Cannot connect DB') </script>";
            } else {
            echo "<script> console.log('db2 Connect') </script>" ;
            }
            $sql = "SELECT * FROM personal.appm_personnel WHERE ID_CODE = '$id_card'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['P_ACCT'] = $row['P_ACCT'];
                }
            }

            $P_ACCT = $_SESSION['P_ACCT'];
            $sql = "SELECT * FROM personal.appm_position_record WHERE P_ACCT = '$P_ACCT'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $_SESSION['SECTION_CODE'] = $row['SECTION_CODE'];
                }
            }


        if($_SESSION['write'] == 1){
            echo "<script>window.location = 'admin'</script>";
        }else if($_SESSION['report'] == 1){
            echo "<script>window.location = 'user'</script>" ;
        }else{
            echo "<script>window.location = '../../'</script>";
        }
        print_r($_SESSION);
    }
    ?>