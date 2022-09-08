<div class="container-fluid">
    <!-- The Modal For Add -->
    <div class="modal fade" id="add_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">เพิ่มรายการ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="statusMsg"></div>
                <form action="" id="form_add" method="post" class="pure-form">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h5><u>ข้อมูลส่วนตัว</u></h5>
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="id_card">เลขบัตรประชาชน : </label>
                                <input type="text" class="form-control form-control-sm" name="id_card" maxlength="13"
                                    minlength="13" required />
                            </div>
                            <div class="col-md-8">
                                <label for="fullname">ชื่อ -สกุล : </label>
                                <input type="text" name="fname" value="" class="form-control form-control-sm"
                                    readonly />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:#7FCA3C"><u>รายการรับ</u></h5>
                        <div class="form-row mt-2">
                            <div class="col-md">
                                <label for="sarary">เงินเดือน : </label>
                                <input type="text" name="sarary" class="form-control form-control-sm" required />
                            </div>
                            <div class="col-md">
                                <label for="col">ค่าครองชีพ : </label>
                                <input type="text" name="col" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md">
                                <label for="sumPlus">รวมรายรับ : </label>
                                <input type="text" name="sumPlus" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:red"><u>รายการหัก</u></h5>
                        <div class="form-row">
                            <div class="col-md">
                                <label for="vat">ภาษี : </label>
                                <input type="text" name="vat" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md">
                                <label for="social_secure">ประกันสังคม : </label>
                                <input type="text" name="social_secure" class="form-control form-control-sm" />
                            </div>
                            <div class="col-md">
                                <label for="cooperative">สหกรณ์ : </label>
                                <input type="text" name="cooperative" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md">
                                <label for="provident_fund">กองทุนฯ : </label>
                                <input type="text" name="provident_fund" class="form-control form-control-sm"
                                    required />
                            </div>
                            <div class="col-md">
                                <label for="sloan_fund">กยศ./กรอ. : </label>
                                <input type="text" name="sloan_fund" class="form-control form-control-sm" />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:orange"><u>รายรับสุทธิ</u></h5>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="net">รายรับสุทธิ : </label>
                                <input type="text" name="net" class="form-control form-control-sm" required />
                            </div>
                        </div>
                        <!--  -->
                        <hr>
                        <h5 style="color:purple"><u>ข้อมูลธนาคาร</u></h5>
                        <div class="form-row">
                            <div class="col-md">
                                <label for="acc_num">เลขที่บัญชี : </label>
                                <input type="text" name="acc_num" class="form-control form-control-sm" required />
                            </div>
                            <div class="col-md">
                                <label for="col">ธนาคาร : </label>
                                <input type="text" name="name_bank" class="form-control form-control-sm" required />
                            </div>
                            <div class="col-md">
                                <label for="date_Pay">วันที่โอนเงิน : </label>
                                <input type="date" name="date_Pay" class="form-control form-control-sm" required />
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer mt-2">
                            <button type="submit"
                                class="btn btn-success btn-block btn-sm btn_submit col-md-12">Submit</button>
                        </div>
                </form>
                <!-- <button class="btn btn-outline-info btn-sm btn_check">Check Val</button> -->
            </div>
        </div>
    </div>
</div>