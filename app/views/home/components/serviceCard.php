<?php foreach ($categoriesForCard as $cat): ?>
    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
        <div class="xodry-whatwedo-card p-0 h-100 bg-gradient">
            <img src="<?= htmlspecialchars((!empty($cat['image']) ? $cat['image'] : '/assets/images/Hero/hero-img.png')) ?>" alt="<?= htmlspecialchars($cat['category_name'] ?? '') ?>" class="mb-3 img-fluid">
            <div class="service-card-content p-4">
                <h4 class="xodry-whatwedo-card-title"><?= htmlspecialchars($cat['category_name'] ?? '') ?></h4>
                <p class="xodry-whatwedo-card-text"><?= htmlspecialchars($cat['description'] ?? '') ?></p>
                <ul>
                    <?php if (!empty($cat['bullet_point_1'])): ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_1'] ?? '') ?></li><?php endif; ?>
                    <?php if (!empty($cat['bullet_point_2'])): ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_2'] ?? '') ?></li><?php endif; ?>
                    <?php if (!empty($cat['bullet_point_3'])): ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_3'] ?? '') ?></li><?php endif; ?>
                    <?php if (!empty($cat['bullet_point_4'])): ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_4'] ?? '') ?></li><?php endif; ?>
                    <?php if (!empty($cat['bullet_point_5'])): ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_5'] ?? '') ?></li><?php endif; ?>
                </ul>
                <a class="btn text-white mt-4" style="background: var(--primary-color);" href="pricing">See Prices &nbsp; <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
<?php endforeach; ?>