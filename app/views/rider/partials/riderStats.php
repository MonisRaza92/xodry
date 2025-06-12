<div class="container-fluid">
    <div class="container">

        <div class="row my-4">
            <div class="col-md-4">
                <div class="card rider-stats-card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Assigned Pickups</h5>
                        <p class="card-text fs-4"><?= $stats['assigned'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rider-stats-card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Completed Pickups</h5>
                        <p class="card-text fs-4"><?= $stats['completed'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rider-stats-card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pending Pickups</h5>
                        <p class="card-text fs-4"><?= $stats['today'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .rider-stats-card {
        background-color: var(--secondary-color);
        border: 1px solid var(--accent-color);
        border-radius: 5px;
        color: var(--light-color);
    }
</style>