<?
    session_start();
    error_reporting(0);
    // print_r($_SESSION);
    $name = iconv("windows-874","UTF-8",$_SESSION['userLOG']['Fname']);
    if(!isset($_SESSION['report']) || $_SESSION['report'] != '1'){
        echo "<script>window.location = '../'</script>" ;
    }
    $id_card = $_SESSION['_IDCARD'];
    include "../config/connect.php";
    $myData = array();

    

    // if คือเมื่อไม่มีการค้น else คือเมื่อมีการค้นหา
    if(!isset($_POST['year']) || $_POST['year'] == ""){
        $sql = "SELECT * FROM _receipt_vat.sarary WHERE id_card = $id_card ORDER BY date_imp DESC LIMIT 12";
        $result = $conn->query($sql);
        if($result->num_rows >0){
            $i=0;
            while($row = $result->fetch_assoc()){
                $myData[$i]['id'] = $row['id'];
                $myData[$i]['sarary'] = number_format($row['sarary'],2);
                $myData[$i]['col'] = number_format($row['col'],2);
                $myData[$i]['sumPlus'] = number_format($row['sumPlus'],2);
                $myData[$i]['vat'] = number_format($row['vat'],2);
                $myData[$i]['social_secure'] = number_format($row['social_secure'],2);
                $myData[$i]['provident_fund'] = number_format($row['provident_fund'],2);
                $myData[$i]['sloan_fund'] = number_format($row['sloan_fund'],2);
                $myData[$i]['cooperative'] = number_format($row['cooperative'],2);
                $myData[$i]['net'] = number_format($row['net'],2);
                $myData[$i]['date_imp'] = date('d-m-Y',strtotime($row['date_imp']));
                $i++;
            }
        }
    }else{
        $month = $_POST['month'];
        $year = $_POST['year'];
        $sql = "SELECT * FROM _receipt_vat.sarary WHERE id_card = $id_card AND YEAR(date_imp) = $year ORDER BY date_imp DESC LIMIT 12";
        $result = $conn->query($sql);
        $myData = array();
        if($result->num_rows >0){
            $i=0;
            while($row = $result->fetch_assoc()){
                $myData[$i]['id'] = $row['id'];
                $myData[$i]['sarary'] = number_format($row['sarary'],2);
                $myData[$i]['col'] = number_format($row['col'],2);
                $myData[$i]['sumPlus'] = number_format($row['sumPlus'],2);
                $myData[$i]['vat'] = number_format($row['vat'],2);
                $myData[$i]['social_secure'] = number_format($row['social_secure'],2);
                $myData[$i]['provident_fund'] = number_format($row['provident_fund'],2);
                $myData[$i]['sloan_fund'] = number_format($row['sloan_fund'],2);
                $myData[$i]['cooperative'] = number_format($row['cooperative'],2);
                $myData[$i]['net'] = number_format($row['net'],2);
                $myData[$i]['date_imp'] = date('d-m-Y',strtotime($row['date_imp']));
                $i++;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">

    <!-- FONT CSS LINK -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/0.6.2/pure-min.css">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="../css/themes/semantic.min.css">
    <link rel="stylesheet" href="../css/auto-complete.css">
    <title>รายการเงินได้พนักงาน</title>
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

    tbody>tr:hover {
        background-color: #FFFACD;
    }
    </style>
</head>

<body>

    <!-- HEADER AND FEILDSET  -->
    <? include "ui/header.php";?>
    <? include "feildset.php";?>

    <div class="container-fluid">
        <!-- ตาราง -->
        <div class="data-sarary">
            <table class="pure-table pure-table-bordered text-center" width="100%" id="data-table">
                <thead class="text-center">
                    <tr>
                        <th width="35px">#</th>
                        <th width="100px">วัน/เดือน/ปี</th>
                        <th style="color:green;">เงินเดือน</th>
                        <th style="color:green;">ค่าครองชีพ</th>
                        <th style="color:green;">รวมรายรับ</th>
                        <th style="color:red;">ภาษี</th>
                        <th style="color:red;">ประกันสังคม</th>
                        <th style="color:red;">กองทุนฯ</th>
                        <th style="color:red;">กยศ./กรอ.</th>
                        <th style="color:red;">สหกรณ์</th>
                        <th style="color:white;background:green;">รายรับสุทธิ</th>
                        <th width="100px"></th>
                    </tr>
                </thead>
                <tbody class="show-data  ">
                </tbody>
            </table>
        </div>

        <!-- ตาราง -->
        <div class="data-other">
            <table class="pure-table pure-table-bordered text-center" width="100%" id="data-table-other">
                <thead class="text-center headerTable">
                </thead>
                <tbody class="show-data-other">
                </tbody>
            </table>
        </div>
        <hr class="line_end_table">
    </div>




    <script src="./js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous">
    </script>

    <!-- DATATABLE JS  -->
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>

    <script>
    $(document).ready(function() {
        var data_choice = $('#data_choice').val();
        if (data_choice == '1') {
            $('.data-sarary').prop('hidden', false);
            $('.data-other').prop('hidden', true);
        } else {
            $('.data-sarary').prop('hidden', true);
            $('.data-other').prop('hidden', false);
        }
        $('#data_choice').on('change', function() {
            var data_choice = $('#data_choice').val();
            if (data_choice == '1') {
                $('.data-sarary').prop('hidden', false);
                $('.data-other').prop('hidden', true);
            } else {
                $('.data-sarary').prop('hidden', true);
                $('.data-other').prop('hidden', false);
            }
        })


        var year = <?= json_encode($_POST['year']);?>;
        var idcard = <?= json_encode($_SESSION['_IDCARD']);?>;
        $.ajax({
            type: "POST",
            url: "fetch_data.php",
            dataType: "json",
            data: {
                year: year,
                id_card: idcard,
                topic: 'sarary',
            },
            beforeSend: function() {
                $('.show_data').html('Searching....');
            },
            success: function(data) {
                output = '';
                if (data.length > 0) {
                    for (i = 0; i < data.length; i++) {
                        output += '<tr>';
                        output += '<td>' + parseInt(i + 1) + '</td>';
                        output += '<td>' + formatDate(data[i]['date_Pay']) + '</td>';
                        output += '<td style = "color:green">' + formatMoney(data[i][
                                'sarary'
                            ]) +
                            '</td>';
                        output += '<td style = "color:green">' + formatMoney(data[i]['col']) +
                            '</td>';
                        output += '<td style = "color:green">' + formatMoney(data[i][
                                'sumPlus'
                            ]) +
                            '</td>';
                        output += '<td style = "color:red">' + formatMoney(data[i]['vat']) +
                            '</td>';
                        output += '<td style = "color:red">' + formatMoney(data[i][
                                'social_secure'
                            ]) +
                            '</td>';
                        output += '<td style = "color:red">' + formatMoney(data[i][
                                'provident_fund'
                            ]) +
                            '</td>';
                        output += '<td style = "color:red">' + formatMoney(data[i][
                                'sloan_fund'
                            ]) +
                            '</td>';
                        output += '<td style = "color:red">' + formatMoney(data[i][
                                'cooperative'
                            ]) +
                            '</td>';
                        output += '<td style = "color:green">' + formatMoney(data[i]['net']) +
                            '</td>';
                        output += '<td>' +
                            '<button class = "btn btn-outline-info btn-sm btn_preview" value = "' +
                            data[i][
                                'id'
                            ] +
                            '"><i class = "fas fa-list-alt"></i> รายละเอียด</button>' +
                            '</td>';
                        output += '</tr>';
                    }

                    $('.show-data').html(output);
                } else {
                    $('.show-data').html('');
                }
                var table = $('#data-table').DataTable({
                    lengthChange: false,
                    searching: false,
                    pageLength: 12,
                });
                table.buttons().container()
                    .appendTo('#data-table_wrapper .col-md-6:eq(0)');
            }
        });
        var medCheck = <?= json_encode(substr($_SESSION['_USER'],1,2));?>;
        console.log(medCheck);
        $.ajax({
            type: "POST",
            url: "fetch_data.php",
            dataType: "json",
            data: {
                year: year,
                id_card: idcard,
                topic: 'other',
            },
            beforeSend: function() {
                $('.show_data').html('Searching....');
            },
            success: function(data) {
                data_other = {};
                d = new Date();
                if (year == null || year == "" || year == d.getFullYear()) {
                    var month = d.getMonth() + 1;
                    var output = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month;
                    console.log(output);
                } else {
                    var month = 12;
                    var output = year + '-' + (month < 10 ? '0' : '') + month;
                }
                for (i = 0; i < parseInt(month); i++) {
                    if (i < 9) {
                        m = "0" + parseInt(i + 1);
                    } else {
                        m = parseInt(i + 1);
                    }
                    if (medCheck == "SS") {
                        headTable = '';
                        headTable += '<tr>';
                        headTable += '<th width="35px">#</th>';
                        headTable += '<th width="80px">เดือน/ปี</th>';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนผู้ปฏิบัติงานนอกเวลา</th> ';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนเฉพาะตำแหน่ง </th> ';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนใบประกอบวิชาชีพ </th>';
                        headTable +=
                            '<th style="color:white;background:green;">รายรับสุทธิ</th> ';
                        headTable += '<th width="100px"></th>';
                        headTable += '</tr>';
                        $('.headerTable').html(headTable);
                        data_other[((i) < 9 ? '0' + parseInt(i + 1) : parseInt(i + 1))] = {
                            "14": "",
                            "15": "",
                            "16": "",
                            "month": m.toString(),
                            "year": (year == null) ? d.getFullYear().toString() : year
                                .toString(),
                        }
                    } else {
                        headTable = '';
                        headTable += '<tr>';
                        headTable += '<th width="35px">#</th>';
                        headTable += '<th width="80px">เดือน/ปี</th>';
                        headTable +=
                            '<th style="color:green;">ค่าที่ปรึกษาคณบดี</th> <!-- VAL = 2 -->';
                        headTable +=
                            '<th style="color:green;">ค่าสมนาคุณผู้บริหาร </th> <!-- VAL = 3 -->';
                        headTable +=
                            '<th style="color:green;">ค่าสมนาคุณหัวหน้างาน </th> <!-- VAL = 4 -->';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนเพื่อเพิ่มประสิทธิภาพและค่าตอบแทนเพื่อการเพิ่มประสิทธิภาพพิเศษ</th><!-- VAL = 5 -->';
                        headTable +=
                            '<th style="color:green;">เงินรางวัลประจำปี </th> <!-- VAL = 6 -->';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนภาระงานสอน </th> <!-- VAL = 7 -->';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนภาระงานสอนศูนย์สุขศาสตร์</th> <!-- VAL = 8 -->';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนแพทย์ผู้เชี่ยวชาญเฉพาะทาง</th> <!-- VAL = 9 -->';
                        headTable += '<th style="color:green;">ค่า พ.ต.ส.</th> <!-- VAL = 10 -->';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนอาจารย์ออกชุมชน</th> <!-- VAL = 11 -->';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนการใช้ภาษาต่างประเทศ</th> <!-- VAL = 12 -->';
                        headTable +=
                            '<th style="color:green;">ค่าตอบแทนเจ้าหน้าที่สัมผัสศพ</th> <!-- VAL = 13 -->';
                        headTable +=
                            '<th style="color:white;background:green;">รายรับสุทธิ</th> <!-- VAL = 14 -->';
                        headTable += '<th width="100px"></th>';
                        headTable += '</tr>';
                        $('.headerTable').html(headTable);
                        data_other[((i) < 9 ? '0' + parseInt(i + 1) : parseInt(i + 1))] = {
                            "2": "",
                            "3": "",
                            "4": "",
                            "5": "",
                            "6": "",
                            "7": "",
                            "8": "",
                            "9": "",
                            "10": "",
                            "11": "",
                            "12": "",
                            "13": "",
                            "14": "",
                            "month": m.toString(),
                            "year": (year == null) ? d.getFullYear().toString() : year
                                .toString(),
                        }
                    }
                }
                console.log(data_other);
                for (i = 0; i < data.length; i++) {
                    m_chose = data[i]['pay_date'].split(' ');
                    m_chose = m_chose[0].split('-');
                    m_chose = m_chose[1];
                    data_other[m_chose][data[i]['id_upload_type']] = data[i]['total'];
                }

                output = '';
                if ((Object.keys(data_other).length > 0)) {
                    for (i = 0; i < Object.keys(data_other).length; i++) {
                        j = '';
                        (i < 9) ? j = '0' + parseInt(i + 1): j = parseInt(i + 1);
                        total = 0;
                        my_data = data_other[j];
                        $.each(my_data, function(index, value) {
                            if (value != '' && index != 'year' && index != 'month' &&
                                index != 'ID_CARD') {
                                total += parseFloat(value);
                            }
                        });
                        y = new Date();
                        output += '<tr>';
                        output += '<td>' + parseInt(i + 1) + '</td>';
                        output += '<td>' + formatMonthToNameTH(j) + ((year != null && year !=
                                    '') ?
                                parseInt(year) + parseInt(543) : parseInt(y.getFullYear() + 543)
                            ) +
                            '</td>';
                        if (medCheck == "SS") {
                            for (k = 14; k <= 16; k++) {
                                output += '<td>' + formatMoney(my_data[k]) + '</td>';
                            }
                        } else {
                            for (k = 2; k <= 13; k++) {
                                output += '<td>' + formatMoney(my_data[k]) + '</td>';
                            }
                        }

                        output += '<td style = "color:green">' + formatMoney(total.toString()) +
                            '</td>';
                        output += '<td>' +
                            '<button class = "btn btn-outline-info btn-sm btn_preview_other" onclick = "preview_other(' +
                            my_data['month'] + ',' + ((my_data['year'] != null && my_data[
                                    'year'] !=
                                '') ? my_data['year'] : parseInt(y.getFullYear())) +
                            ')"><i class = "fas fa-list-alt"></i> รายละเอียด</button>' +
                            '</td>';
                        output += '</tr>';
                    }
                    $('.show-data-other').html(output);
                } else {
                    $('.show-data-other').html('');
                }
                var table = $('#data-table-other').DataTable({
                    lengthChange: false,
                    searching: false,
                    pageLength: 12,
                });
                table.buttons().container()
                    .appendTo('#data-table-other_wrapper .col-md-6:eq(0)');
            }
        });

        function formatDate(date) {
            var newDate = '';
            date = date.split('-');
            newDate = date[2] + '/' + date[1] + '/';
            newDate += parseInt(date[0]) + parseInt(543);
            return newDate;
        }

        function formatDateTH(date) {
            var newDate = '';
            date = date.split('-');
            if (date[1] == '01') {
                newDate += 'ม.ค.';
                newDate += parseInt(date[0]) + parseInt(543);
            } else if (date[1] == '02') {
                newDate += 'ก.พ.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '03') {
                newDate += 'มี.ค.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '04') {
                newDate += 'เม.ย.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '05') {
                newDate += 'พ.ค.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '06') {
                newDate += 'มิ.ย.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '07') {
                newDate += 'ก.ค.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '08') {
                newDate += 'ส.ค.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '09') {
                newDate += 'ก.ย.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '10') {
                newDate += 'ต.ค.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '11') {
                newDate += 'พ.ย.';
                newDate += parseInt(date[0]) + parseInt(543);

            } else if (date[1] == '12') {
                newDate += 'ธ.ค.';
                newDate += parseInt(date[0]) + parseInt(543);

            }
            return newDate;
        }

        function formatMoney(money) {
            newMoney = '';
            if (money > 0) {
                if (money.indexOf('.') < 0) {
                    newMoney = money + '.00';
                } else {
                    newMoney = money;
                }
            } else {
                newMoney = '-';
            }
            return newMoney;
        }

        function formatMonthToNameTH(month_number) {
            rs = '';
            if (month_number == '01') {
                rs = 'ม.ค.';
            } else if (month_number == '02') {
                rs = 'ก.พ.';
            } else if (month_number == '03') {
                rs = 'มี.ค.';
            } else if (month_number == '04') {
                rs = 'เม.ย.';
            } else if (month_number == '05') {
                rs = 'พ.ค.';
            } else if (month_number == '06') {
                rs = 'มิ.ย.';
            } else if (month_number == '07') {
                rs = 'ก.ค.';
            } else if (month_number == '08') {
                rs = 'ส.ค.';
            } else if (month_number == '09') {
                rs = 'ก.ย.';
            } else if (month_number == '10') {
                rs = 'ต.ค.';
            } else if (month_number == '11') {
                rs = 'พ.ย.';
            } else {
                rs = 'ธ.ค.';
            }
            return rs;
        }
    });
    $(document).on('click', '.btn_preview', function() {
        var id = $(this).val();
        if (id != '') {
            window.open('preview.php?id=' + id, '_blank');
        }
    })

    function preview_other(month, year) {
        if (month != '' && year != '') {
            window.open('preview_other.php?month=' + month + '&year=' + year, '_blank');
        }
    }
    </script>
</body>

</html>