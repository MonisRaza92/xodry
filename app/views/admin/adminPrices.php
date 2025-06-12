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
                    <?php $pageName = "Prices";
                    include_once __DIR__ . '/../includes/breadcrumb.php' ?>
                    <div class="card my-4 custom-add-service-card">
                        <div class="custom-card-header">
                            Add New Service
                        </div>
                        <div class="custom-card-body">
                            <form method="post" action="admin-addServices" class="row g-3">
                                <div class="col-12">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="" disabled selected>Select Category</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="service_name" class="form-label">Service Name</label>
                                    <input type="text" name="service_name" id="service_name" class="form-control" placeholder="Service Name" required>
                                </div>
                                <div class="col-12">
                                    <label for="price" class="form-label">Price (₹)</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="Price" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="default-btn mb-2 mt-3 fs-4 w-100">ADD new price</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                <div class="custom-services-container container">
                    <?php
                    $grouped = [];
                    foreach ($services as $service) {
                        $grouped[$service['category_name']][] = $service;
                    }
                    ?>
                    <?php if (!empty($grouped)): ?>
                        <?php foreach ($grouped as $category => $serviceList): ?>
                            <div class="custom-service-card">
                                <div class="custom-service-card-header">
                                    <h5><?= htmlspecialchars($category) ?></h5>
                                </div>
                                <div class="custom-service-card-body">
                                    <table class="custom-service-table">
                                        <thead>
                                            <tr>
                                                <th>Service Name</th>
                                                <th>Price (₹)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($serviceList as $srv): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($srv['service_name']) ?></td>
                                                    <td>₹<?= number_format($srv['price'], 2) ?></td>
                                                    <td>
                                                        <form method="post" action="delete-price" onsubmit="return confirm('Are you sure you want to delete this service?');" style="display:inline;">
                                                            <input type="hidden" name="service_id" value="<?= (int)$srv['id'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No services found.</p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>





    <?php include_once __DIR__ . '/../includes/Footer.php' ?>
</body>

</html>