<?  
session_start();
error_reporting(0);
$name = iconv("windows-874","UTF-8",$_SESSION['userLOG']['Fname']);
if(!isset($_SESSION['report'])){
        echo "<script>window.location = '../'</script>" ;
    }
require_once "../config/connect.php";
require_once "function.php" ;
$monthSearch = $_REQUEST['month'];
$yearSearch = $_REQUEST['year'];
// เก็บ เลขเช็ค คำนำหน้าชื่อ
$prename = '' ;
$_IDCARD = $_SESSION['_IDCARD'];
$sql = "SELECT pre.PREFIX_NAME 
            FROM personal.appm_personnel AS per 
                JOIN personal.appm_prefix AS pre ON per.PREFIX_NAME = pre.PREFIX_CODE 
                    WHERE per.ID_CODE = '$_IDCARD'";
$result = $conn2->query($sql);
if ($result->num_rows > 0) {       
    while($row = $result->fetch_assoc()) {
        $prename = $row['PREFIX_NAME'];
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายได้อื่นๆ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="js/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="../js/alertify.min.js"></script>
    <link rel="stylesheet" href="../css/alertify.min.css">

</head>

<body>
    <div class="container mt-4">
        <!-- ส่วนที่ไม่เอามาปริ้น -->
        <span id="hideWarniun">
            <div class="row mr-5">
                <div class="flex-fill"></div>
                <div class="flex">
                    <button id="save" class="btn btn-danger"><i class="fas fa-file-pdf"></i> PDF (download)</button>
                </div>
            </div>
        </span>

        <!-- ส่วนที่เอามาปริ้น -->
        <div id="content">
            <div class="mt-4">
                <img src="img/banner.png" style="margin-left: 50px; width:250px; height:auto;">
            </div>
            <div class="row mt-3 mb-3">
                <div class="flex-fill" style="padding-left: 80px;">
                    <?
                    if(isset($name)){
                        echo $prename.$name;
                    }
                    ?>
                    <h6 class="float-right pdRight">ใบแจ้งการจ่ายเงินพิเศษ / ค่าจ้าง</h6>

                </div>
            </div>
            <div style="text-align: center!important;margin-bottom:5px">
                สังกัด คณะแพทยศาสตร์
            </div>

            <table class="table-invoice center">
                <thead>
                    <tr>
                        <th style="width: 40%; font-size: 14px">รายการ</th>
                        <th style="width: 15%; font-size: 14px">รายการรับ<br>(บาท)</th>
                        <th style="width: 15%; font-size: 14px">ภาษี (vat)<br>(บาท)</th>
                        <th style="width: 30%; font-size: 14px">คงเหลือสุทธิ<br>(บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="row-fill">
                        <td class="font14">
                            <b>ประจำเดือน</b>
                            <?
                            if(isset($month)){
                               echo formatMonth($month)." ".formatYear($year);
                            }else{
                                echo formatMonth(date('m'))." ".formatYear(date('Y'));
                            }
                            ?>
                            <span class="subject_output"></span>
                        </td>
                        <td style="font-size:14px">
                            <b style="opacity: 0;">s</b>
                            <span class="revenue_output"></span>
                        </td>
                        <td style="font-size:14px">
                            <b style="opacity: 0;">s</b>
                            <span class="expenditure_output"></span>
                        </td>
                        <td style="font-size:14px">
                            <b style="opacity: 0;">s</b>
                            <span class="total_output"></span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>
                            <div style="text-align: right;">
                                <span class="revenue_total"></span>
                            </div>
                        </td>
                        <td>
                            <div style="text-align: right;">
                                <span class="expenditure_total"></span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex sum">
                                <b class="flex-fill">รวมรายรับสุทธิ</b>
                                <b style="padding-right: 6px;">
                                    <span class="sum_output"></span>
                                </b>
                            </div>
                        </td>
                    </tr>
                    <tr class="no-border">
                        <td colspan="3">
                            <div class="ml-2" style="font-size:12px">โอนเข้า : ชื่อบัญชี
                                <? 
                                if(isset($name)){
                                             echo $myData['PREFIX_NAME'].$name;
                                        }else{ 
                                             echo "-";
                                        }
                                ?>
                                ธนาคาร : <span class="name_bank"></span>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div style="text-align:left;font-size:12px">
                                    เลขที่ : <span class="acc_num"></span>
                                </div>
                                <div style="text-align:left;margin-left:10px;font-size:12px">
                                    วันที่ : <span class="pay_date"></span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="mt-4 text-center" style="font-size:14px">หมายเหตุ :
                หากมีข้อสงสัยเกี่ยวกับใบแจ้งการจ่ายเงินเดือน/ค่าจ้าง กรุณาติดต่อ งานคลังและพัสดุ <br>(คุณอารีณัฎฐ์
                สีแก้ว) โทร 0-2926-9683 </div>
        </div>
        <hr>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/generatePDF.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous">
    </script>
</body>

</html>

<script>
$(document).ready(function() {
    var idcardSearch = <?= json_encode($_IDCARD);?>;
    var monthSearch = <?= json_encode($monthSearch);?>;
    var yearSearch = <?= json_encode($yearSearch);?>;
    $.ajax({
        url: "search.php",
        type: "POST",
        dataType: "json",
        data: {
            idcardSearch: idcardSearch,
            monthSearch: monthSearch,
            yearSearch: yearSearch,
        },
        success: function(data) {
            if (data.length > 0) {
                subject_output = ''; // หัวข้อรายการ
                revenue_output = ''; // รายรับ
                var revenue_total = 0;
                expenditure_output = ''; // รายจ่าย
                var expenditure_total = 0;
                total_output = ''; // รวม
                sum_output = '';
                for (i = 0; i < data.length; i++) {
                    subject_output += '<div class="mt-1 ml-2" style="text-align: left;">';
                    subject_output += '<div>' + data[i]['topic'] + '</div></div>';
                    revenue_output += '<div class="mt-1 ml-2" style="text-align: left;">';
                    revenue_output += '<div class="mr-1" style="text-align: right">';
                    revenue_output += addCommas(data[i]['amount'] + '.00');
                    revenue_output += '</div></div>';
                    revenue_total += parseInt(data[i]['amount']);
                    expenditure_output += '<div class="mt-1 ml-2" style="text-align: left;">';
                    expenditure_output += '<div class="mr-1" style="text-align: right;">';
                    expenditure_output += addCommas(data[i]['vat'] + '.00');
                    expenditure_output += '</div></div>';
                    expenditure_total += parseFloat(data[i]['vat']);
                    total_output += '<div class="mt-1 ml-2" style="text-align: left;">';
                    total_output += '<div class="mr-3" style="text-align: right;">';
                    total_output += '<div>';
                    total_output += addCommas(data[i]['total'] + '.00');
                    total_output += '</div></div>';
                }


                sum_output = addCommas(parseFloat(revenue_total) - parseFloat(expenditure_total));
                revenue_total = addCommas(revenue_total);
                expenditure_total = addCommas(expenditure_total);

                $('.subject_output').html(subject_output);
                $('.revenue_output').html(revenue_output);
                $('.revenue_total').html(revenue_total);
                $('.expenditure_output').html(expenditure_output);
                $('.expenditure_total').html(expenditure_total);
                $('.total_output').html(total_output);
                $('.sum_output').html(sum_output);
                $('.acc_num').html(data[0]['acc_num']);
                $('.name_bank').html(data[0]['name_bank']);
                $('.pay_date').html(convertDate(data[0]['pay_date']));
            }
        }

    })

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '.00';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function convertDate(date) {
        date = date.split('-');
        d = date[2];
        m = formatDateTH(date[1]);
        y = parseInt(date[0]) + parseInt(543);
        newDate = d + " " + m + " " + y;
        console.log(date[1]);
        console.log(m);
        return newDate;
    }

    function formatDateTH(date) {
        newDate = '';
        if (date == '01') {
            newDate += 'ม.ค.';
        } else if (date == '02') {
            newDate += 'ก.พ.';
        } else if (date == '03') {
            newDate += 'มี.ค.';
        } else if (date == '04') {
            newDate += 'เม.ย.';
        } else if (date == '05') {
            newDate += 'พ.ค.';
        } else if (date == '06') {
            newDate += 'มิ.ย.';
        } else if (date == '07') {
            newDate += 'ก.ค.';
        } else if (date == '08') {
            newDate += 'ส.ค.';
        } else if (date == '09') {
            newDate += 'ก.ย.';
        } else if (date == '10') {
            newDate += 'ต.ค.';
        } else if (date == '11') {
            newDate += 'พ.ย.';
        } else if (date == '12') {
            newDate += 'ธ.ค.';
        }
        return newDate;
    }
    $('#save').click(function() {
        generatePDF();
    });
})
</script>