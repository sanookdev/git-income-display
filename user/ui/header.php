<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="./"><img src="../images/med_logo.png" width="50px" height="auto">
        ระบบสลิปเงินเดือน</a>
    <ul class="navbar-nav d-md-inline-block form-inline ml-auto mr-auto mr-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <?= $_SESSION['_USER'];?> <i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <?if($_SESSION['write'] == '1'){?>
                <button class="dropdown-item btn_logout"
                    onclick="window.location.href = '../admin'">ผู้ดูแลระบบ</button>
                <?}?>
                <button class="dropdown-item btn_logout" onclick="window.location.href = '#'">สลิปรายได้</button>
                <!-- <button class="dropdown-item btn_logout" onclick="window.location.href = '../../'">Logout</button> -->
            </div>
        </li>
    </ul>
</nav>