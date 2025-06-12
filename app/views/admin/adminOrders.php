<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . '/../includes/Header.php' ?>
    <title>Xodry Admin Dashboard - Affordable Laundry & Dry Cleaning in Delhi</title>
</head>

<body>
    <?php include_once __DIR__ . '/../includes/Navbar.php' ?>
    <div class="container-fluid pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 position-relative">
                    <?php include_once __DIR__ . '/partials/adminSidebar.php' ?>
                </div>
                <div class="col-lg-9">
                    <?php $pageName = "Orders";
                    include_once __DIR__ . '/../includes/breadcrumb.php' ?>
                    <?php include_once __DIR__ . '/partials/adminOrdersList.php'; ?>






                </div>
            </div>
        </div>
    </div>





    <?php include_once __DIR__ . '/../includes/Footer.php' ?>
</body>

</html>