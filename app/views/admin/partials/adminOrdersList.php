<?php
// Build category map
$categoryMap = [];
foreach ($categories as $cat) {
    $categoryMap[$cat['id']] = $cat['category_name'];
}

// Build service map
$serviceMap = [];
foreach ($servicesName as $srv) {
    $serviceMap[$srv['id']] = $srv['service_name'];
}

// Group pickupItems by pickup_id
$pickupItemMap = [];
foreach ($pickupItems as $item) {
    $pickupItemMap[$item['pickup_id']][] = $item;
}

// Group total price data by pickup_id
$pickupTotals = $pickupTotals ?? [];
$pickupTotalMap = [];
foreach ($pickupTotals as $total) {
    $pickupTotalMap[$total['pickup_id']] = $total;
}

// Group pickups by status group
$tabs = [
    'pickups' => ['Order Placed', 'Assigned For Pickup', 'Pending Pickup', 'Going For Pickup', 'Picked Up'],
    'on_store' => ['Dropped at Store'],
    'delivery' => ['Assigned For Delivery', 'Out For Delivery'],
    'delivered' => ['Delivered'],
    'cancelled' => ['Cancelled'],
];

$groupedPickups = [
    'pickups' => [],
    'on_store' => [],
    'delivery' => [],
    'delivered' => [],
    'cancelled' => [],
];

foreach ($pickups as $pickup) {
    foreach ($tabs as $key => $statusList) {
        if (in_array($pickup['status'], $statusList)) {
            $groupedPickups[$key][] = $pickup;
            break;
        }
    }
}
?>

<!-- ✅ Bootstrap Tabs -->
<ul class="nav nav-pills mb-3" id="pickupTabs" role="tablist">
    <?php foreach ($tabs as $tabId => $statuses): ?>
        <li class="nav-item mb-2">
            <button class="nav-link <?= $tabId === 'pickups' ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#<?= $tabId ?>">
                <?= ucfirst($tabId) ?>
            </button>
        </li>
    <?php endforeach; ?>
</ul>

<!-- ✅ Tab Content -->
<div class="tab-content">
    <?php foreach ($groupedPickups as $tabId => $tabPickups): ?>
        <div class="tab-pane fade <?= $tabId === 'pickups' ? 'show active' : '' ?>" id="<?= $tabId ?>">
            <?php if (!empty($tabPickups)): ?>
                <div class="row g-2">
                    <?php foreach ($tabPickups as $pickup): ?>
                        <?php
                        $pickupId = $pickup['id'];
                        $items = $pickupItemMap[$pickupId] ?? [];
                        $grouped = [];
                        $totalPrice = $pickupTotalMap[$pickupId]['total_price'] ?? 0;
                        $discount = $pickupTotalMap[$pickupId]['discount'] ?? 0;
                        $finalAmount = $pickupTotalMap[$pickupId]['final_price'] ?? null;

                        $amountToShow = ($finalAmount !== null && $finalAmount > 0) ? $finalAmount : $totalPrice;

                        foreach ($items as $item) {
                            $grouped[$item['category_id']][] = $item;
                        }
                        ?>
                        <div class="col-12">
                            <div class="pickup-card" style="position: relative;">
                                <div class="flex-grow-1">
                                    <div class="pickup-header">
                                        <i class="bi bi-truck"></i> Order #<?= htmlspecialchars($pickupId) ?>
                                    </div>
                                    <div class="pickup-details">
                                        <strong>Customer:</strong> <?= htmlspecialchars($pickup['name'] ?? 'N/A') ?> #<?= htmlspecialchars($pickup['user_id'] ?? 'N/A') ?><br>
                                        <strong>Phone:</strong> <a href="tel:<?= htmlspecialchars($pickup['number'] ?? 'N/A') ?>"><?= htmlspecialchars($pickup['number'] ?? 'N/A') ?></a><br>
                                        <strong>Pickup Address:</strong> <?= htmlspecialchars($pickup['address'] ?? 'N/A') ?>
                                    </div>
                                    <div class="pickup-meta">
                                        <strong>Pickup Date:</strong> <?= htmlspecialchars($pickup['schedule'] ?? 'N/A') ?> &nbsp;
                                        <strong>Pickup Time:</strong> <?= htmlspecialchars($pickup['pickup_time'] ?? 'N/A') ?>
                                    </div>

                                    <div class="total-price <?= $pickup['status'] != 'Delivered' ? 'd-none' : '' ?>">
                                        <div class="mt-2 mb-3 fw-bold">
                                            <div class="text-white">Amount: ₹<?= number_format($amountToShow, 2) ?></div>
                                            <?php if (!empty($discount) && $discount > 0): ?>
                                                <div class="text-success small">Discount Applied: ₹<?= number_format($discount, 2) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="actions <?= in_array($pickup['status'], ['Delivered', 'Cancelled']) ? 'd-none' : '' ?>">
                                    <!-- Status Form -->
                                    <form method="post" action="updatePickupStatus" class="pickup-status-form mt-3">
                                        <input type="hidden" name="pickup_id" value="<?= $pickupId ?>">
                                        <select name="status" class="form-select status-btn">
                                            <?php
                                            $statuses = ['Order Placed', 'Assigned For Pickup', 'Pending Pickup', 'Going For Pickup', 'Picked Up', 'Dropped at Store', 'Processing', 'Assigned For Delivery', 'Out For Delivery', 'Delivered', 'Cancelled'];
                                            foreach ($statuses as $status): ?>
                                                <option value="<?= $status ?>" <?= $pickup['status'] === $status ? 'selected' : '' ?>>
                                                    <?= $status ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="pickup-status-msg mt-2"></div>
                                    </form>

                                    <!-- Rider Assign Form -->
                                    <form method="post" action="assign-rider" class="rider-assign-form mt-2">
                                        <input type="hidden" name="pickup_id" value="<?= $pickupId ?>">
                                        <select name="rider_id" class="form-select">
                                            <option value="">Assign Rider</option>
                                            <?php foreach ($riders as $rider): ?>
                                                <option value="<?= $rider['id'] ?>" <?= $pickup['rider_id'] == $rider['id'] ? 'selected' : '' ?>>
                                                    <?= $rider['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="rider-assign-msg mt-2"></div>
                                    </form>

                                    <!-- See Items -->
                                    <button type="button" class="btn btn-sm w-100 btn-outline-light mt-3 toggle-items-btn" data-pickup-id="<?= $pickupId ?>">See Items</button>
                                    <div class="pickup-items-list mt-2" style="display: none;">
                                        <?php if (!empty($grouped)): ?>
                                            <?php foreach ($grouped as $catId => $services): ?>
                                                <div class="mb-2">
                                                    <h6 class="text-dark fw-bold bg-light p-2 rounded">
                                                        <?= htmlspecialchars($categoryMap[$catId] ?? 'Unknown Category') ?>
                                                    </h6>
                                                    <ul class="list-group mb-2">
                                                        <?php foreach ($services as $srv): ?>
                                                            <li class="list-group-item">
                                                                <strong>Service:</strong>
                                                                <?= htmlspecialchars($serviceMap[$srv['service_id']] ?? 'Unknown') ?> |
                                                                <strong>Qty:</strong> <?= htmlspecialchars($srv['quantity']) ?> |
                                                                <strong>Price:</strong> ₹<?= number_format($srv['total_price'], 2) ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                            <div class="text-end fw-bold bg-success text-white p-2 rounded">
                                                Amount: ₹<?= number_format($amountToShow, 2) ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-info mt-2">No items found.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No records found in this section.</div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- ✅ Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle items
        document.querySelectorAll('.toggle-items-btn').forEach(button => {
            button.addEventListener('click', () => {
                const card = button.closest('.pickup-card');
                const itemList = card.querySelector('.pickup-items-list');
                if (itemList.style.display === 'none' || itemList.style.display === '') {
                    itemList.style.display = 'block';
                    button.textContent = 'Hide Items';
                } else {
                    itemList.style.display = 'none';
                    button.textContent = 'See Items';
                }
            });
        });

        // Pickup status change
        document.querySelectorAll('.pickup-status-form select[name="status"]').forEach(select => {
            select.addEventListener('change', () => {
                const form = select.closest('form');
                const formData = new FormData(form);
                const msgDiv = form.querySelector('.pickup-status-msg');
                fetch(form.action, { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        msgDiv.style.display = 'block';
                        msgDiv.innerHTML = data.status === 'success' ?
                            '<div class="alert alert-success">Status updated!</div>' :
                            '<div class="alert alert-danger">Error updating status!</div>';
                        setTimeout(() => { msgDiv.style.display = 'none'; }, 2000);
                    });
            });
        });

        // Rider assign change
        document.querySelectorAll('.rider-assign-form select[name="rider_id"]').forEach(select => {
            select.addEventListener('change', () => {
                const form = select.closest('form');
                const formData = new FormData(form);
                const msgDiv = form.querySelector('.rider-assign-msg');
                fetch(form.action, { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        msgDiv.style.display = 'block';
                        msgDiv.innerHTML = data.success ?
                            '<div class="alert alert-success">Rider assigned!</div>' :
                            '<div class="alert alert-danger">Error assigning rider!</div>';
                        setTimeout(() => { msgDiv.style.display = 'none'; }, 2000);
                    });
            });
        });
    });
</script>
