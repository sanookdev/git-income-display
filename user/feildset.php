<div class="container-fluid">
    <div class="form-row mt-3">
        <div class="col-md-3">
            <fieldset class="add">
                <legend class="add">
                    <h6>ข้อมูลส่วนตัว</h6>
                </legend>
                <div class="form-row pure-form">
                    <div class="col-sm-4 mt-2">
                        <label for="user">รหัสพนักงาน : </label>
                        <input type="text" name="user" value="<?= $_SESSION['_USER']; ?> "
                            class="form-control form-control-sm" readonly />
                    </div>
                    <div class="col-sm-8 mt-2">
                        <label for="name">ชื่อ - สกุล: </label>
                        <input type="text" name="name" value="<?= $name ?> " class="form-control form-control-sm"
                            readonly />
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="add">
                <legend class="add">
                    <h6>ค้นหา</h6>
                </legend>
                <form id="search" method="post" enctype="multipart/form-data" class="pure-form">
                    <div class="form-row pure-form">
                        <div class="col-sm-6 mt-2">
                            <label for="data_choice">ประเภทรายได้</label>
                            <select name="data_choice" id="data_choice" class="form-control form-control-sm">
                                <option value="1" <? if (isset($_POST['data_choice']) && $_POST['data_choice']=='1' )
                                    echo "selected" ;?>>เงินเดือน</option>
                                <option value="2" <? if(isset($_POST['data_choice']) && $_POST['data_choice']=='2' )
                                    echo "selected" ;?>>เงินพิเศษอื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-sm-4 mt-2">
                            <label for="year">ปีค้นหา</label>
                            <select name="year" id="year" class="form-control form-control-sm">
                                <option value="" style="text-align: center;">ปี</option>
                                <? for($i = 0 ; $i < 10 ; $i++){?>
                                <option <?php if ($_POST['year'] == date('Y') - $i) {
                                        echo "selected";
                                    } ?> value="<?php echo  date('Y') - $i; ?>">
                                    <?php echo  date('Y') + (int)(543) - (int)($i); ?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="col-sm mt-2">
                            <label for="btn_search" style="opacity:0">#</label>
                            <button type="Submit" name="btn_search"
                                class="btn btn-primary btn-sm form-control form-control-sm"><i
                                    class="fas fa-search"></i> ค้นหา</button>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>