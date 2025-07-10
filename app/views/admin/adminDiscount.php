<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . '/../includes/Header.php' ?>
    <title>Xodry Admin Dashboard - Affordable Laundry & Dry Cleaning in Delhi</title>
</head>

<body>
    <?php include_once __DIR__ . '/../includes/Navbar.php' ?>
    <div class="container-fluid pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 position-relative">
                    <?php include_once __DIR__ . '/partials/adminSidebar.php' ?>
                </div>
                <div class="col-lg-9">
                    <?php $pageName = "Discounts";
                    include_once __DIR__ . '/../includes/breadcrumb.php' ?>
                        <h3 class="mb-4 text-white">Discount Coupons</h3>
                    <div class="discount mt-3">
                       <div class="discount-form px-2">
                       <form method="post" action="create-discount"
                            class="row g-3 bg-light p-3 rounded mb-4 shadow-sm">
                            <div class="col-md-4">
                                <input type="text" name="code" class="form-control" placeholder="Coupon Code" required>
                            </div>
                            <div class="col-md-3">
                                <select name="type" class="form-select" required>
                                    <option value="percent">Percentage (%)</option>
                                    <option value="fixed">Fixed Amount (₹)</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="value" class="form-control" placeholder="Discount Value"
                                    min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success w-100">Create</button>
                            </div>
                        </form>
                       </div>

                        <div class="row">
                            <?php foreach ($discounts as $d): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="p-3 rounded bg-white shadow-sm border">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="mb-0 text-uppercase"><?= htmlspecialchars($d['code']) ?></h5>
                                            <span
                                                class="badge <?= $d['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                                <?= ucfirst($d['status']) ?>
                                            </span>
                                        </div>
                                        <p class="mb-1 text-muted">Type: <strong><?= ucfirst($d['type']) ?></strong></p>
                                        <p class="mb-1 text-muted">Value:
                                            <strong><?= $d['type'] === 'percent' ? $d['value'] . '%' : '₹' . $d['value'] ?></strong>
                                        </p>
                                        <p class="mb-2 text-muted">Created:
                                            <?= date('d M Y', strtotime($d['created_at'])) ?></p>

                                        <div class="d-flex gap-2">
                                            <form method="post" action="toggle-discount" class="d-inline">
                                                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                <input type="hidden" name="status"
                                                    value="<?= $d['status'] === 'active' ? 'inactive' : 'active' ?>">
                                                <button
                                                    class="btn btn-sm <?= $d['status'] === 'active' ? 'btn-warning' : 'btn-success' ?>">
                                                    <?= $d['status'] === 'active' ? 'Deactivate' : 'Activate' ?>
                                                </button>
                                            </form>

                                            <form method="post" action="delete-discount" class="d-inline"
                                                onsubmit="return confirm('Delete this coupon?')">
                                                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>





    <?php include_once __DIR__ . '/../includes/Footer.php' ?>
</body>

</html>