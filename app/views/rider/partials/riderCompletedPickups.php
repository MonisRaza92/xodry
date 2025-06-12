<div class="container">
    <h3 class="mt-5 text-light fw-bold">Completed Pickups</h3>

    <?php if (!empty($completedPickups)): ?>
        <div class="row g-4">
            <?php foreach ($completedPickups as $pickup): ?>
                <div class="col-12">
                    <div style="background-color: var(--secondary-color); border: 1px solid var(--accent-color); border-radius: 5px; padding: 15px; color: var(--light-color);">
                        <h5>Order #<?= htmlspecialchars($pickup['id']) ?> — Completed</h5>
                        <p><strong>Customer:</strong> <?= htmlspecialchars($pickup['name'] ?? 'N/A') ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($pickup['address'] ?? 'N/A') ?></p>
                        <p><strong>Schedule:</strong> <?= htmlspecialchars($pickup['schedule'] ?? 'N/A') ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($pickup['status']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-3">No completed pickups yet.</div>
    <?php endif; ?>
</div>