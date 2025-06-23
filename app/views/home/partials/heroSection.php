<div class="container-fluid hero-section">
    <div class="container px-0">
        <!-- <?php include __DIR__ . '/../components/imageSlider.php' ?> -->
        <div class="row">
            <div class="hero-content col-lg-5">
                <h6 class="mb-4">WELCOME TO <span>XODRY</span></h6>
                <h1 class="heading mt-2" data-aos="fade-up">Freshnes Deliverd to Your Door</h1>
                <p class="lead mb-4 mt-3" data-aos="fade-up">Discover the ultimate care for your clothes with our top-tier laundry and dry cleaning services.
                </p>
                <button data-aos="fade-up" id="scheduleBtn">Schedule Pickup</button>
                <button data-aos="fade-up" id="loginBtn" class="ms-3 <?php if (isset($user)) echo 'd-none'; ?>">Login</button>
                <button data-aos="fade-up" onclick="window.location.href='pricing'" class="ms-3 <?php if (!isset($user)) echo 'd-none'; ?>">Pricing</button>

            </div>
            <div class="hero-img col-lg-7" data-aos="fade-up">
                <?php include __DIR__ . '/../components/imageSlider.php' ?>
            </div>
        </div>
        <?php include __DIR__ . '/../components/service-slider.php' ?>
    </div>
</div>