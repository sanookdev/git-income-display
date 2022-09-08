<div class="container-fluid">
    <!-- The Modal For Add -->
    <div class="modal fade" id="edit_other_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">แก้ไขรายการ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="statusMsg"></div>
                <form action="" id="form_edit_other" method="post" class="pure-form">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h5><u>ข้อมูลส่วนตัว</u></h5>
                        <div class="form-row">
                            <div class="col-md-3">
                                <label for="id_edit_other">#ลำดับ </label>
                                <input type="text" class="form-control form-control-sm" name="id_edit_other" readonly />
                            </div>
                            <div class="col-md-4">
                                <label for="id_card_edit_other">เลขบัตรประชาชน : </label>
                                <input type="text" class="form-control form-control-sm" name="id_card_edit_other"
                                    maxlength="13" minlength="13" readonly />
                            </div>
                            <div class="col-md-5">
                                <label for="fullname_edit_other">ชื่อ -สกุล : </label>
                                <input type="text" name="fullname_edit_other" value=""
                                    class="form-control form-control-sm" readonly />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="position_edit_other">ตำแหน่ง</label>
                                <input type="text" class="form-control form-control-sm" name="position_edit_other"
                                    readonly />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:#7FCA3C"><u>รายการรับ</u></h5>
                        <div class="form-row mt-2">
                            <div class="col-md">
                                <label for="topic_edit_other">รายการ : </label>
                                <input type="text" name="topic_edit_other" class="form-control form-control-sm" required
                                    readonly />
                                <input type="text" name="id_upload_type_edit_other" class="form-control form-control-sm"
                                    hidden />
                            </div>
                            <div class="col-md">
                                <label for="amount_edit_other">จำนวนเงิน : </label>
                                <input type="text" name="amount_edit_other" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:red"><u>รายการหัก</u></h5>
                        <div class="form-row">
                            <div class="col-md">
                                <label for="vat_edit_other">ภาษี : </label>
                                <input type="text" name="vat_edit_other" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:orange"><u>คงเหลือสุทธิ</u></h5>
                        <div class="form-row">
                            <div class="col-md-12">
                                <input type="text" name="total_edit_other" class="form-control form-control-sm"
                                    required />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:purple"><u>ข้อมูลธนาคาร</u></h5>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="name_bank_edit_other">ธนาคาร : </label>
                                <input type="text" name="name_bank_edit_other" class="form-control form-control-sm"
                                    required />
                            </div>
                            <div class="col-md">
                                <label for="acc_num_edit_other">เลขที่บัญชี : </label>
                                <input type="text" name="acc_num_edit_other" class="form-control form-control-sm"
                                    required />
                            </div>
                            <div class="col-md">
                                <label for="date_pay_edit_other">วันที่โอนเงิน : </label>
                                <input type="date" name="date_pay_edit_other" class="form-control form-control-sm"
                                    required />
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