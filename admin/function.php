<?php
define('DB_SERVER','192.168.66.1');
define('DB_USER','root');
define('DB_PASS','medadmin');
define('DB_NAME','_receipt_vat');
// format number month to name TH
function formatMonth($data)
{
    switch ($data) {
        case '01':
            $data = "ม.ค.";
            break;
        case '02':
            $data = "ก.พ.";
            break;
        case '03':
            $data = "มี.ค.";
            break;
        case '04':
            $data = "เม.ย.";
            break;
        case '05':
            $data = "พ.ค.";
            break;
        case '06':
            $data = "มิ.ย.";
            break;
        case '07':
            $data = "ก.ค.";
            break;
        case '08':
            $data = "ส.ค.";
            break;
        case '09':
            $data = "ก.ย.";
            break;
        case '10':
            $data = "ต.ค.";
            break;
        case '11':
            $data = "พ.ย.";
            break;
        case '12':
            $data = "ธ.ค.";
            break;
    }
    return $data;
}

// format number 20xx to 25xx (TH)
function formatYear($data)
{
    return $data + 543;
}

function update($table, $data, $where, $conn)
{
    $modifs = "";
    $i = 1;
    foreach ($data as $key => $val) {
        if ($i != 1) {
            $modifs .= ", ";
        }
        if (is_numeric($val)) {
            $modifs .= $key . '=' . $val;
        } else {
            $modifs .= $key . ' = "' . $val . '"';
        }
        $i++;
    }
    $sql = ("UPDATE $table SET $modifs WHERE $where");
    if ($conn->query($sql)) {
        return true;
    } else {
        die("SQL Error: <br>" . $sql . "<br>" . $conn->error);
        return false;
    }
}

function delete($table, $where)
{
    global $con;
    $sql = "DELETE FROM $table WHERE $where";
    if ($con->query($sql)) {
        return true;
    } else {
        die("SQL Error: <br>" . $sql . "<br>" . $con->error);
        return false;
    }
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

function insert($table, $data, $conn)
{
    $fields = "";
    $values = "";
    $i = 1;
    foreach ($data as $key => $val) {
        if ($i != 1) {
            $fields .= ", ";
            $values .= ", ";
        }
        $fields .= "$key";
        $values .= "'$val'";
        $i++;
    }
    $sql = "INSERT INTO $table ($fields) VALUES ($values)";
    return $sql;
    // if ($conn->query($sql)) {
    //     return true;
    // } else {
    //     die("SQL Error: <br>" . $sql . "<br>" . $conn->error);
    //     return false;
    // }
}

function search($department, $sql)
{
    // processing....
    require_once "../config/connect.php";
    $data = array();
    echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $data[$i] = $row[$i];
            echo $row[$i];
            $i++;
        }
    }
    return $department;
}
function stringInsert($str, $insertstr, $pos)
{
    $count_str = strlen($str);
    for ($i = 0; $i < $pos; $i++) {
        $new_str .= $str[$i];
    }

    $new_str .= "$insertstr";

    for ($i = $pos; $i < $count_str; $i++) {
        $new_str .= $str[$i];
    }

    return $new_str;
}

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
    public function deleteAll($sql){
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
    public function search_fullnameByIdcard($idcard){
        $this->dbcon2 = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,'personal');
        mysqli_set_charset($this->dbcon2,"utf8");
        $sql = "SELECT CONCAT(per.TFNAME,' ',per.TLNAME) AS FULLNAME , pre.PREFIX_SHORTNAME AS prefix FROM appm_personnel AS per 
                    JOIN appm_prefix AS pre ON per.PREFIX_NAME = pre.PREFIX_CODE WHERE per.ID_CODE = '$idcard' AND per.EMP_STATUS = '1' LIMIT 1";
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
    public function insert($value,$table){
        $val_text = "";
        for($i = 0 ; $i < count($value) ; $i++){
            $val_text .= $value[$i];
            if($i < count($value)-1){
                $val_text .= ",";
            }
        }
        $sql = "INSERT 
                        INTO $table
                            VALUE ($val_text)";
        $insert = mysqli_query($this->dbcon,$sql);
        return $insert;
    }
    public function insert_excel($sql){
        $insert = mysqli_query($this->dbcon,$sql);
        return $insert;
    }
    // COMPLETE ( END ) ...


    
    // สมัครสมาชิก หรือลงทะเบียน
    public function registration($fname , $uname , $uemail , $password){
        $reg = mysqli_query($this->dbcon,"INSERT INTO tb_user(fullname,username,email,password)
        VALUE ('$fname','$uname','$uemail','$password')");
        return $reg;
    }
    // เช็ค user ซ้ำใน base
    public function username_check($uname){
        $checkuser = mysqli_query($this->dbcon,"SELECT username FROM tb_user WHERE username = '$uname'");
        return $checkuser;      
    }
    // เช็ค login
    public function signin($uname , $password){
        $signin = mysqli_query($this->dbcon, "SELECT * FROM tb_user WHERE username = '$uname' AND password = '$password'");
        return $signin;
    }

    public function select($training_num){
        $select = mysqli_query($this->dbcon, "SELECT * FROM training_all WHERE ID = '$training_num' LIMIT 1");
        return $select;
    }

    public function update($table,$data,$where){
        $modifs="";
        $i=1;
        foreach($data as $key=>$val){
            if($i!=1){ $modifs.=", "; }
            if(is_numeric($val)) { $modifs.=$key.'='.$val; }
            else { $modifs.=$key.' = "'.$val.'"'; }
            $i++;
        }
        $sql = ("UPDATE $table SET $modifs WHERE $where");
        if($this->dbcon->query($sql)) { return true; }
        else { die("SQL Error: <br>".$sql."<br>".$this->dbcon->error); return false; }
    }
}