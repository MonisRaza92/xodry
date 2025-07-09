<div class="container-fluid">
    <div class="container">
        <h4 class="mb-4 text-white"><i style="color: var(--main-color);"  class="fas fa-chart-line me-2"></i> Rider History Overview</h4>
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card text-white" style="background: var(--secondary-color);">
                    <div class="card-body">
                        <h5 class="card-title"><i style="color: var(--main-color);" class="fas fa-calendar-day me-2"></i> Today's Pickups</h5>
                        <p class="fs-4"><?= $stats['pickups'] ?? 0 ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card text-white" style="background: var(--secondary-color);">
                    <div class="card-body">
                        <h5 class="card-title"><i style="color: var(--main-color);" class="fas fa-calendar-alt me-2"></i> Today's Deliveries</h5>
                        <p class="fs-4"><?= $stats['delivery'] ?? 0 ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card text-white" style="background: var(--secondary-color);">
                    <div class="card-body">
                        <h5 class="card-title"><i style="color: var(--main-color);" class="fas fa-calendar-alt me-2"></i> Today's Cancelled</h5>
                        <p class="fs-4"><?= $stats['cancelled'] ?? 0 ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card text-white" style="background: var(--secondary-color);">
                    <div class="card-body">
                        <h5 class="card-title"><i style="color: var(--main-color);" class="fas fa-history me-2"></i> Total History Records</h5>
                        <p class="fs-4"><?= count($history) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>