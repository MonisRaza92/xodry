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
                        <div class="custom-card-header text-white">
                            Add New Price
                        </div>
                        <div class="custom-card-body">
                            <form method="post" action="admin-addServices" class="row g-3 text-white">
                                <div class="col-12 text-white">
                                    <label for="category_id" class="form-label">Service</label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="" disabled selected>Select Service</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="service_name" class="form-label">Item Name</label>
                                    <input type="text" name="service_name" id="service_name" class="form-control"
                                        placeholder="Item Name" required>
                                </div>
                                <div class="col-12">
                                    <label for="price" class="form-label">Price (₹)</label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control"
                                        placeholder="Price" required>
                                </div>
                                <div class="col-12">
                                    <label for="visibility" class="form-label">Add visibility</label>
                                    <select name="visibility" id="visibility" class="form-control">
                                        <option value="" selected>Select Visibility</option>
                                        <option value="for riders">For Riders</option>
                                        <option value="for users">For Users</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="default-btn mb-2 mt-3 fs-4 w-100">ADD new
                                        price</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                <div class="custom-services-container container">
                    <?php
                    $grouped = [];
                    foreach ($servicesByCategory as $service) {
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
                                                <th class="text-white">Service</th>
                                                <th class="text-white">Price (₹)</th>
                                                <th class="text-white">Action</th>
                                                <th class="text-white">Visible</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($serviceList as $srv): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($srv['service_name']) ?></td>
                                                    <td>₹<?= number_format($srv['price'], 2) ?></td>
                                                    <td><?= htmlspecialchars($srv['visibility']) ?></td>
                                                    <td>
                                                        <form method="post" action="delete-price"
                                                            onsubmit="return confirm('Are you sure you want to delete this service?');"
                                                            style="display:inline;">
                                                            <input type="hidden" name="service_id" value="<?= (int) $srv['id'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                        <!-- Update Button to trigger modal -->
                                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                            data-bs-target="#updateServiceModal" data-id="<?= (int) $srv['id'] ?>"
                                                            data-category="<?= (int) $srv['category_id'] ?>"
                                                            data-name="<?= htmlspecialchars($srv['service_name']) ?>"
                                                            data-price="<?= htmlspecialchars($srv['price']) ?>"
                                                            data-visibility="<?= htmlspecialchars($srv['visibility']) ?>">
                                                            Update
                                                        </button>
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
                    <!-- Update Modal -->
                    <div class="modal fade" id="updateServiceModal" tabindex="-1"
                        aria-labelledby="updateServiceModalLabel" aria-hidden="true">
                        <div class="modal-dialog my-5 py-5">
                            <form method="post" action="update-price" class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateServiceModalLabel">Update Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <input type="hidden" name="service_id" id="update-service-id">
                                    <input type="hidden" name="category_id" id="update-category-id">

                                    <div class="mb-3">
                                        <label for="update-service-name" class="form-label">Service Name</label>
                                        <input type="text" class="form-control" name="service_name"
                                            id="update-service-name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="update-price" class="form-label">Price (₹)</label>
                                        <input type="number" step="0.01" class="form-control" name="price"
                                            id="update-price" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="update-visibility" class="form-label">Visibility</label>
                                        <select class="form-select" name="visibility" id="update-visibility">
                                            <option value="" selected>Select Visibility</option>
                                            <option value="for riders">For Riders</option>
                                            <option value="for users">For Users</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Service</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>





    <?php include_once __DIR__ . '/../includes/Footer.php' ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const updateModal = document.getElementById('updateServiceModal');
            updateModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                document.getElementById('update-service-id').value = button.getAttribute('data-id');
                document.getElementById('update-category-id').value = button.getAttribute('data-category');
                document.getElementById('update-service-name').value = button.getAttribute('data-name');
                document.getElementById('update-price').value = button.getAttribute('data-price');
                document.getElementById('update-visibility').value = button.getAttribute('data-visibility');
            });
        });
    </script>

</body>

</html>