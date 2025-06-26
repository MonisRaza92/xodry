<section class="xodry-pricing-section py-5 <?php echo !empty($subscriptions) ? '' : 'd-none'; ?>">
    <div class="container px-lg-0">
        <div class="section-heading p-3 mb-4">
            <h2 class="section-title" data-aos="fade-up">Affordable Pricing Plans</h2>
            <hr>
            <p class="section-subtitle" data-aos="fade-up">Choose a plan that fits your laundry needs.</p>

        </div>
        <div class="row justify-content-center gy-4">
            <!-- Basic Plan -->
            <?php foreach ($subscriptions as $subscription): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="xodry-pricing-card">
                        <div class="subs-card-heading ms-3">
                                <h2 class="pricing-title"><?php echo $subscription['title']; ?></h2>
                                <div class="pricing-price">₹<?php echo $subscription['price']; ?></div>
                        </div>
                        <hr>
                        <ul class="pricing-features">
                            <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point1']; ?></li>
                            <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point2']; ?></li>
                            <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point3']; ?></li>
                            <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point4']; ?></li>
                            <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point5']; ?></li>
                        </ul>
                        <a href="<?php echo $subscription['button_link']; ?>" class="pricing-btn ms-3"><?php echo $subscription['button_text']; ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>