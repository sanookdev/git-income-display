<?  
session_start();
error_reporting(0);
$name = iconv("windows-874","UTF-8",$_SESSION['userLOG']['Fname']);

if(isset($_SESSION['report'])){
    echo "<script>window.location = 'report.php'</script>";
}else{
    echo "<script> window.location = '../'</script>" ;
}


?>