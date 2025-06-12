<div class="container my-4">
    <?php if (!empty($pickups)): ?>
        <div class="row g-4">
            <?php foreach ($pickups as $pickup): ?>
                <div class="col-12">
                    <div class="pickup-card">
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
                        <div class="d-flex flex-column align-items-end gap-2">
                            <!-- Status Change Buttons -->
                            <form method="post" action="updatePickupStatus" class="d-flex gap-2 pickup-status-form">
                                <input type="hidden" name="pickup_id" value="<?= htmlspecialchars($pickup['id']) ?>">
                                <?php
                                $statuses = [
                                    'Order Placed',
                                    'Pending Pickup',
                                    'Picked Up',
                                    'Dropped at Store',
                                    'Processing',
                                    'Going For Delivery',
                                    'Delivered',
                                    'Cancelled'
                                ];
                                $currentStatus = $pickup['status'] ?? 'Order Placed';
                                ?>
                                <div class="mb-2">
                                    <select name="status" class="form-select status-btn">
                                        <?php foreach ($statuses as $status): ?>
                                            <option value="<?= htmlspecialchars($status) ?>" <?= $status === $currentStatus ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($status) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" style="width: 100px;">UPDATE <i class="fa-solid fa-arrow-right"></i></button>
                                <div class="pickup-status-msg mt-2" style="display:none;"></div>
                            </form>

                            <!-- Rider Assign Dropdown -->
                            <form method="post" action="assign-rider" class="d-flex gap-2 rider-assign-form">
                                <input type="hidden" name="pickup_id" value="<?= htmlspecialchars($pickup['id']) ?>">
                                <div class="mb-2">
                                    <select name="rider_id" class="form-select">
                                        <option value="">Assign Rider</option>
                                        <?php foreach ($riders as $rider): ?>
                                            <option value="<?= htmlspecialchars($rider['id']) ?>"
                                                <?= $pickup['rider_id'] == $rider['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($rider['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" style="width: 100px;">ASSIGN <i class="fa-solid fa-arrow-right"></i></button>
                                <div class="rider-assign-msg mt-2" style="display:none;"></div>
                            </form>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No pickups found.</div>
    <?php endif; ?>
</div>