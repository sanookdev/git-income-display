<?  
session_start();
error_reporting(0);
$name = iconv("windows-874","UTF-8",$_SESSION['userLOG']['Fname']);
if(!isset($_SESSION['report'])){
        echo "<script>window.location = '../'</script>" ;
    }
require_once "../config/connect.php";
require_once "function.php" ;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="js/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="../js/alertify.min.js"></script>
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/0.6.2/pure-min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous">
    </script>

    <meta charset="UTF-8">
    <title>receipt</title>
    <style>
    .button-success,
    .button-error,
    .button-warning,
    .button-secondary {
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    }

    .button-success {
        background: rgb(28, 184, 65);
        /* this is a green */
    }

    .button-error {
        background: rgb(202, 60, 60);
        /* this is a maroon */
    }

    .button-warning {
        background: rgb(223, 117, 20);
        /* this is an orange */
    }

    .button-secondary {
        background: rgb(66, 184, 221);
        /* this is a light blue */
    }
    </style>
</head>

<body>
    <?  
        $myData = array();
        $sql = "SELECT * FROM personal.appm_personnel WHERE ID_CODE = $_IDCARD";
        $result = $conn2->query($sql);
        if ($result->num_rows > 0) {       
            while($row = $result->fetch_assoc()) {
                $myData['PREFIX_CODE'] = $row['PREFIX_NAME'];
            }
        }
        $pre = $myData['PREFIX_CODE'];
        $sql = "SELECT * FROM personal.appm_prefix WHERE PREFIX_CODE = $pre";
        $result = $conn2->query($sql);
        if ($result->num_rows > 0) {       
            while($row = $result->fetch_assoc()) {
                $myData['PREFIX_NAME'] = $row['PREFIX_NAME'];
            }
        }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $month = $year = "";
            $isErr = false ;
            
            if (empty($_POST["month"])) {
                $isErr = true ;
            } else {
                $month = $_POST["month"];
            }
            if (empty($_POST["year"])) {
                $isErr = true ;
            } else {
                $year = $_POST["year"];
            }
            $sql = "SELECT * FROM _receipt_vat.sarary WHERE id_card = $_IDCARD AND MONTH(date_Pay) = $month AND YEAR(date_imp) = $year";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {       
                $id = $id_card = $sarary = $col = $social_secure = $provident_fund = $sloan_fund = $cooperative = $acc_num = $name_bank = $date_imp ="";
                while($row = $result->fetch_assoc()) {
                        $myData['id'] = $row['id'];
                        $myData['sarary'] = $row['sarary'];
                        $myData['id_card'] = $row['id_card'];
                        $myData['col'] = $row['col'];
                        $myData['sumPlus'] = $row['sumPlus'];
                        $myData['vat'] = $row['vat'];
                        $myData['provident_fund'] = $row['provident_fund'];
                        $myData['social_secure'] = $row['social_secure'];
                        $myData['sloan_fund']=$row['sloan_fund'];
                        $myData['cooperative']=$row['cooperative'];
                        $myData['net']=$row['net'];
                        $myData['acc_num']=$row['acc_num'];
                        $myData['name_bank']=$row['name_bank'];
                        $myData['date_imp']=$row['date_imp'];
                        $d = date("d",strtotime($row['date_Pay']));
                        $m = date("m",strtotime($row['date_Pay']));
                        $y = date("Y",strtotime($row['date_Pay']));
                        $myData['date_Pay'] = $d." ".formatMonth($m)." ".formatYear($y);
                }
            }
            $myData['sumFall']  = formatMoney($myData['vat'])+formatMoney($myData['provident_fund'])+formatMoney($myData['social_secure'])
                                  +formatMoney($myData['sloan_fund'])+formatMoney($myData['cooperative']);
            $myData['sumFall'] = $myData['sumFall'];
            

            
            $id_card  =$myData['id_card'];
            $year = date('Y',strtotime($myData['date_imp']));
            $month = date('m',strtotime($myData['date_imp']));

            $sql = "SELECT sarary,social_secure FROM _receipt_vat.sarary 
            WHERE id_card = $id_card AND YEAR(date_imp) = $year AND MONTH(date_imp) <= $month AND YEAR(date_imp) = $year";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                $myData['sumSarary'] = "";
                $myData['sumSocial'] = "";
                $myData['sumVat'] = "";
                    while($row = $result->fetch_assoc()){
                        $myData['sumSarary'] = $myData['sumSarary'] + $row['sarary'];
                        $myData['sumSocial'] = $myData['sumSocial'] + $row['social_secure'];
                        $myData['sumVat'] = $myData['sumVat'] + $row['vat'];
                    }
            }else{
                ?>
    <script>
    alertify
        .alert("! ???????????????????????????????????????????????????????????????????????????????????????????????????").set({
            title: "???????????????????????????",
        });
    </script>
    <?
            }
    }else{
        if(isset($_POST['id'])) $id=$_POST['id'];
        $sql = "SELECT * FROM _receipt_vat.sarary WHERE id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {       
                $id = $id_card = $sarary = $col = $social_secure = $provident_fund = $sloan_fund = $cooperative = $acc_num = $name_bank = $date_imp ="";
                while($row = $result->fetch_assoc()) {
                        $myData['id'] = $row['id'];
                        $myData['sarary'] = $row['sarary'];
                        $myData['id_card'] = $row['id_card'];
                        $myData['col'] = $row['col'];
                        $myData['sumPlus'] = $row['sumPlus'];
                        $myData['vat'] = $row['vat'];
                        $myData['provident_fund'] = $row['provident_fund'];
                        $myData['social_secure'] = $row['social_secure'];
                        $myData['sloan_fund']=$row['sloan_fund'];
                        $myData['cooperative']=$row['cooperative'];
                        $myData['net']=$row['net'];
                        $myData['acc_num']=$row['acc_num'];
                        $myData['name_bank']=$row['name_bank'];
                        $myData['date_imp']=$row['date_imp'];
                        $d = date("d",strtotime($row['date_Pay']));
                        $m = date("m",strtotime($row['date_Pay']));
                        $y = date("Y",strtotime($row['date_Pay']));
                        $myData['date_Pay'] = $d." ".formatMonth($m)." ".formatYear($y);
                }
            }
            $myData['sumFall']  = formatMoney($myData['vat'])+formatMoney($myData['provident_fund'])+formatMoney($myData['social_secure'])
                                  +formatMoney($myData['sloan_fund'])+formatMoney($myData['cooperative']);
            $myData['sumFall'] = $myData['sumFall'];
            

            
            $id_card  =$myData['id_card'];
            $year = date('Y',strtotime($myData['date_imp']));
            $month = date('m',strtotime($myData['date_imp']));

            $sql = "SELECT sarary,social_secure,vat FROM _receipt_vat.sarary 
            WHERE id_card = $id_card AND YEAR(date_imp) = $year AND MONTH(date_imp) <= $month AND YEAR(date_imp) = $year";
            $result = $conn->query($sql);

            if($result->num_rows > 0){
                $myData['sumSarary'] = "";
                $myData['sumSocial'] = "";
                $myData['sumVat'] = "";
                    while($row = $result->fetch_assoc()){
                        $myData['sumSarary'] = $myData['sumSarary'] + $row['sarary'];
                        $myData['sumSocial'] = $myData['sumSocial'] + $row['social_secure'];
                        $myData['sumVat'] = $myData['sumVat'] + $row['vat'];
                    }
            }
    }
    ?>
    <div class="container mt-4">
        <span id="hideWarniun">
            <div class="row mr-5">
                <div class="flex-fill"></div>
                <div class="flex">
                    <form class="form-inline d-inline-flex pure-form" method="post">
                        <!-- ?????????????????????????????? -->
                        <div class="form-group  mr-1">
                            <select class="ml-2" name="month" id="month" required>
                                <option value="">???????????????</option>
                                <option value="1">??????????????????</option>
                                <option value="2">??????????????????????????????</option>
                                <option value="3">??????????????????</option>
                                <option value="4">??????????????????</option>
                                <option value="5">?????????????????????</option>
                                <option value="6">????????????????????????</option>
                                <option value="7">?????????????????????</option>
                                <option value="8">?????????????????????</option>
                                <option value="9">?????????????????????</option>
                                <option value="10">??????????????????</option>
                                <option value="11">???????????????????????????</option>
                                <option value="12">?????????????????????</option>
                            </select>
                        </div>
                        <!-- ????????????????????? -->
                        <div class="form-group  mr-2">
                            <select class="ml-2" name="year" id="year" required>
                                <option value="">??????</option>
                                <?for($i = date('Y') ; $i > date('Y')-10 ; $i-- ){
                                    $y = $i + 543;
                                    $res = "<option value='$i'>$y"."</option>";
                                    echo $res;
                                }
                                    ?>
                            </select>
                        </div>
                        <button type="submit" class="pure-button button-secondary  mr-2"><i class="fas fa-search"></i>
                            ???????????????</button>
                        <a id="save" class="button-error pure-button" style="color:white"><i
                                class="fas fa-file-pdf"></i> PDF
                            (download)</a>
                    </form>
                </div>
            </div>
        </span>

        <div id="content" class="mt-3">
            <div class="mt-4">
                <img src="img/banner.png" style="margin-left: 50px; width:250px; height:auto;">
            </div>
            <div class="row mt-3 mb-3">
                <div class="flex-fill" style="padding-left: 80px;">
                    <?
                    if(isset($name)){
                        echo $myData['PREFIX_NAME'].$name;
                    }
                    ?>
                    <h6 class="float-right pdRight">?????????????????????????????????????????????????????????????????? / ?????????????????????</h6>

                </div>
            </div>

            <div style="text-align: center!important;margin-bottom:5px">
                ?????????????????? ???????????????????????????????????????
            </div>
            <table class="table-invoice center">
                <thead>
                    <tr>
                        <th style="width: 180px; font-size: 14px">??????????????????</th>
                        <th style="width: 70px; font-size: 14px">???????????????????????????<br>(?????????)</th>
                        <th style="width: 70px; font-size: 14px">???????????????????????????<br>(?????????)</th>
                        <th style="width: 220px; font-size: 14px">?????????????????????<br>(?????????)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="row-fill">
                        <td class="font14">
                            <b>??????????????????????????????</b>
                            <?
                            if(isset($myData['date_Pay']) && !empty($myData['date_Pay'])){
                                $data = explode(' ',$myData['date_Pay']);
                                echo $data[1] . " " . $data[2];
                            }else{
                                echo "-";
                            }
                            ?>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div>???????????????????????????/?????????????????????</div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div>??????????????????????????????</div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div>????????????????????????????????? (???????????????????????????)</div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div>?????????????????????????????????????????????</div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div>????????????????????????????????????????????????????????????</div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div>???????????????????????????????????????????????????????????????</div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div>?????????./?????????.</div>
                            </div>
                        </td>
                        <td style="font-size:14px">
                            <b style="opacity: 0;">s</b>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div class="mr-1" style="text-align: right">
                                    <? if(isset($myData['sarary']) && $myData['sarary'] != "-"){
                                             echo number_format($myData['sarary'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div class="mr-1" style="text-align: right;">
                                    <? if(isset($myData['col']) && $myData['col'] != "-"){
                                             echo number_format($myData['col'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:14px">
                            <b style="opacity: 0;">s</b>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <b style="opacity: 0;">s</b>
                                <div style="opacity: 0;">s</div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div class="mr-1" style="text-align: right;">
                                    <? if(isset($myData['vat']) && $myData['vat'] != "-" && !empty($myData['vat'])){
                                             echo number_format($myData['vat'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div class="mr-1" style="text-align: right;">
                                    <? if(isset($myData['cooperative']) && $myData['cooperative'] != "-" && !empty($myData['cooperative'])){
                                             echo number_format($myData['cooperative'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div class="mr-1" style="text-align: right;">
                                    <? if(isset($myData['provident_fund']) && $myData['provident_fund'] != "-" && !empty($myData['provident_fund'])){
                                             echo number_format($myData['provident_fund'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div class="mr-1" style="text-align: right;">
                                    <? if(isset($myData['social_secure']) && $myData['social_secure'] != "-" && !empty($myData['social_secure'])){
                                             echo number_format($myData['social_secure'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="mt-1 ml-2" style="text-align: left;">
                                <div class="mr-1" style="text-align: right;">
                                    <? if(isset($myData['sloan_fund']) && $myData['sloan_fund'] != "-" && !empty($myData['sloan_fund'])){                                    
                                             echo number_format($myData['sloan_fund'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td class="sum">
                            <b>????????????????????????????????? ?????????????????????????????????
                                <? formatYear($year); ?>

                            </b><br />
                            <div class="detail d-flex">
                                <div class="flex-fill mt-1">???????????????????????????/?????????????????????</div>
                                <div>
                                    <?if(isset($myData['sumSarary'])){echo number_format($myData['sumSarary'],2);}
                                    else echo "-";?>
                                </div>
                            </div>
                            <div class="detail d-flex">
                                <div class="flex-fill mt-1">????????????????????????????????????</div>
                                <div>-</div>
                            </div>
                            <div class="d-flex">
                                <b class="flex-fill mt-1">?????????????????????????????? ????????????</b>
                                <b style="padding-right: 12px;">
                                    <?if(isset($myData['sumSarary']) && $myData['sumSarary'] != "-"){echo number_format($myData['sumSarary'],2);}
                                    else echo "-";?>
                                </b>
                            </div>
                            <div class="detail d-flex">
                                <div class="flex-fill mt-1">?????????????????????????????????????????? ??? ????????????????????? (???????????????????????????)</div>
                                <div>
                                    <?if(isset($myData['sumVat']) && $myData['sumVat'] != "-"){echo number_format($myData['sumVat'],2);}
                                    else echo "-";?>
                                </div>
                            </div>
                            <div class="detail d-flex">
                                <div class="flex-fill mt-1">?????????????????????????????????????????? ??? ????????????????????? (?????????????????????????????????)</div>
                                <div>-</div>
                            </div>
                            <div class="d-flex">
                                <b class="flex-fill mt-1">??????????????????????????????????????????????????? ??? ????????????????????? ????????????</b>
                                <div style="padding-right: 12px;">
                                    <b>
                                        <?if(isset($myData['sumVat']) && $myData['sumVat'] != "-"){echo number_format($myData['sumVat'],2);}
                                    else echo "-";?>
                                    </b>
                                </div>
                            </div>
                            <div class="d-flex">
                                <b class="flex-fill mt-1">????????????????????????????????????????????? ????????????</b>
                                <b style="padding-right: 12px;">
                                    <?if(isset($myData['sumSocial']) && $myData['sumSocial'] != "-"){echo number_format($myData['sumSocial'],2);}
                                    else echo "-";?>
                                </b>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>
                            <div style="text-align: right;">
                                <? if(isset($myData['sumPlus']) && $myData['sumPlus'] != "-"){
                                             echo number_format($myData['sumPlus'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                ?>
                            </div>
                        </td>
                        <td>
                            <div style="text-align: right;">
                                <? if(isset($myData['sumFall']) && $myData['sumFall'] != "-"){
                                            echo number_format($myData['sumFall'],2);
                                        }else{ 
                                             echo "-";
                                        }
                                ?>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex sum">
                                <b class="flex-fill">???????????????????????????????????????????????????????????????</b>
                                <b style="padding-right: 6px;">
                                    <? if(isset($myData['net']) && isset($myData['net'])){
                                            if($myData['net'] != "-"){echo number_format($myData['net'],2);}
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </b>
                            </div>
                        </td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="3">
                            <div class="ml-2" style="font-size:12px">????????????????????? : ???????????????????????????
                                <? 
                                if(isset($name)){
                                             echo $myData['PREFIX_NAME'].$name;
                                        }else{ 
                                             echo "-";
                                        }
                                ?>
                                ?????????????????? :
                                <? 
                                if(isset($myData['name_bank']) && !empty($myData['name_bank'])){
                                             echo $myData['name_bank'];
                                        }else{ 
                                             echo "-";
                                        }
                                ?>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div style="text-align:left;font-size:12px">

                                    ?????????????????? :
                                    <? if(isset($myData['acc_num']) && !empty($myData['acc_num'])){
                                             echo $myData['acc_num'];
                                        }else{ 
                                             echo "-";
                                        }
                                    ?>
                                </div>
                                <div style="text-align:left;margin-left:10px;font-size:12px">
                                    ?????????????????? :
                                    <?
                                    if(isset($myData['date_Pay']) && !empty($myData['date_Pay'])){
                                        echo $myData['date_Pay'];
                                    }else{
                                        echo "-";
                                    }
                                ?>
                                </div>
                            </div>
                        </td>


                    </tr>
                </tfoot>
            </table>
            <div class="mt-4 text-center" style="font-size:14px">???????????????????????? :
                ????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????/????????????????????? ????????????????????????????????? ????????????????????????????????????????????? <br>(????????????????????????????????????
                ??????????????????) ????????? 0-2926-9683 </div>
        </div>
        <hr>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/generatePDF.js"></script>
    <script>
    $(document).ready(function() {
        $('#save').click(function() {
            generatePDF();
        });
    });
    </script>
    </div>
</body>

</html>