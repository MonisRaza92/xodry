<?php

use helpers\HelperFunctions;
use App\Models\CategoryModel;
use App\Models\PickupItemsModel;
use App\Models\ServiceModel;

$helperFunctions = new HelperFunctions();
$navbarData = $helperFunctions->getNavbarData();
$orderCount = $navbarData['orderCount'];
$pickupList = $navbarData['pickupList'];
$catModel = new CategoryModel();
$categories = $catModel->getAllCategories();

$pickupModel = new PickupItemsModel();
$pickupItems = $pickupModel->getAllPickupItems();

$serviceModel = new ServiceModel;
$services = $serviceModel->getAllServices();

$pickupItemsModel = new pickupItemsModel();
$pickupTotals = $pickupItemsModel->getAllTotals();

$user = HelperFunctions::userDetails();


?>
<nav class="container-fluid px-lg-0">
    <div class="container navbar pe-lg-0">
        <a href="home""><img src=" assets/images/Logo/xodry-light-logo.png" alt="Xodry"></a>
        <div class="nav-links">
            <a class="d-none d-md-block <?php echo basename($_SERVER['REQUEST_URI']) == 'home' ? 'active-nav' : '' ?>"
                href="home">home</a>
            <a class="d-none d-md-block <?php echo basename($_SERVER['REQUEST_URI']) == 'about' ? 'active-nav' : '' ?>"
                href="about">About</a>
            <a class="d-none d-md-block <?php echo basename($_SERVER['REQUEST_URI']) == 'services' ? 'active-nav' : '' ?>"
                href="services">Services</a>
            <a class="d-none d-md-block <?php echo basename($_SERVER['REQUEST_URI']) == 'pricing' ? 'active-nav' : '' ?>"
                href="pricing">Pricing</a>
            <div class="login-btn position-relative">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                        <a href="admin" class="mx-2 d-none d-lg-block"><i class="fa-solid nav-icons fa-chart-simple"></i></a>
                        <a href="admin" class="mx-2 admin-menu-open-btn d-lg-none"><i
                                class="fa-solid nav-icons fa-chart-simple"></i></a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'rider'): ?>
                        <a href="rider" class="mx-2"><i class="fa-solid nav-icons fa-chart-simple"></i></a>
                    <?php endif; ?>
                    <button class="position-relative" id="cartBtn"><span><?= $orderCount ?></span><i
                            class="fa-regular nav-icons fa-bell"></i></button>
                    <div id="cart">
                        <div class="cart-heading">
                            <h6>Orders</h6>
                            <a href="#"><i class="fa-solid fa-clock-rotate-left"></i> HISTORY</a>
                        </div>
                        <?php include __DIR__ . '/../home/components/orderList.php' ?>
                    </div>
                    <button id="accountMenuBtn"><i class="fa-regular nav-icons fa-user"></i></button>
                    <div class="account-menu rounded">
                        <div class="user-info-section d-flex">
                            <i class="fa-regular fa-user"></i>
                            <div class="user-info">
                                <p><?php echo htmlspecialchars($user['name'] ?? 'Guest'); ?></p>
                                <p><?php echo htmlspecialchars($user['number'] ?? '1234567890'); ?></p>
                            </div>
                        </div>
                        <a class="ms-1" href="#" id="userDetailsBtn"><i class="fa-regular fa-user"></i> Profile</a>
                        <a class="ms-1" href="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                    </div>
                <?php else: ?>
                    <button id="loginBtn" class="nav-login-btn">Login&nbsp;<i
                            class="fa-solid fa-arrow-right-to-bracket"></i></button>
                <?php endif; ?>
            </div>
            <div id="mobile-menu-icon" class="mobile-menu-icon d-md-none ms-1"><i
                    class="fa-solid nav-icons fa-bars"></i>
            </div>
        </div>
    </div>
</nav>
<script>
    const myElement = document.querySelector('nav');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 100) {
            myElement.classList.add('scrolled');
        } else {
            myElement.classList.remove('scrolled');
        }
    });
</script>
<div id="mobile-menu" class="mobile-menu d-md-none">
    <div class="mobile-header">
        <a href="home"><img src="assets/images/Logo/xodry-light-logo.png" alt="Xodry"></a>
        <div id="mobile-menu-close" class="mobile-menu-close"></div>
    </div>
    <div class="mobile-links">
        <a href="home">home</a>
        <a href="about">About</a>
        <a href="services">Services</a>
        <a href="pricing">Pricing</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cancelButtons = document.querySelectorAll('.cancel-pickup');

        cancelButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const pickupId = this.getAttribute('data-pickup-id');

                if (confirm('Are you sure you want to cancel this pickup?')) {
                    const formData = new FormData();
                    formData.append('pickup_id', pickupId);

                    fetch('pickups/cancelPickupStatus', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Remove the pickup from the list
                                this.closest('.short-order-list').remove();
                                // Update the order count
                                const orderCountSpan = document.querySelector('#cartBtn span');
                                const currentCount = parseInt(orderCountSpan.textContent);
                                orderCountSpan.textContent = currentCount - 1;
                            } else {
                                alert('Failed to cancel pickup: ' + data.message);
                            }
                        })
                        .catch(error => {
                            alert('An error occurred while cancelling the pickup');
                        });
                }
            });
        });
    });
</script>