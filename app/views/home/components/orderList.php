<?php
// Maps
$pickupItemMap = [];
foreach ($pickupItems as $item) {
    $pickupItemMap[$item['pickup_id']][] = $item;
}

$categoryMap = [];
foreach ($categories as $cat) {
    $categoryMap[$cat['id']] = $cat['category_name'];
}

$serviceMap = [];
foreach ($services as $srv) {
    $serviceMap[$srv['id']] = $srv['service_name'];
}

$pickupTotals = $pickupTotals ?? [];
$pickupTotalMap = [];
foreach ($pickupTotals as $total) {
    $pickupTotalMap[$total['pickup_id']] = $total;
}
?>

<div class="container mt-4">
    <?php foreach ($pickupList as $pickup): ?>
        <?php
        $pickupId = $pickup['id'];
        $items = $pickupItemMap[$pickupId] ?? [];
        $grouped = [];
        $mainPrice = $pickupTotalMap[$pickupId]['total_price'] ?? 0;
        $discount = $pickupTotalMap[$pickupId]['discount'] ?? 0;
        $finalAmount = $pickupTotalMap[$pickupId]['final_amount'] ?? $mainPrice;

        foreach ($items as $item) {
            $grouped[$item['category_id']][] = $item;
        }

        $isDiscountApplied = $discount > 0;
        ?>
        <div class="border rounded mb-3 p-3 bg-transparent text-dark">
            <div>
                <div class="d-flex justify-content-between">
                    <strong>Order #<?= htmlspecialchars($pickupId) ?></strong>
                    <?= htmlspecialchars($pickup['status']) ?>
                </div>
                <button onclick="togglePickupDetails(this, <?= $pickupId ?>)" class="btn btn-dark w-100 mt-2"
                        id="toggleBtn-<?= $pickupId ?>">Show Details</button>
            </div>

            <!-- Hidden Details -->
            <div class="pickup-details mt-3 text-dark" id="details-<?= $pickupId ?>" style="display: none;">
                <hr class="border-secondary">
                <p><strong>Name:</strong> <?= htmlspecialchars($pickup['name'] ?? 'N/A') ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($pickup['address'] ?? 'N/A') ?></p>
                <p><strong>Pickup Date:</strong> <?= htmlspecialchars($pickup['schedule'] ?? 'N/A') ?></p>
                <p><strong>Pickup Time:</strong> <?= htmlspecialchars($pickup['pickup_time'] ?? 'N/A') ?></p>

                <?php if (!empty($grouped)): ?>
                    <div>
                        <strong>Items:</strong>
                        <?php foreach ($grouped as $catId => $services): ?>
                            <div class="mt-2">
                                <div class="small text-uppercase"><?= htmlspecialchars($categoryMap[$catId] ?? 'Category') ?>:</div>
                                <ul class="list-group">
                                    <?php foreach ($services as $srv): ?>
                                        <li class="list-group-item ps-2 mt-2 d-flex justify-content-between align-items-center bg-transparent text-dark border small">
                                            <span>
                                                <?= htmlspecialchars($serviceMap[$srv['service_id']] ?? 'Service') ?>
                                                <span class="text-dark ms-2">x<?= $srv['quantity'] ?></span>
                                            </span>
                                            <span class="fw-bold">₹<?= $srv['total_price'] ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>

                        <!-- Discount Section -->
                        <div class="my-2 fw-bold">
                            <?php if (!$isDiscountApplied): ?>
                                <form method="post" action="apply-discount">
                                    <div class="input-group mb-3">
                                        <input type="text" name="code" class="form-control" placeholder="Enter Coupon" required>
                                        <input type="hidden" name="pickup_id" value="<?= $pickupId ?>">
                                        <input type="hidden" name="grand_total" value="<?= $mainPrice ?>">
                                        <button type="submit" class="btn btn-dark">Apply</button>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div class="text-success small mb-2">✅ Coupon applied successfully!</div>
                            <?php endif; ?>

                            <div>
                                Total: ₹<?= number_format($mainPrice, 2) ?><br>
                                <?php if (!empty($discount) && $discount > 0): ?>
                                    <span class="text-muted">Discount: ₹<?= number_format($discount, 2) ?></span><br>
                                    <span class="text-success">Final Amount: ₹<?= number_format($mainPrice - $discount, 2) ?></span>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-muted">No items found.</div>
                <?php endif; ?>

                <!-- Cancel Button -->
                <form method="post" action="cancelPickupStatus" class="d-inline mt-1 <?= in_array($pickup['status'], ['Picked Up', 'Dropped at Store', 'Processing', 'Assigned For Delivery', 'Out For Delivery', 'Delivered']) ? 'd-none' : '' ?>">
                    <input type="hidden" name="pickup_id" value="<?= $pickupId ?>">
                    <button type="submit" class="btn btn-dark mt-3"
                            onclick="return confirm('Are you sure you want to cancel this pickup?')">
                        <i class="fas fa-xmark me-1"></i> Cancel
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function togglePickupDetails(button, pickupId) {
        const detailsDiv = document.getElementById(`details-${pickupId}`);
        const isHidden = detailsDiv.style.display === 'none' || detailsDiv.style.display === '';
        detailsDiv.style.display = isHidden ? 'block' : 'none';
        button.innerText = isHidden ? 'Hide Details' : 'Show Details';
    }
</script>
