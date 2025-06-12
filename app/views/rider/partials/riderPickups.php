<div class="container">
    <h3 class="mt-4 text-light fw-bold">Assigned Pickups</h3>

    <?php if (!empty($pickups)): ?>
        <div class="row g-4">
            <?php foreach ($pickups as $pickup): ?>
                <div class="col-12">
                    <div style="background-color: var(--secondary-color); border: 1px solid var(--accent-color); border-radius: 5px; padding: 15px; color: var(--light-color);">
                        <h5>Order #<?= htmlspecialchars($pickup['id']) ?></h5>
                        <p><strong>Customer:</strong> <?= htmlspecialchars($pickup['name'] ?? 'N/A') ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($pickup['address'] ?? 'N/A') ?></p>
                        <p><strong>Schedule:</strong> <?= htmlspecialchars($pickup['schedule'] ?? 'N/A') ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($pickup['status']) ?></p>

                        <!-- Status Change Form -->
                        <form method="post" action="updatePickupStatus" class="d-flex gap-2 pickup-status-form-rider">
                            <input type="hidden" name="pickup_id" value="<?= htmlspecialchars($pickup['id']) ?>">
                            <?php
                            $statuses = [
                                'Pending Pickup',
                                'Picked Up',
                                'Dropped at Store',
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
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-3">No assigned pickups found.</div>
    <?php endif; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.pickup-status-form-rider').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status updated successfully!');
                            window.location.href= 'rider'; // Redirect to the same page to refresh the list
                        } else {
                            alert(data.message || 'Failed to update status.');
                            window.location.href= 'rider'; // Redirect to the same page to refresh the list
                        }
                    })
                    .catch(() => {
                        alert('An error occurred. Please try again.');
                    });
            });
        });
    });
</script>