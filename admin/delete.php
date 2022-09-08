<?
    // require_once "../config/connect.php";
    require_once "function.php";
    $id=$_POST['id'];
    $topic = $_POST['topic'];
    $delete = new DB_con();
    if($delete->delete($id,$topic)){
        echo "1";
    }else{
        echo "0";
    }
    
    
?>