    <div class="list-group px-0">
        <?php foreach ($pickupList as $pickup): ?>
            <a href="#"
                class="list-group-item list-group-item-action border mb-2 d-flex justify-content-between align-items-center view-details-btn"
                data-bs-toggle="modal"
                data-bs-target="#pickupModal"
                data-id="<?= htmlspecialchars($pickup['id']) ?>"
                data-schedule="<?= htmlspecialchars($pickup['schedule']) ?>"
                data-address="<?= htmlspecialchars($pickup['address']) ?>"
                data-status="<?= htmlspecialchars($pickup['status']) ?>">

                <div class="d-flex align-items-center px-0">
                    <i class="fas fa-shirt text-muted me-3 fa-lg"></i>
                    <div>
                        <small class="fw-bold d-block"><?= htmlspecialchars($pickup['schedule'] ?? 'N/A') ?></small>
                    </div>
                </div>
                <i class="fas fa-angle-right text-secondary"></i>
            </a>
        <?php endforeach; ?>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pickupModal = document.getElementById('pickupModal');
        pickupModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            // Get data attributes from clicked button
            const schedule = button.getAttribute('data-schedule');
            const address = button.getAttribute('data-address');
            const status = button.getAttribute('data-status');
            const id = button.getAttribute('data-id');

            // Populate Modal
            document.getElementById('modalSchedule').textContent = schedule;
            document.getElementById('modalAddress').textContent = address;
            document.getElementById('modalStatus').textContent = status;

            // Handle Cancel Button
            document.getElementById('cancelPickupBtn').onsubmit = function() {
                if (confirm("Are you sure to cancel this pickup?")) {
                    window.location.href = '?url=cancelPickup';
                }
            }
        });
    });
</script>