<? 
        // DB receipt_vat
        require_once "userPassDb.php";
        $conn = new mysqli($hostDb, $userDb, $passDb, $nameDb); mysqli_set_charset($conn,"utf8");
        if($conn->connect_error) {
                // echo "<script> console.log('Cannot connect DB') </script>";
        } else {
        // echo "<script> console.log('db Connect') </script>" ;
        }


        // DB personal
        $conn2 = new mysqli($hostDb, $userDb, $passDb, $nameDb2); mysqli_set_charset($conn2,"utf8");
        if($conn2->connect_error) {
                // echo "<script> console.log('Cannot connect DB') </script>";
        } else {
        // echo "<script> console.log('db2 Connect') </script>" ;
        }

         // DB personal
        $conn3 = new mysqli($hostDb, $userDb, $passDb, $nameDb3); mysqli_set_charset($conn3,"utf8");
        if($conn3->connect_error) {
                // echo "<script> console.log('Cannot connect DB') </script>";
        } else {
        // echo "<script> console.log('db2 Connect') </script>" ;
        }



?>