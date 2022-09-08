<?      
        // format number month to name TH
        function formatMonth($data){
            switch($data)
                {
                        case '1' : $data="มกราคม"; break;
                        case '2' : $data="กุมภาพันธ์"; break;
                        case '3' : $data="มีนาคม"; break;
                        case '4' : $data="เมษายน"; break;
                        case '5' : $data="พฤษภาคม"; break;
                        case '6' : $data="มิถุนายน"; break;
                        case '7' : $data="กรกฎาคม"; break;
                        case '8' : $data="สิงหาคม"; break;
                        case '9' : $data="กันยายน"; break;
                        case '10' : $data="ตุลาคม"; break;
                        case '11' : $data="พฤศจิกายน"; break;
                        case '12' : $data="ธันวาคม"; break;
                }
                return $data;
        }

        // format number 20xx to 25xx (TH)
        function formatYear($data){
                return $data+543;
        }

        function formatMoney($data){
                for($i=0;$i<strlen($data);$i++){
                        if($data[$i] == ","){
                                $data[$i] = "";
                        }
                        if($data[$i] == "."){
                                $data[$i] = "";
                                if($data[$i+1] != "0"){
                                    $data[$i+1] = $data[$i+1];
                                }else{
                                    $data[$i+1] = "";
                                }
                                $data[$i+2] = "";
                        break;
                        }
                }
                return $data;
        }
        function sumSarary($data){
                $sumSarary = "";
                $id_card  =$data['id_card'];
                $year = date('Y',strtotime($data['date_imp']));
                $month = date('m',strtotime($data['date_imp']));

                echo $id_card."<br>";
                echo $month."<br>".$year;
                $sql = "SELECT sarary FROM receipt_vat.details 
                WHERE id_card = $id_card AND YEAR('date_imp') = $year AND MONTH('date_imp') = $month";

                $result = $conn->query($sql);
                if($result->num_rows > 0){
                        echo "879879";
                }
                return $sumSarary;
        }
        function select($sql, $conn)
                {
                $result = array();
                $res = $conn->query($sql) or die("SQL Error: <br>" . $sql . "<br>" . $conn->error);
                while ($data = $res->fetch_assoc()) {
                        $result[] = $data;
                }
                return $result;
                }
define('DB_SERVER','192.168.66.1');
define('DB_USER','root');
define('DB_PASS','medadmin');
define('DB_NAME','_receipt_vat');

class DB_con{
    function __construct(){
        $conn = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
        $this->dbcon = $conn;
        mysqli_set_charset($this->dbcon,"utf8");
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: ".mysqli_connect_error();
        }
    }
    
    // COMPLETE ...
    public function fetch_data($sql){
        $fetch = mysqli_query($this->dbcon, $sql);
        return $fetch;
    }
    public function fetch_department(){
        $this->dbcon2 = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,'personal');
        mysqli_set_charset($this->dbcon2,"utf8");
        $fetch = mysqli_query($this->dbcon2,"SELECT SECTION_CODE , `DESCRIPTION` FROM appm_section WHERE USE_STATUS = '1'");
        mysqli_close($this->dbcon2);
        return $fetch;
    }
    public function search_by_idcard($ID_CARD){
        $this->dbcon2 = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,'personal');
        mysqli_set_charset($this->dbcon2,"utf8");
        $sql = "SELECT sec.`DESCRIPTION`,CONCAT(per.`TFNAME`,' ',per.`TLNAME`) AS FULLNAME FROM appm_personnel as per 
                        JOIN appm_section AS sec ON per.SECTION_CODE = sec.SECTION_CODE 
                            WHERE per.ID_CODE = '$ID_CARD' LIMIT 1";
        $search = mysqli_query($this->dbcon2,$sql);
        mysqli_close($this->dbcon2);
        return $search;
    }
    public function delete($id,$table){
        $sql = ("DELETE FROM $table WHERE id = '$id'");
        if(mysqli_query($this->dbcon, $sql)){
            return '1';
        }else{
            return '0';
        }
    }
    public function search($table , $where){
        $sql = "SELECT * FROM $table WHERE $where";
        $search = mysqli_query($this->dbcon, $sql);
        return $search;
    }
    public function search_fullnameBymedcode($medcode){
        $this->dbcon2 = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,'personal');
        $sql = "SELECT CONCAT(TFNAME,' ',TLNAME) FROM appm_personnel WHERE USERNAME = '$medcode' AND ID_CODE != '' LIMIT 1";
        $search = mysqli_query($this->dbcon2, $sql);
        mysqli_close($this->dbcon2);
        return $search;
    }
    public function search_idcard($sql){
        $this->dbcon2 = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,'personal');
        mysqli_set_charset($this->dbcon2,"utf8");
        $search = mysqli_query($this->dbcon2,$sql);
        mysqli_close($this->dbcon2);
        return $search;
    }
    public function search_fullnameByreq($name){
        $this->dbcon2 = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,'personal');
        mysqli_set_charset($this->dbcon2,"utf8");
        $sql = "SELECT CONCAT(TFNAME,' ',TLNAME) AS FULLNAME FROM appm_personnel WHERE 
            (TFNAME LIKE '$name%' OR
                TLNAME LIKE '$name%' OR
                    TFNAME LIKE '%$name%' OR
                        TLNAME LIKE '%$name%') 
                                AND ID_CODE != ''";
        $search = mysqli_query($this->dbcon2, $sql);
        mysqli_close($this->dbcon2);
        return $search;
    }
}
        
?>