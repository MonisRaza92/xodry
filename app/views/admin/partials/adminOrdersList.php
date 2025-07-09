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
    <li class="nav-item mb-2"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pickups">Pickups</button>
    </li>
    <li class="nav-item mb-2"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#on_store">On Store</button></li>
    <li class="nav-item mb-2"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivery">Delivery</button></li>
    <li class="nav-item mb-2"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivered">Delivered</button>
    </li>
    <li class="nav-item mb-2"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancelled">Cancelled</button>
    </li>
</ul>
<!-- ✅ Tab Content -->
<div class="tab-content">
    <?php foreach ($groupedPickups as $tabId => $tabPickups): ?>
        <div class="tab-pane fade <?= $tabId === 'pickups' ? 'show active' : '' ?>" id="<?= $tabId ?>">
            <?php if (!empty($tabPickups)): ?>
                <div class="row g-2">
                    <?php foreach ($tabPickups as $pickup): ?>
                        <?php
                        $items = $pickupItemMap[$pickup['id']] ?? [];
                        $grouped = [];
                        $totalPrice = 0;
                        foreach ($items as $item) {
                            $grouped[$item['category_id']][] = $item;
                            $totalPrice += $item['total_price'];
                        }
                        ?>
                        <div class="col-12">
                            <div class="pickup-card" style="position: relative;">
                                <div class="flex-grow-1">
                                    <div class="pickup-header">
                                        <i class="bi bi-truck"></i> Order #<?= htmlspecialchars($pickup['id']) ?>
                                    </div>
                                    <div class="pickup-details">
                                        <strong>Customer:</strong> <?= htmlspecialchars($pickup['name'] ?? 'N/A') ?>
                                        #<?= htmlspecialchars($pickup['user_id'] ?? 'N/A') ?><br>
                                        <strong>Phone:</strong> <a
                                            href="tel:<?= htmlspecialchars($pickup['number'] ?? 'N/A') ?>"><?= htmlspecialchars($pickup['number'] ?? 'N/A') ?></a><br>
                                        <strong>Pickup Address:</strong> <?= htmlspecialchars($pickup['address'] ?? 'N/A') ?>
                                    </div>
                                    <div class="pickup-meta">
                                        <strong>Pickup Date:</strong> <?= htmlspecialchars($pickup['schedule'] ?? 'N/A') ?> &nbsp;
                                        <strong>Pickup Time:</strong> <?= htmlspecialchars($pickup['pickup_time'] ?? 'N/A') ?>
                                    </div>
                                    <div class="total-price <?php echo ($pickup['status'] != 'Delivered')? 'd-none' : ''; ?>">
                                    <?php if (!empty($grouped)): ?>
                                            <?php foreach ($grouped as $catId => $services): ?>
                                                    <div class="mb-2">
                                                        <ul class="list-group mb-2">
                                                            <?php foreach ($services as $srv): ?>
                                                                    <li class="list-group-item d-none">
                                                                        <strong>Total Price:</strong> ₹<?= htmlspecialchars($srv['total_price']) ?>
                                                                    </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                            <?php endforeach; ?>
                                            <div class="text-end fw-bold bg-white text-dark p-2 rounded">
                                                Total Amount: ₹<?= $totalPrice ?>
                                            </div>
                                    <?php else: ?>
                                            <div class="alert alert-info mt-2">No items found.</div>
                                    <?php endif; ?>
                                    </div>
                                </div>

                               <div class="actions <?php echo ($pickup['status'] == 'Delivered' || $pickup['status'] == 'Cancelled') ? 'd-none' : ''; ?>">
                                 <!-- Status Form -->
                                 <form method="post" action="updatePickupStatus" class="pickup-status-form mt-3">
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
                                
                                <!-- See Items -->
                                <button type="button" class="btn btn-sm w-100 btn-outline-light mt-3 toggle-items-btn"
                                    data-pickup-id="<?= $pickup['id'] ?>">See Items</button>
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
                                                            <strong>Price:</strong> ₹<?= htmlspecialchars($srv['total_price']) ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="text-end fw-bold bg-success text-white p-2 rounded">
                                            Total Amount: ₹<?= $totalPrice ?>
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

<!-- ✅ Script for Tab Items -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle items
        document.querySelectorAll('.toggle-items-btn').forEach(button => {
            button.addEventListener('click', () => {
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
