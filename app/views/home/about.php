<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . '/../includes/Header.php'; ?>
    <title>Xodry Laundry Service - Affordable Laundry & Dry Cleaning in Delhi</title>
</head>

<body>
    <?php include_once __DIR__ . '/../includes/Navbar.php'; ?>
    <?php include_once __DIR__ .  '/../includes/login.php'; ?>
    <?php include_once __DIR__ .  '/../includes/userDetailsForm.php' ?>
   <div class="container-fluid">
    <div class="container">
    <?php $pageName = "About";
    include_once __DIR__ .  '/../includes/breadcrumb.php'; ?>
    </div>
   </div>
    <?php include_once __DIR__ .  '/partials/aboutOurStory.php'; ?>
    <?php include_once __DIR__ .  '/partials/vision&Mission.php'; ?>
    <?php include_once __DIR__ .  '/partials/ownerPortfolio.php'; ?>
    <?php include_once __DIR__ .  '/partials/FAQSection.php'; ?>
    <?php include_once __DIR__ .  '/partials/footerSection.php'; ?>






    <?php include_once __DIR__ . '/../includes/Footer.php'; ?>
</body>

</html>