<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="./"><img src="../images/med_logo.png" width="50px" height="auto">
            ระบบสลิปเงินเดือน</a>
        <ul class="navbar-nav d-md-inline-block form-inline ml-auto mr-auto mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?= $_SESSION['_USER'];?> <i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <button class="dropdown-item btn_logout" onclick="window.location.href = '#'"><i
                            class="fas fa-user"></i> ผู้ดูแลระบบ</button>
                    <button class="dropdown-item btn_logout" onclick="window.location.href = '../user'"><i
                            class="fas fa-list-alt"></i> สลิปรายได้</button>
                    <!-- <button class="dropdown-item btn_logout" onclick="window.location.href = '../../'"><i
                            class="fas fa-sign-out-alt"></i> Logout</button> -->
                </div>
            </li>
        </ul>
    </nav>
</body>

</html>