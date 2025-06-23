<?php
// Build category map
$categoryMap = [];
foreach ($categories as $cat) {
    $categoryMap[$cat['id']] = $cat['category_name'];
}

// Build service map
$serviceMap = [];
foreach ($services as $srv) {
    $serviceMap[$srv['id']] = $srv['service_name'];
}

// Group pickupItems by pickup_id
$pickupItemMap = [];
foreach ($pickupItems as $item) {
    $pickupItemMap[$item['pickup_id']][] = $item;
}
?>

<div class="container my-4">
    <?php if (!empty($pickups)): ?>
        <div class="row g-4">
            <?php foreach ($pickups as $pickup): ?>
                <?php
                // Is pickup ke items le lo (pickupItems array se)
                $items = $pickupItemMap[$pickup['id']] ?? [];
                ?>
                <div class="col-12">
                    <div class="pickup-card" style="position: relative;">
                        <div class="flex-grow-1">
                            <div class="pickup-header">
                                <i class="bi bi-truck"></i> Order #<?= htmlspecialchars($pickup['id']) ?>
                            </div>
                            <div class="pickup-details">
                                <strong>Customer:</strong> <?= htmlspecialchars($pickup['name'] ?? 'N/A') ?><br>
                                <strong>Pickup Address:</strong> <?= htmlspecialchars($pickup['address'] ?? 'N/A') ?>
                            </div>
                            <div class="pickup-meta">
                                <strong>Date:</strong> <?= htmlspecialchars($pickup['schedule'] ?? 'N/A') ?>
                            </div>
                        </div>
                        <div class="d-flex flex-column mt-3">
                            <!-- Status Form -->
                            <form method="post" action="updatePickupStatus" class="pickup-status-form">
                                <input type="hidden" name="pickup_id" value="<?= $pickup['id'] ?>">
                                <select name="status" class="form-select status-btn">
                                    <?php
                                    $statuses = ['Order Placed', 'Assigned For Pickup', 'Pending Pickup', 'Going For Pickup', 'Picked Up', 'Dropped at Store', 'Processing', 'Assigned For Delivery', 'Out For Delivery', 'Delivered', 'Cancelled'];
                                    foreach ($statuses as $status):
                                    ?>
                                        <option value="<?= $status ?>" <?= $pickup['status'] === $status ? 'selected' : '' ?>>
                                            <?= $status ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pickup-status-msg mt-2"></div>
                            </form>

                            <!-- Rider Assign Form -->
                            <form method="post" action="assign-rider" class="rider-assign-form mt-2">
                                <input type="hidden" name="pickup_id" value="<?= $pickup['id'] ?>">
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

                            <!-- See Items Button -->
                            <button type="button" class="btn btn-sm btn-outline-light mt-3 toggle-items-btn" data-pickup-id="<?= $pickup['id'] ?>">
                                See Items
                            </button>
                            <!-- Hidden Items List -->
                            <div class="pickup-items-list mt-2" style="display: none;">
                                <?php if (!empty($pickupItems)): ?>
                                    <ul class="list-group">
                                        <?php foreach ($pickupItems as $item): ?>
                                            <li class="list-group-item bg-light">
                                                <strong>Category:</strong> <?= htmlspecialchars($categoryMap[$item['category_id']] ?? 'Unknown') ?> |
                                                <strong>Service:</strong> <?= htmlspecialchars($serviceMap[$item['service_id']] ?? 'Unknown') ?> |
                                                <strong>Qty:</strong> <?= htmlspecialchars($item['quantity']) ?> |
                                                <strong>Price:</strong> ₹<?= htmlspecialchars($item['total_price']) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
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
        <div class="alert alert-info">No pickups found.</div>
    <?php endif; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // See Items Button Toggle
        document.querySelectorAll('.toggle-items-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const card = button.closest('.pickup-card');
                const itemList = card.querySelector('.pickup-items-list');
                if (itemList.style.display === 'none') {
                    itemList.style.display = 'block';
                    button.textContent = 'Hide Items';
                } else {
                    itemList.style.display = 'none';
                    button.textContent = 'See Items';
                }
            });
        });

        // Status auto-submit on change
        document.querySelectorAll('.pickup-status-form select[name="status"]').forEach(function(select) {
            select.addEventListener('change', function() {
                const form = select.closest('form');
                const formData = new FormData(form);
                const msgDiv = form.querySelector('.pickup-status-msg');

                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        msgDiv.style.display = 'block';
                        msgDiv.innerHTML = data.status === 'success' ?
                            '<div class="alert alert-success">Status updated!</div>' :
                            '<div class="alert alert-danger">Error updating status!</div>';
                        setTimeout(() => {
                            msgDiv.style.display = 'none';
                        }, 2000);
                    });
            });
        });

        // Rider assign auto-submit on change
        document.querySelectorAll('.rider-assign-form select[name="rider_id"]').forEach(function(select) {
            select.addEventListener('change', function() {
                const form = select.closest('form');
                const formData = new FormData(form);
                const msgDiv = form.querySelector('.rider-assign-msg');

                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        msgDiv.style.display = 'block';
                        msgDiv.innerHTML = data.success ?
                            '<div class="alert alert-success">Rider assigned!</div>' :
                            '<div class="alert alert-danger">Error assigning rider!</div>';
                        setTimeout(() => {
                            msgDiv.style.display = 'none';
                        }, 2000);
                    });
            });
        });
    });
</script>