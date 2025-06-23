<div class="container mt-4">

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-info"><?= $_SESSION['msg'];
                                        unset($_SESSION['msg']); ?></div>
    <?php endif; ?>

    <h4 class="text-white mb-4"><i class="fas fa-motorcycle me-2"></i> Pickup Orders</h4>

    <!-- Pickup Orders -->
    <div class="row">
        <?php
        $pickups = $pickupCategory; // Same variable name — as you wanted
        if (!empty($pickups)):
            foreach ($pickups as $pickup): ?>
                <div class="col-md-6 mb-4">
                    <div class="card rounded-3 shadow-sm" style="background:var(--secondary-color);">
                        <div class="card-body text-white">
                            <h5 class="card-title"><i class="fas fa-box-open me-2 text-white"></i> Pickup ID: <?= $pickup['id'] ?></h5>
                            <p class="mb-1"><strong>Customer:</strong> <?= $pickup['name'] ?> #<?= $pickup['user_id'] ?></p>
                            <p class="mb-1"><strong>Contact:</strong> <a href="tel:<?= $pickup['number'] ?>"><?= $pickup['number'] ?></a></p>
                            <p class="mb-1"><strong>Status:</strong> <?= $pickup['status'] ?></p>
                            <p class="mb-1"><strong>Schedule:</strong> <?= $pickup['schedule'] ?></p>
                            <p class="mb-1"><strong>Address:</strong> <?= $pickup['address'] ?></p>

                            <?php
                            $currentIndex = array_search($pickup['status'], $statuses);
                            $nextIndex = $currentIndex + 1;

                            if ($nextIndex < count($statuses)) {
                                $nextStatus = $statuses[$nextIndex];
                                $cancelStatus = 'Cancelled';
                            } else {
                                $nextStatus = null;
                            }
                            ?>

                            <div class="d-flex justify-content-between mt-3">
                                <?php if ($nextStatus): ?>
                                    <?php if ($nextStatus === 'Picked Up'): ?>
                                        <button type="button" class="btn btn-success btn-sm"
                                            onclick="openPickupModal(<?= $pickup['id'] ?>)">
                                            <i class="fas fa-arrow-right me-1"></i> Move To Picked Up
                                        </button>
                                    <?php elseif ($nextStatus): ?>
                                        <form method="POST" action="changePickupStatus">
                                            <input type="hidden" name="pickup_id" value="<?= $pickup['id'] ?>">
                                            <input type="hidden" name="new_status" value="<?= $nextStatus ?>">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-arrow-right me-1"></i> Move to <?= $nextStatus ?>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Completed</span>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Completed</span>
                                <?php endif; ?>

                                <form method="POST" action="changePickupStatus">
                                    <input type="hidden" name="pickup_id" value="<?= $pickup['id'] ?>">
                                    <input type="hidden" name="new_status" value="<?= $cancelStatus ?>">
                                    <button type="submit" class="btn btn-outline-light btn-sm">
                                        <i class="fas fa-times me-1"></i> Cancel Pickup
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <p class="text-light">No Pickup Orders Found.</p>
        <?php endif; ?>
    </div>

    <!-- Delivery Orders -->
    <h4 class="text-white mb-4"><i class="fas fa-motorcycle me-2"></i> Delivery Orders</h4>
    <div class="row">
        <?php
        $pickups = $deliveryCategory; // Same variable name — as you wanted
        if (!empty($pickups)):
            foreach ($pickups as $pickup): ?>
                <div class="col-md-6 mb-4">
                    <div class="card rounded-3 shadow-sm" style="background:var(--secondary-color);">
                        <div class="card-body text-white">
                            <h5 class="card-title"><i class="fas fa-box-open me-2 text-white"></i> Pickup ID: <?= $pickup['id'] ?></h5>
                            <p class="mb-1"><strong>Customer:</strong> <?= $pickup['name'] ?> #<?= $pickup['user_id'] ?></p>
                            <p class="mb-1"><strong>Contact:</strong><a href="tel:<?= $pickup['number'] ?>"><?= $pickup['number'] ?></a></p>
                            <p class="mb-1"><strong>Status:</strong> <?= $pickup['status'] ?></p>
                            <p class="mb-1"><strong>Schedule:</strong> <?= $pickup['schedule'] ?></p>
                            <p class="mb-1"><strong>Address:</strong> <?= $pickup['address'] ?></p>

                            <?php
                            $currentIndex = array_search($pickup['status'], $statuses);
                            $nextIndex = $currentIndex + 1;

                            if ($nextIndex < count($statuses)) {
                                $nextStatus = $statuses[$nextIndex];
                                $cancelStatus = 'Cancelled';
                            } else {
                                $nextStatus = null;
                            }
                            ?>

                            <div class="d-flex justify-content-between mt-3">
                                <?php if ($nextStatus): ?>
                                    <form method="POST" action="changePickupStatus">
                                        <input type="hidden" name="pickup_id" value="<?= $pickup['id'] ?>">
                                        <input type="hidden" name="new_status" value="<?= $nextStatus ?>">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-arrow-right me-1"></i> Move to <?= $nextStatus ?>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Completed</span>
                                <?php endif; ?>

                                <form method="POST" action="changePickupStatus">
                                    <input type="hidden" name="pickup_id" value="<?= $pickup['id'] ?>">
                                    <input type="hidden" name="new_status" value="<?= $cancelStatus ?>">
                                    <button type="submit" class="btn btn-outline-light btn-sm">
                                        <i class="fas fa-times me-1"></i> Cancel Delivery
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <p class="text-light">No Delivery Orders Found.</p>
        <?php endif; ?>
    </div>

</div>
<?php include __DIR__ . '/pickupDetails.php' ?>
<script>
    function openPickupModal(pickupId) {
        document.getElementById('modalPickupId').value = pickupId;
        var myModal = new bootstrap.Modal(document.getElementById('pickupModal'));
        myModal.show();
    }
</script>