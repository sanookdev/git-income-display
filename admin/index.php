<?php
    session_start();
    error_reporting(0);
    if($_SESSION['write'] != 1){
        echo "<script>window.location = '../'</script>" ;
    }
    include "function.php";
    $med_c = substr($_SESSION['_USER'],1,2);
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งรายได้บุคลากร</title>
    <!-- LINK CSS  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">


    <!-- FONT CSS LINK -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pure/0.6.2/pure-min.css">

    <style>
    a.disabled {
        pointer-events: none;
        cursor: default;
    }

    tbody>tr:hover {
        background-color: #FFFACD;
    }
    </style>

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./css/styles.css" />
    <link rel="stylesheet" href="./css/alertify.min.css">
    <link rel="stylesheet" href="./css/themes/semantic.min.css">
    <link rel="stylesheet" href="./css/auto-complete.css">
</head>

<body>
    <?php 
          include "ui/header.php"; 
          include "feildset.php";
    ?>
    <div class="container-fluid">
        <hr>
        <ol class="breadcrumb mt-3">
            <li class="breadcrumb-item active"> รายการค่าตอบแทน : <span class="type_pick_showdata"></span> </li>
        </ol>

        <div class="data_sarary" hidden>
            <table class="pure-table pure-table-bordered text-center" width="100%" id="data-table">
                <thead>
                    <tr style="text-align:center;">
                        <th style="width: 20px;">#</th>
                        <th>วันที่</th>
                        <th width="11%">หน่วยงาน</th>
                        <th width="9%">ชื่อ - สกุล</th>
                        <th style="color:green;">เงินเดือน</th>
                        <th style="color:green;">ค่าครองชีพ</th>
                        <th style="color:green;">รวมรายรับ</th>
                        <th style="color:red;">ภาษี / เดือน</th>
                        <th style="color:red;">ประกันสังคม</th>
                        <th style="color:red;">กองทุนฯ</th>
                        <th style="color:red;">กยศ./กรอ.</th>
                        <th style="color:red;">สหกรณ์</th>
                        <th style="color:white;background:green;border:grey">รายรับสุทธิ</th>
                        <th>เลขที่บัญชีธนาคาร</th>
                        <th>ธนาคาร</th>
                        <th width="60px"></th>
                    </tr>
                </thead>
                <tbody class="show_data"></tbody>
            </table>
        </div>
        <div class="data_other" hidden>
            <table class="pure-table pure-table-bordered text-center" width="100%" id="data-table-other">
                <thead class="table-dark">
                    <tr style="text-align:center;">
                        <th style="width: 20px;">#</th>
                        <th width="9%">ชื่อ - สกุล</th>
                        <th width="9%">ตำแหน่ง</th>
                        <th width="11%">รายการ</th>
                        <th style="color:green;">จำนวนเงิน</th>
                        <th style="color:red;">หักภาษี</th>
                        <th style="color:white;background:green;border:grey">คงเหลือสุทธิ</th>
                        <th>ธนาคาร</th>
                        <th>เลขที่บัญชี</th>
                        <th>วันที่โอน</th>
                        <th width="60px"></th>
                    </tr>
                </thead>
                <tbody class="show_data_other"></tbody>
            </table>
        </div>
    </div>

    <?
        include "modal/add_modal.php";
        include "modal/add_modal_other.php";
        include "modal/edit_modal.php";
        include "modal/edit_other_modal.php";
    ?>
    <br />
    <hr class="line_end_table">


    <!-- jQuery Link  -->
    <script src="./js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="./js/all.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>

    <script src="./js/alertify.min.js"></script>
    <script src="./js/auto-complete.js"></script>
</body>

<script>
$(document).ready(function() {
    var departSearch =
        <?= (isset($_POST['departmentSearch'])) ? json_encode($_POST['departmentSearch']) : json_encode("") ;?>;
    var show_pick =
        <?= (isset($_POST['show_pick'])) ? json_encode($_POST['show_pick']) : json_encode("") ;?>;
    if (show_pick == '') {
        show_pick = '1';
    }
    var med_c = <?= json_encode($med_c);?>;

    var search_arr = {
        nameSearch: $('#nameSearch').val(),
        departmentSearch: departSearch,
        monthSearch: $('#monthSearch').val(),
        yearSearch: $('#yearSearch').val(),
        idcardSearch: $('#idcardSearch').val(),
        show_pick: show_pick,
    }
    $.ajax({
        type: "POST",
        url: "search_upload_type.php",
        dataType: "json",
        success: function(data) {
            output = '';
            output_type = '';
            output += '<option value = "">เลือกประเภทรายได้</option>'
            for (i = 0; i < data.length; i++) {
                chk_selected = '';
                if (show_pick == data[i]['id_upload_type']) {
                    chk_selected = 'selected';
                } else {
                    chk_selected = '';
                }
                output_type += '<option value ="' + data[i]['id_upload_type'] + '"' +
                    chk_selected +
                    '>' + data[i][
                        'topic'
                    ] + '</option>';
                output += '<option value =' + data[i]['id_upload_type'] + '>' + data[i][
                    'topic'
                ] + '</option>';
            }
            $('#upload_type').html(output);
            $('#delete_type').html(output);
            $('#show_pick').html(output_type);
            if ($('#show_pick option:selected').val() == '1') {
                $('.type_pick_showdata').html('เงินเดือน');
                $('.data_sarary').prop('hidden', false);
                $('.data_other').prop('hidden', true);
                $('.btn_add').attr('data-target', '#add_modal');
            } else {
                $('.type_pick_showdata').html($('#show_pick option:selected').text());
                $('.data_other').prop('hidden', false);
                $('.data_sarary').prop('hidden', true);
                $('.btn_add').attr('data-target', '#add_modal_other');
            }
            $('[name = id_upload_type_other]').html(output);
        }
    });
    $('#upload_type').on('change', function() {
        upload_id = $(this).val();
        if (upload_id != '') {
            $('#file_example').removeClass('disabled');
            $('#upload_csv :input[name = "excel"],input[name ="Import"]').attr('disabled', false);
            $('.btn_add').attr('disabled', false);
            if (upload_id == '1') {
                $("#file_example").attr("href", "file/template.xlsx");
                $('.btn_add').attr('data-target', '#add_modal');
            } else {
                $("#file_example").attr("href", "file/template_other.xlsx");
                $('.btn_add').attr('data-target', '#add_modal_other');
            }
        } else {
            $('#file_example').addClass('disabled');
            $('#upload_csv :input[name = "excel"],input[name ="Import"]').attr('disabled', true);
            $('.btn_add').attr('disabled', true);

        }
    })
    if ($('#show_pick').val() != '') {
        $('.BT_ADD').prop('hidden', false);
        if ($('#show_pick').val() == '1') {
            $('.type_pick_showdata').html('เงินเดือน');
            $('.data_sarary').prop('hidden', false);
            $('.data_other').prop('hidden', true);
        } else {
            $('.type_pick_showdata').html('เงินอื่นๆ');
            $('.data_other').prop('hidden', false);
            $('.data_sarary').prop('hidden', true);
        }
    } else {
        $('.type_pick_showdata').html('');
        $('.data_sarary').prop('hidden', true);
        $('.data_other').prop('hidden', true);
        $('.BT_ADD').prop('hidden', true);
    }
    $('#show_pick').on('change', function() {
        if ($(this).val() != '') {
            if ($(this).val() == '1') {
                $('.type_pick_showdata').html('เงินเดือน');
                $('.data_sarary').prop('hidden', false);
                $('.data_other').prop('hidden', true);
            } else {
                $('.type_pick_showdata').html($('#show_pick option:selected').text());
                $('.data_other').prop('hidden', false);
                $('.data_sarary').prop('hidden', true);
                $('#data-table-other_filter').find("input[type = 'search']").val($(
                    '#show_pick option:selected').text()).keyup();
                $('#data-table-other_filter').attr('hidden', true);
            }
        } else {
            $('.type_pick_showdata').html('');
            $('.data_sarary').prop('hidden', true);
            $('.data_other').prop('hidden', true);
        }
    })
    $.ajax({
        type: "POST",
        url: "search.php",
        dataType: "json",
        data: {
            topic: 'department'
        },
        success: function(data) {
            output = '';
            output += '<option value = ""> หน่วยงาน...</option>';
            text_select = '';
            for (i = 0; i < data.length; i++) {
                if (departSearch == data[i]['SECTION_CODE']) {
                    text_select = 'selected';
                } else {
                    text_select = '';
                }
                output += '<option value ="' + data[i]['SECTION_CODE'] + '" ' + text_select + '>' +
                    data[i][
                        'DESCRIPTION'
                    ] + '</option>'
            }
            $('#departmentSearch').html(output);
        }
    });
    new autoComplete({
        selector: '#nameSearch',
        minChars: 1,
        source: function(term, response) {
            $.getJSON(
                'search.php', {
                    name: term,
                    topic: 'fullname',
                },
                function(data) {
                    response(data);
                });
        }
    });

    if ($('#idcardSearch').val() != '') {
        $('#nameSearch').val('');
        $('#departmentSearch').val('');
        $('#nameSearch').prop('disabled', true);
        $('#departmentSearch').prop('disabled', true);
    } else if ($('#nameSearch').val() != '' || departSearch != '') {
        $('#idcardSearch').prop('disabled', true);
        $('#departmentSearch').prop('disabled', false);
        $('#nameSearch').prop('disabled', false);
    }
    $('#idcardSearch').on('keyup', function() {
        if ($(this).val() != '') {
            $('#nameSearch').prop('disabled', true);
            $('#nameSearch').val('');
            $('#departmentSearch').prop('disabled', true);
            $('#departmentSearch').val('');

        } else {
            $('#nameSearch').prop('disabled', false);
            $('#departmentSearch').prop('disabled', false);
        }
    })
    $('#nameSearch').on('keyup', function() {
        if ($(this).val() != '') {
            $('#idcardSearch').prop('disabled', true);
        } else {
            $('#idcardSearch').prop('disabled', false);
        }
    })
    $('#departmentSearch').on('change', function() {
        if ($(this).val() != '') {
            $('#idcardSearch').prop('disabled', true);
        } else {
            $('#idcardSearch').prop('disabled', false);
        }
    })
    $('#btn_search').on('click', function() {
        $('#form_search').submit();
    })
    if (med_c != 'SS') {
        $.ajax({
            type: "POST",
            url: "fetch_data.php",
            dataType: "json",
            data: {
                data: search_arr,
            },
            beforeSend: function() {
                $('.show_data').html('Searching....');
            },
            success: function(data) {
                output = '';
                if (data.length > 0) {
                    for (i = 0; i < data.length; i++) {
                        if (data[i]['profile'] != undefined) {
                            output += '<tr>';
                            output += '<td>' + parseInt(i + 1) + '</td>';
                            output += '<td>' + formatDate(data[i]['date_Pay']) + '</td>';
                            output += '<td>' + data[i]['profile']['DESCRIPTION'] + '</td>';
                            output += '<td>' + data[i]['profile']['FULLNAME'] + '</td>';
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
                            output += '<td>' + data[i]['name_bank'] + '</td>';
                            output += '<td>' + data[i]['acc_num'] + '</td>';
                            output += '<td>' +
                                '<button class = "btn btn-outline-warning btn-sm btn_edit" value = "' +
                                data[i][
                                    'id'
                                ] +
                                '"><i class = "fas fa-edit"></i></button>' +
                                '<button class = "btn btn-outline-danger btn-sm ml-1 btn_delete" value = "' +
                                data[i][
                                    'id'
                                ] + '"><i class = "fas fa-trash-alt"></i></button>' +
                                '</td>';
                            output += '</tr>';
                        }
                    }
                    $('.show_data').html(output);
                } else {
                    $('.show_data').html('');
                }
                var table = $('#data-table').DataTable({
                    lengthChange: false,
                    searching: false,
                });
                table.buttons().container()
                    .appendTo('#data-table_wrapper .col-md-6:eq(0)');
            }
        });
    }

    $.ajax({
        type: "POST",
        url: "fetch_others.php",
        dataType: "json",
        data: {
            data: search_arr,
            medcode: med_c,
        },
        beforeSend: function() {
            $('.show_data_other').html('Searching....');
        },
        success: function(data) {
            output = '';
            if (data.length > 0) {
                for (i = 0; i < data.length; i++) {
                    output += "<tr>";
                    output += '<td>' + parseInt(i + 1) + '</td>';
                    output += '<td>' + data[i]['fullname'] + '</td>';
                    output += '<td>' + data[i]['position'] + '</td>';
                    output += '<td>' + data[i]['topic'] + '</td>';
                    output += '<td style = "color:green">' + formatMoney(data[i][
                            'amount'
                        ]) +
                        '</td>';
                    output += '<td style = "color:red">' + formatMoney(data[i]['vat']) +
                        '</td>';
                    output += '<td style = "color:green">' + formatMoney(data[i][
                            'total'
                        ]) +
                        '</td>';
                    output += '<td>' + data[i]['name_bank'] + '</td>';
                    output += '<td>' + data[i]['acc_num'] + '</td>';
                    output += '<td>' + data[i]['pay_date'] + '</td>';
                    output += '<td>' +
                        '<button class = "btn btn-outline-warning btn-sm btn_edit_other" value = "' +
                        data[i][
                            'id'
                        ] +
                        '"><i class = "fas fa-edit"></i></button>' +
                        '<button class = "btn btn-outline-danger btn-sm ml-1 btn_delete_other" value = "' +
                        data[i][
                            'id'
                        ] + '"><i class = "fas fa-trash-alt"></i></button>' +
                        '</td>';
                    output += "</tr>";
                }
                $('.show_data_other').html(output);
            } else {
                $('.show_data_other').html('');
            }
            var table_other = $('#data-table-other').DataTable({
                lengthChange: false,
            });
            table_other.buttons().container()
                .appendTo('#data-table-other_wrapper .col-md-6:eq(0)');
            $('#data-table-other_filter').find("input[type = 'search']").val($(
                '#show_pick option:selected').text()).keyup();
            $('#data-table-other_filter').attr('hidden', true);
        }
    });

    $("#show_pick").on('change', function(e) {
        e.preventDefault();
        $('#form_search').submit();
    })


    $('#form_edit').on('submit', function(e) {
        e.preventDefault();
        var data = {
            id_card: $('[name = id_card_edit]').val(),
            sarary: $('[name = sarary_edit]').val(),
            col: $('[name = col_edit]').val(),
            sumPlus: $('[name = sumPlus_edit]').val(),
            vat: $('[name = vat_edit]').val(),
            social_secure: $('[name = social_secure_edit]').val(),
            cooperative: $('[name = cooperative_edit]').val(),
            provident_fund: $('[name = provident_fund_edit]').val(),
            sloan_fund: $('[name = sloan_fund_edit]').val(),
            net: $('[name = net_edit]').val(),
            name_bank: $('[name = name_bank_edit]').val(),
            acc_num: $('[name = acc_num_edit]').val(),
            date_Pay: $('[name = date_Pay_edit]').val(),
            date_update: <?= json_encode(date('Y-m-d H:i:s')) ;?>,
            MED_UPDATE: <?= json_encode($_SESSION['_IDCARD']) ;?>
        };
        $.ajax({
            url: "update.php",
            method: "POST",
            data: {
                data,
                id_edit: $('[name = id_edit]').val(),
                table: 'sarary',
            },
            beforeSend: function() {
                $('#form_edit').val("Updating");
            },
            success: function(data) {
                $('#form_edit')[0].reset();
                $('#edit_modal').modal('hide');
                if (data == 1) {
                    sessionStorage.setItem('update_order', '1');
                    window.location.reload();
                }
            }
        });
    })
    $('#form_edit_other').on('submit', function(e) {
        e.preventDefault();
        var data = {
            id_card: $('[name = id_card_edit_other]').val(),
            fullname: $('[name = fullname_edit_other]').val(),
            position: $('[name = position_edit_other]').val(),
            id_upload_type: $('[name = id_upload_type_edit_other]').val(),
            amount: $('[name = amount_edit_other]').val(),
            vat: $('[name = vat_edit_other]').val(),
            total: $('[name = total_edit_other]').val(),
            name_bank: $('[name = name_bank_edit_other]').val(),
            acc_num: $('[name = acc_num_edit_other]').val(),
            pay_date: $('[name = date_pay_edit_other]').val(),
            date_update: <?= json_encode(date('Y-m-d H:i:s')) ;?>,
            MED_UPDATE: <?= json_encode($_SESSION['_IDCARD']) ;?>
        };
        $.ajax({
            url: "update.php",
            method: "POST",
            data: {
                data,
                id_edit: $('[name = id_edit_other]').val(),
                table: 'receipt_other',
            },
            beforeSend: function() {
                $('#form_edit_other').val("Updating");
            },
            success: function(data) {
                $('#form_edit_other')[0].reset();
                $('#edit_other_modal').modal('hide');
                if (data == 1) {
                    sessionStorage.setItem('update_order', '1');
                    window.location.reload();
                }
            }
        });
    })
    $('#form_add').on('submit', function(e) {
        e.preventDefault();
        var data = {
            id_card: $('[name = id_card]').val(),
            sarary: $('[name = sarary]').val(),
            col: $('[name = col]').val(),
            sumPlus: $('[name = sumPlus]').val(),
            vat: $('[name = vat]').val(),
            social_secure: $('[name = social_secure]').val(),
            cooperative: $('[name = cooperative]').val(),
            provident_fund: $('[name = provident_fund]').val(),
            sloan_fund: $('[name = sloan_fund]').val(),
            net: $('[name = net]').val(),
            name_bank: $('[name = name_bank]').val(),
            acc_num: $('[name = acc_num]').val(),
            date_Pay: $('[name = date_Pay]').val(),
            date_imp: $('[name = date_imp]').val(),
        };
        $.ajax({
            url: "insert.php",
            method: "POST",
            data: {
                data,
                table: 'sarary(id_card,sarary,col,sumPlus,vat,social_secure,provident_fund,cooperative,net,acc_num,name_bank,date_Pay,date_imp,MED_UPLOAD)',
                topic: 'sarary',
            },
            beforeSend: function() {
                $('#form_add').val("Inserting");
            },
            success: function(data) {
                $('#form_add')[0].reset();
                $('#add_modal').modal('hide');
                if (data == 1) {
                    sessionStorage.setItem('upload_order', '1');
                    window.location.reload();
                }
            }
        });
    })
    $('#form_add_other').on('submit', function(e) {
        e.preventDefault();
        var data = {
            id_card: $('[name = id_card_other]').val(),
            fullname: $('[name = fullname_other]').val(),
            position: $('[name = position_other]').val(),
            id_upload_type: $('[name = id_upload_type_other]').val(),
            amount: $('[name = amount_other]').val(),
            vat: $('[name = vat_other]').val(),
            total: $('[name = total_other]').val(),
            name_bank: $('[name = name_bank_other]').val(),
            acc_num: $('[name = acc_num_other]').val(),
            pay_date: $('[name = date_pay_other]').val(),
        };
        $.ajax({
            url: "insert.php",
            method: "POST",
            data: {
                data,
                table: 'receipt_other(id_card,fullname,position,id_upload_type,amount,vat,total,acc_num,name_bank,pay_date,MED_UPLOAD)',
                topic: 'other',
            },
            beforeSend: function() {
                $('#form_add_other').val("Inserting");
            },
            success: function(data) {
                $('#form_add_other')[0].reset();
                $('#add_modal_other').modal('hide');
                if (data == 1) {
                    sessionStorage.setItem('upload_order', '1');
                    window.location.reload();
                }
            }
        });
    })

    $('[name = id_card]').on('change', function() {
        $.ajax({
            type: "POST",
            url: "search.php",
            dataType: "json",
            data: {
                id_card: $('[name = id_card]').val(),
                topic: 'id_card',
            },
            success: function(data) {
                if (data != '') {
                    $('[name=fname]').val(data[0]['FULLNAME']);
                }
            }
        });
    })

    function upload_excel() {
        var file_data = $('#excel').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('type', $('#upload_type').val());
        form_data.append('date_add', $('#date_add').val());
        $.ajax({
            url: './upload.php',
            dataType: 'text',
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            beforeSend: function() {
                alertify
                    .alert("กำลังอัพโหลดข้อมูล ... ", function() {
                        sessionStorage.setItem('upload_order', '1');
                        window.location.href = "./index.php";

                    }).set({
                        title: 'แจ้งเตือน !'
                    });
            },
        });
    }

    $('#excel').on('change', function(e) {
        e.preventDefault();
        $('#name_file').html($(this).val());
    })
    $('#Import').on('click', function(e) {
        e.preventDefault();
        if ($('#date_add').val() != '' && $('#date_add').val() != undefined) {
            upload_excel();
        } else {
            alertify
                .alert("กรุณาเลือก วัน/เดือน/ปี ที่เงินออก ... ", function() {}).set({
                    title: 'แจ้งเตือน !'
                });
        }
    })

    $('.btn_delete_all').on('click', function(e) {
        e.preventDefault();
        deleteArr = [{
            'yearDel': $('#yearDelete option:selected').val(),
            'monthDel': $('#monthDelete option:selected').val(),
            'monthText': $('#monthDelete option:selected').text(),
            'deleteType': $('#delete_type option:selected').val(),
            'textType': $('#delete_type option:selected').text()
        }]
        if (deleteArr[0]['yearDel'] != '' &&
            deleteArr[0]['monthDel'] != '' &&
            deleteArr[0]['deleteType'] != '' &&
            deleteArr[0]['textType'] != '') {
            alertify.confirm(
                'ยืนยันการลบข้อมูล "' + deleteArr[0]['textType'] + '"<br> ประจำเดือน : ' +
                deleteArr[0]['monthText'] + (parseInt(deleteArr[0]['yearDel']) + parseInt(543)),
                function() {
                    $.ajax({
                        url: "deleteAll.php",
                        method: "POST",
                        data: {
                            data: deleteArr[0],
                        },
                        success: function(data) {
                            if (data == 1) {
                                sessionStorage.setItem('delete_order', '1');
                                window.location.href = './';
                            }
                        }
                    });
                },
                function() {
                    alertify.error('Cancel');
                }).set({
                title: 'แจ้งเตือน !'
            });
        } else {
            alertify
                .alert("กรุณากรอกประเภท , เดือน และปี ที่ต้องการลบให้ครบ", function() {}).set({
                    title: 'แจ้งเตือน !'
                });
        }

    })

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
})

$(document).on('click', '.btn_delete', function() {
    var id_delete = $(this).val();
    alertify.confirm("ยืนยันการลบข้อมูล ?",
        function() {
            $.ajax({
                type: "POST",
                url: "delete.php",
                dataType: "json",
                data: {
                    id: id_delete,
                    topic: 'sarary',
                },
                success: function(data) {
                    if (data == 1) {
                        sessionStorage.setItem('delete_order', "1");
                        window.location.href = "./";
                    } else {
                        alertify.error('ไม่สามารถลบข้อมูลได้');
                    }
                }
            });
        },
        function() {
            alertify.error('ยกเลิก');
        }).set({
        title: 'แจ้งเตือน !'
    });
})
$(document).on('click', '.btn_delete_other', function(e) {
    e.preventDefault();
    var id_delete = $(this).val();
    console.log(id_delete);
    alertify.confirm("ยืนยันการลบข้อมูล ?",
        function() {
            $.ajax({
                type: "POST",
                url: "delete.php",
                dataType: "json",
                data: {
                    id: id_delete,
                    topic: 'receipt_other',
                },
                success: function(data) {
                    if (data == 1) {
                        sessionStorage.setItem('delete_order', "1");
                        window.location.href = "./";
                    } else {
                        alertify.error('ไม่สามารถลบข้อมูลได้');
                    }
                }
            });
        },
        function() {
            alertify.error('ยกเลิก');
        }).set({
        title: 'แจ้งเตือน !'
    });
})
$(document).on('click', '.btn_edit', function() {
    var id_edit = $(this).val();
    output = '';
    $.ajax({
        type: "POST",
        url: "fetch.php",
        dataType: "json",
        data: {
            id: id_edit,
            topic: 'sarary',
        },
        success: function(data) {
            $('input[name=id_card_edit]').val(data[0]['id_card']);
            $('input[name=id_edit]').val(data[0]['id']);
            $('input[name=fullname_edit]').val(data[0]['FULLNAME']);
            $('input[name=sarary_edit]').val(data[0]['sarary']);
            $('input[name=col_edit]').val(data[0]['col']);
            $('input[name=sumPlus_edit]').val(data[0]['sumPlus']);
            $('input[name=vat_edit]').val(data[0]['vat']);
            $('input[name=social_secure_edit]').val(data[0]['social_secure']);
            $('input[name=cooperative_edit]').val(data[0]['cooperative']);
            $('input[name=provident_fund_edit]').val(data[0]['provident_fund']);
            $('input[name=sloan_fund_edit]').val(data[0]['sloan_fund']);
            $('input[name=net_edit]').val(data[0]['net']);
            $('input[name=acc_num_edit]').val(data[0]['acc_num']);
            $('input[name=name_bank_edit]').val(data[0]['name_bank']);
            $('input[name=date_Pay_edit]').val(data[0]['date_Pay']);
            console.log(data);
        }
    });
    $('.show_details_editModal').html(output);
    $('#edit_modal').modal('show');
})
$(document).on('click', '.btn_edit_other', function() {
    var id_edit = $(this).val();
    console.log(id_edit);
    output = '';
    $.ajax({
        type: "POST",
        url: "fetch.php",
        dataType: "json",
        data: {
            id: id_edit,
            topic: 'receipt_other',
        },
        success: function(data) {
            $('input[name=id_edit_other]').val(data[0]['id']);
            $('input[name=id_card_edit_other]').val(data[0]['id_card']);
            $('input[name=fullname_edit_other]').val(data[0]['fullname']);
            $('input[name=position_edit_other]').val(data[0]['position']);
            $('input[name=topic_edit_other]').val(data[0]['topic']);
            $('input[name=id_upload_type_edit_other]').val(data[0]['id_upload_type']);
            $('input[name=amount_edit_other]').val(data[0]['amount']);
            $('input[name=vat_edit_other]').val(data[0]['vat']);
            $('input[name=total_edit_other]').val(data[0]['total']);
            $('input[name=acc_num_edit_other]').val(data[0]['acc_num']);
            $('input[name=name_bank_edit_other]').val(data[0]['name_bank']);
            $('input[name=date_pay_edit_other]').val(data[0]['pay_date']);
        }
    });
    $('#edit_other_modal').modal('show');
})

if (sessionStorage.getItem('upload_order') == '1') {
    sessionStorage.setItem('upload_order', "0");
    alertify.success('Success');
}
if (sessionStorage.getItem('update_order') == '1') {
    sessionStorage.setItem('update_order', "0");
    alertify.success('Updated');
}
if (sessionStorage.getItem('delete_order') == '1') {
    sessionStorage.setItem('delete_order', "0");
    alertify.success('Deleted');
}
</script>

</html>