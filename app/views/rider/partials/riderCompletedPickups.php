<div class="container mt-5">
    <h3 class="text-white mb-3"><i class="fas fa-list me-2"></i> Pickups History</h3>
    <?php if (empty($history)): ?>
        <div class="alert alert-warning">No history found.</div>
    <?php else: ?>

        <!-- Dropped at Store Category -->
        <h5 class="text-white mt-4 mb-3"><i class="fas fa-store me-2" style="color: #fcba03;"></i> Dropped at Store</h5>
        <div class="list-group mb-4">
            <?php foreach ($history as $log): ?>
                <?php if ($log['status'] === 'Dropped at Store'): ?>
                    <div class="list-group-item mb-2 rounded-2" style="background: var(--secondary-color); color: white;">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><i class="fas fa-box me-2"></i> Pickup ID: <?= htmlspecialchars($log['pickup_id']) ?></h6>
                                <p class="mb-0"><strong>Stage:</strong> <?= htmlspecialchars($log['stage']) ?></p>
                                <p class="mb-0"><strong>Status:</strong> <?= htmlspecialchars($log['status']) ?></p>
                                <p class="mb-0"><strong>Time:</strong> <?= htmlspecialchars($log['timestamp']) ?></p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-store fa-2x" style="color: #fcba03;"></i>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Delivered Category -->
        <h5 class="text-white mt-4 mb-3"><i class="fas fa-check-circle me-2" style="color: #04c70e;"></i> Delivered</h5>
        <div class="list-group mb-4">
            <?php foreach ($history as $log): ?>
                <?php if ($log['status'] === 'Delivered'): ?>
                    <div class="list-group-item mb-2 rounded-2" style="background: var(--secondary-color); color: white;">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><i class="fas fa-box me-2"></i> Pickup ID: <?= htmlspecialchars($log['pickup_id']) ?></h6>
                                <p class="mb-0"><strong>Stage:</strong> <?= htmlspecialchars($log['stage']) ?></p>
                                <p class="mb-0"><strong>Status:</strong> <?= htmlspecialchars($log['status']) ?></p>
                                <p class="mb-0"><strong>Time:</strong> <?= htmlspecialchars($log['timestamp']) ?></p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-check-circle fa-2x" style="color: #04c70e;"></i>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Cancelled Category -->
        <h5 class="text-white mt-4 mb-3"><i class="fas fa-times-circle me-2" style="color: #fc2121;"></i> Cancelled</h5>
        <div class="list-group">
            <?php foreach ($history as $log): ?>
                <?php if ($log['status'] === 'Cancelled'): ?>
                    <div class="list-group-item mb-2 rounded-2" style="background: var(--secondary-color); color: white;">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><i class="fas fa-box me-2"></i> Pickup ID: <?= htmlspecialchars($log['pickup_id']) ?></h6>
                                <p class="mb-0"><strong>Stage:</strong> <?= htmlspecialchars($log['stage']) ?></p>
                                <p class="mb-0"><strong>Status:</strong> <?= htmlspecialchars($log['status']) ?></p>
                                <p class="mb-0"><strong>Time:</strong> <?= htmlspecialchars($log['timestamp']) ?></p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-times-circle fa-2x" style="color: #fc2121;"></i>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>