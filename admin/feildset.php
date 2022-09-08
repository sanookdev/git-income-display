<div class="container-fluid">
    <div class="form-row mt-3">
        <div class="col-sm mt-2">
            <fieldset class="add">
                <legend class="add">
                    <h6>เพิ่มข้อมูล ( เพิ่มหนึ่งรายการ / เพิ่มหลายรายการ )</h6>
                </legend>
                <form id="upload_csv" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-sm-6 mt-2">
                            <label for="upload_type"><u>เลือกประเภทรายได้ที่ต้องการเพิ่ม</u></label>
                            <select name="upload_type" id="upload_type" class="form-control form-control-sm"
                                required></select>
                        </div>
                        <div class="col-sm BT_ADD mt-2">
                            <label for="btn_add"><u>เพิ่มหนึ่งรายการ</u></label>
                            <input class="btn btn-success btn-sm btn_add btn-block" data-toggle="modal" data-target=""
                                value="+ เพิ่มรายการ" disabled readonly />
                        </div>
                        <div class="col-sm mt-2">
                            <label for="file_example"><u>เพิ่มหลายรายการ</u></label>
                            <a class="btn btn-info file_example btn-sm form-control form-control-sm disabled"
                                id="file_example" type="submit" download>
                                <i class="fas fa-file-alt"></i> ตัวอย่างไฟล์</a>
                            <div class="custom-file mt-1">
                                <input type="file" class="custom-file-input" id="excel" name="excel" required disabled>
                                <label class="custom-file-label" for="excel" id="name_file">Upload File ...</label>
                            </div>
                            <div class="border border-primary p-2 mt-1">
                                <span for="date_add"><u>วันจ่ายเงิน</u></span>
                                <input type="date" class="form-control form-control-sm mt-1" id="date_add"
                                    name="date_add" />
                            </div>
                            <input type="button" name="Import" id="Import" value="อัพโหลด"
                                class="btn btn-success btn-sm btn-block mt-1" disabled />
                        </div>
                        <div style="clear:both"></div>
                    </div>

                </form>
            </fieldset>
        </div>
        <div class="col-sm-4 mt-2">
            <fieldset class="add">
                <legend class="add">
                    <h6>ลบข้อมูลรายเดือน</h6>
                </legend>
                <form id="form_delete">
                    <div class="form-row">
                        <div class="col-sm mt-2">
                            <label for="delete_type">เลือกประเภทรายได้ที่ต้องการลบ</label>
                            <select name="delete_type" id="delete_type" class="form-control form-control-sm"
                                required></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md mt-2">
                            <select name="monthDelete" class="form-control form-control-sm" id="monthDelete" required>
                                <option value="" style=" text-align: center;">เดือน</option>
                                <?for($i = 1 ; $i <= 12 ; $i++){
                                if($i < 10){
                                    ?>
                                <option value="<?= '0'.$i;?>"><?= formatMonth('0'.$i);?> </option>
                                <?
                                }else{
                                    ?>
                                <option value=" <?= $i;?>"><?= formatMonth($i);?> </option>
                                <?
                                }    
                            }?>
                            </select>
                        </div>
                        <div class="col-md mt-2">
                            <select name="yearDelete" id="yearDelete" class="form-control form-control-sm" required>
                                <option value="">ปี</option>
                                <?for($i = 0 ; $i < 10 ; $i++){
                                    ?>
                                <option value="<?php echo  (date('Y') - $i); ?>">
                                    <?php echo  (date('Y') + 543) - $i; ?>
                                </option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-2 justify-content-end">
                        <div class="col-md-6">
                            <button
                                class="btn btn-sm btn-block btn-danger form-control form-control-sm btn_delete_all"><i
                                    class="fas fa-trash-alt"></i>
                                ลบข้อมูล</button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
    <div class="form-row mt-2">
        <div class="col-md">
            <fieldset class="add">
                <legend class="add">
                    <h6>ค้นหา</h6>
                </legend>
                <form action="" id="form_search" method="post">
                    <div class="form-row pure-form">
                        <div class="col-md-2 mt-2">
                            <label for="show_pick"><u>เลือกประเภทรายได้ : เพื่อแสดง</u></label>
                            <select class="form-control form-control-sm col-md-12 mt-2" name="show_pick" id="show_pick">
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col-sm-2 mt-2">
                            <input type="text" name="idcardSearch" id="idcardSearch"
                                class="form-control form-control-sm" placeholder="เลขบัตรประชาชน..."
                                <?php if (isset($_POST) && $_POST['idcardSearch']) ?>value=<?php echo  $_POST['idcardSearch']; ?>>
                        </div>
                        <div class="col-sm-2 mt-2">
                            <input class="departMent form-control form-control-sm" name="nameSearch" id="nameSearch"
                                placeholder="ชื่อ - สกุล"
                                value="<?= (isset($_REQUEST['nameSearch']) ? $_REQUEST['nameSearch'] : '') ;?>" />
                        </div>
                        <div class="col-sm-3 mt-2">
                            <select class="departMent form-control form-control-sm" name="departmentSearch"
                                id="departmentSearch" placeholder="หน่วยงาน">
                            </select>
                        </div>
                        <div class="col-sm-1 mt-2">
                            <select name="monthSearch" class="form-control form-control-sm" id="monthSearch">
                                <option value="" style=" text-align: center;">เดือน</option>
                                <?for($i = 1 ; $i <= 12 ; $i++){
                                if($i < 10){
                                    ?>
                                <option <?php if ($_POST['monthSearch'] == '0'.$i) {
                                        echo "selected";
                                    } ?> value="<?= '0'.$i;?>"><?= formatMonth('0'.$i);?> </option>
                                <?
                                }else{
                                    ?>
                                <option <?php if ($_POST['monthSearch'] == $i) {
                                        echo "selected";
                                    } ?> value=" <?= $i;?>"><?= formatMonth($i);?> </option>
                                <?
                                }    
                            }?>
                            </select>
                        </div>
                        <div class="col-sm-1 mt-2">
                            <select name="yearSearch" id="yearSearch" class="form-control form-control-sm">
                                <option value="">ปี</option>
                                <?for($i = 0 ; $i < 10 ; $i++){
                                    ?>
                                <option <?php if ($_POST['yearSearch'] == (date('Y') - $i)) {
                                        echo "selected";
                                    } ?> value="<?php echo  (date('Y') - $i); ?>">
                                    <?php echo  (date('Y') + 543) - $i; ?>
                                </option>
                                <?}?>
                            </select>
                        </div>
                        <div class="col-sm-1 mt-2">
                            <button type="button" class="btn btn-primary btn-sm form-control form-control-sm"
                                name="btn_search" id="btn_search"><i class="fas fa-search"></i> ค้นหา</button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>