<?php
// Maps banate hai pehle hi taaki baar-baar loop me na banaye
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
?>

<div class="container mt-4">
    <?php foreach ($pickupList as $pickup): ?>
        <?php
        $pickupId = $pickup['id'];
        $items = $pickupItemMap[$pickupId] ?? [];
        $grouped = [];
        $total = 0;

        foreach ($items as $item) {
            $grouped[$item['category_id']][] = $item;
            $total += $item['total_price'];
        }
        ?>
        <div class="border rounded mb-3 p-3 bg-transparent text-dark" style="cursor: pointer;" onclick="togglePickupDetails(this)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Order #<?= htmlspecialchars($pickupId) ?></strong>
                </div>
                <div>
                    <?= htmlspecialchars(date('d M Y', strtotime($pickup['schedule']))) ?>
                </div>
            </div>

            <!-- Hidden Details -->
            <div class="pickup-details mt-3" style="display: none;">
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
                                        <li class="list-group-item ps-2 mt-2 d-flex justify-content-between align-items-center bg-transparent text-white border small">
                                            <span>
                                                <?= htmlspecialchars($serviceMap[$srv['service_id']] ?? 'Service') ?>
                                                <span class="text-white ms-2">x<?= $srv['quantity'] ?></span>
                                            </span>
                                            <span class="fw-bold">₹<?= $srv['total_price'] ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                        <div class="mt-2 mb-3 fw-bold">Total: ₹<?= $total ?></div>
                    </div>
                <?php else: ?>
                    <div class="text-muted">No items found.</div>
                <?php endif; ?>

                <!-- Cancel Button -->
                <form method="post" action="cancelPickupStatus" class="d-inline mt-3">
                    <input type="hidden" name="pickup_id" value="<?= $pickupId ?>">
                    <button type="submit" class="btn btn-dark mt-3" onclick="return confirm('Are you sure you want to cancel this pickup?')">
                        <i class="fas fa-xmark me-1"></i> Cancel
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function togglePickupDetails(element) {
        const details = element.querySelector('.pickup-details');
        details.style.display = (details.style.display === 'none' || details.style.display === '') ? 'block' : 'none';
    }
</script>