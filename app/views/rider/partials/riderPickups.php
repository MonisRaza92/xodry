<div class="container-fluid">
<div class="container mt-4">

<?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-info"><?= $_SESSION['msg'];
        unset($_SESSION['msg']); ?></div>
<?php endif; ?>

<!-- Pill Tabs -->
<ul class="nav nav-pills mb-3" id="pickupTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pickup-tab" data-bs-toggle="tab" data-bs-target="#pickups" type="button" role="tab">Pickups</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="delivery-tab" data-bs-toggle="tab" data-bs-target="#deliveries" type="button" role="tab">Deliveries</button>
    </li>
</ul>

<!-- Tab Contents -->
<div class="tab-content" id="pickupTabsContent">

    <!-- ✅ Pickup Orders Tab -->
    <div class="tab-pane fade show active" id="pickups" role="tabpanel">
        <div class="row">
            <?php
            $pickups = $pickupCategory;
            if (!empty($pickups)):
                foreach ($pickups as $pickup): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card rounded-3 shadow-sm" style="background:var(--secondary-color); border: 2px solid var(--accent-color);">
                                            <div class="card-body text-white">
                                                <h5 class="card-title"><i class="fas fa-box-open me-2 text-white"></i> Pickup ID: <?= $pickup['id'] ?></h5>
                                                <p class="mb-1"><strong>Customer:</strong> <?= $pickup['name'] ?> #<?= $pickup['user_id'] ?></p>
                                                <p class="mb-1"><strong>Contact:</strong> <a href="tel:<?= $pickup['number'] ?>"><?= $pickup['number'] ?></a></p>
                                                <p class="mb-1"><strong>Status:</strong> <?= $pickup['status'] ?></p>
                                                <p class="mb-1"><strong>Pickup Date:</strong> <?= $pickup['schedule'] ?></p>
                                                <p class="mb-1"><strong>Pickup Time:</strong> <?= $pickup['pickup_time'] ?></p>
                                                <p class="mb-1"><strong>Address:</strong> <?= $pickup['address'] ?></p>

                                                <?php
                                                $currentIndex = array_search($pickup['status'], $statuses);
                                                $nextIndex = $currentIndex + 1;
                                                $nextStatus = $nextIndex < count($statuses) ? $statuses[$nextIndex] : null;
                                                $cancelStatus = 'Cancelled';
                                                ?>

                                                <div class="d-flex justify-content-between mt-3">
                                                    <?php if ($nextStatus): ?>
                                                                <?php if ($nextStatus === 'Picked Up'): ?>
                                                                            <button type="button" class="btn btn-success btn-sm"
                                                                                onclick="openPickupModal(<?= $pickup['id'] ?>)">
                                                                                <i class="fas fa-arrow-right me-1"></i> Move To Picked Up
                                                                            </button>
                                                                <?php else: ?>
                                                                            <form method="POST" action="changePickupStatus">
                                                                                <input type="hidden" name="pickup_id" value="<?= $pickup['id'] ?>">
                                                                                <input type="hidden" name="new_status" value="<?= $nextStatus ?>">
                                                                                <button type="submit" class="btn btn-success btn-sm">
                                                                                    <i class="fas fa-arrow-right me-1"></i> Move to <?= $nextStatus ?>
                                                                                </button>
                                                                            </form>
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
    </div>

    <!-- ✅ Delivery Orders Tab -->
    <div class="tab-pane fade" id="deliveries" role="tabpanel">
        <div class="row">
            <?php
            $pickups = $deliveryCategory;
            if (!empty($pickups)):
                foreach ($pickups as $pickup): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card rounded-3 shadow-sm" style="background:var(--secondary-color);">
                                            <div class="card-body text-white">
                                                <h5 class="card-title"><i class="fas fa-box-open me-2 text-white"></i> Delivery ID: <?= $pickup['id'] ?></h5>
                                                <p class="mb-1"><strong>Customer:</strong> <?= $pickup['name'] ?> #<?= $pickup['user_id'] ?></p>
                                                <p class="mb-1"><strong>Contact:</strong><a href="tel:<?= $pickup['number'] ?>"><?= $pickup['number'] ?></a></p>
                                                <p class="mb-1"><strong>Status:</strong> <?= $pickup['status'] ?></p>
                                                <p class="mb-1"><strong>Address:</strong> <?= $pickup['address'] ?></p>

                                                <?php
                                                $currentIndex = array_search($pickup['status'], $statuses);
                                                $nextIndex = $currentIndex + 1;
                                                $nextStatus = $nextIndex < count($statuses) ? $statuses[$nextIndex] : null;
                                                $cancelStatus = 'Cancelled';
                                                ?>

                                                <div class="d-flex justify-content-between mt-3">
                                                    <?php if ($nextStatus): ?>
                                                                <form method="POST" action="changePickupStatus">
                                                                    <input type="hidden" name="pickup_id" value="<?= $pickup['id'] ?>">
                                                                    <input type="hidden" name="new_status" value="<?= $nextStatus ?>">
                                                                    <button type="submit" class="btn btn-light btn-sm">
                                                                        <i class="fas fa-arrow-right me-1"></i> Move to <?= $nextStatus ?>
                                                                    </button>
                                                                </form>
                                                    <?php else: ?>
                                                                <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Completed</span>
                                                    <?php endif; ?>
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

</div>

</div>
</div>

<?php include __DIR__ . '/pickupDetails.php' ?>

<script>
    function openPickupModal(pickupId) {
        document.getElementById('modalPickupId').value = pickupId;
        var myModal = new bootstrap.Modal(document.getElementById('pickupModal'));
        myModal.show();
    }

    
    document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll('#pickupTabs button[data-bs-toggle="tab"]');

    // Restore previously active tab
    const activeTabId = localStorage.getItem('activePickupTab');
    if (activeTabId) {
        const trigger = document.querySelector(`#pickupTabs button[data-bs-target="${activeTabId}"]`);
        if (trigger) {
            const tab = new bootstrap.Tab(trigger);
            tab.show();
        }
    }

    // Save active tab on click
    tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (event) {
            localStorage.setItem('activePickupTab', event.target.getAttribute('data-bs-target'));
        });
    });
});
</script>
