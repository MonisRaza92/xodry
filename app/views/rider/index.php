<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . '/../includes/Header.php' ?>
    <title>Xodry Rider Dashboard - Affordable Laundry & Dry Cleaning in Delhi</title>
</head>

<body>
    <?php include_once __DIR__ . '/../includes/Navbar.php' ?>
    <div class="container-fluid">
        <div class="container">
        <?php $pageName = "Dashboard";
        include_once __DIR__ . '/../includes/breadcrumb.php' ?>
        </div>
    </div>
    <?php include_once __DIR__ . '/partials/riderStats.php' ?>
    <?php include_once __DIR__ . '/partials/riderPickups.php' ?>
    <?php include_once __DIR__ . '/partials/riderCompletedPickups.php' ?>




    <?php include_once __DIR__ . '/../includes/Footer.php' ?>
</body>

</html>