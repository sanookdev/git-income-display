<div class="container-fluid">
    <!-- The Modal For Add -->
    <div class="modal fade" id="edit_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">แก้ไขรายการ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="statusMsg"></div>
                <form action="" id="form_edit" method="post" class="pure-form">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h5><u>ข้อมูลส่วนตัว</u></h5>
                        <div class="form-row">
                            <div class="col-md-2">
                                <label for="id_edit">#ลำดับ </label>
                                <input type="text" class="form-control form-control-sm" name="id_edit" readonly />
                            </div>
                            <div class="col-md-4">
                                <label for="id_card_edit">เลขบัตรประชาชน : </label>
                                <input type="text" class="form-control form-control-sm" name="id_card_edit"
                                    maxlength="13" minlength="13" readonly />
                            </div>
                            <div class="col-md-6">
                                <label for="fullname_edit">ชื่อ -สกุล : </label>
                                <input type="text" name="fullname_edit" value="" class="form-control form-control-sm"
                                    readonly />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:#7FCA3C"><u>รายการรับ</u></h5>
                        <div class="form-row mt-2">
                            <div class="col-md">
                                <label for="sarary_edit">เงินเดือน : </label>
                                <input type="text" name="sarary_edit" class="form-control form-control-sm" required />
                            </div>
                            <div class="col-md">
                                <label for="col_edit">ค่าครองชีพ : </label>
                                <input type="text" name="col_edit" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md">
                                <label for="sumPlus_edit">รวมรายรับ : </label>
                                <input type="text" name="sumPlus_edit" class="form-control form-control-sm" required />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:red"><u>รายการหัก</u></h5>
                        <div class="form-row">
                            <div class="col-md">
                                <label for="vat_edit">ภาษี : </label>
                                <input type="text" name="vat_edit" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md">
                                <label for="social_secure_edit">ประกันสังคม : </label>
                                <input type="text" name="social_secure_edit" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md">
                                <label for="cooperative_edit">สหกรณ์ : </label>
                                <input type="text" name="cooperative_edit" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md">
                                <label for="provident_fund_edit">กองทุนฯ : </label>
                                <input type="text" name="provident_fund_edit" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md">
                                <label for="sloan_fund_edit">กยศ./กรอ. : </label>
                                <input type="text" name="sloan_fund_edit" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:orange"><u>รายรับสุทธิ</u></h5>
                        <div class="form-row">
                            <div class="col-md-12">
                                <input type="text" name="net_edit" class="form-control form-control-sm" required />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:purple"><u>ข้อมูลธนาคาร</u></h5>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="name_bank_edit">ธนาคาร : </label>
                                <input type="text" name="name_bank_edit" class="form-control form-control-sm"
                                    required />
                            </div>
                            <div class="col-md">
                                <label for="acc_num_edit">เลขที่บัญชี : </label>
                                <input type="text" name="acc_num_edit" class="form-control form-control-sm" required />
                            </div>
                            <div class="col-md">
                                <label for="date_Pay_edit">วันที่โอนเงิน : </label>
                                <input type="date" name="date_Pay_edit" class="form-control form-control-sm" required />
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit"
                                class="btn btn-success btn-block btn-sm btn_update col-md-12">UPDATE</button>
                        </div>
                </form>
                <!-- <button class="btn btn-outline-info btn-sm btn_check">Check Val</button> -->
            </div>
        </div>
    </div>
</div>