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
                    <?php $pageName = "Services";
                    include_once __DIR__ . '/../includes/breadcrumb.php' ?>
                    <form method="post" action="admin-addCategory" enctype="multipart/form-data" class=" py-4 mt-2 shadow-sm add-category-form">
                        <!-- Image at Top -->
                        <div class="mb-3">
                            <input type="file" class="form-control" id="categoryImage" name="image" accept="image/*" required>
                        </div>

                        <!-- Category Name -->
                        <div class="mb-3">
                            <input type="text" class="form-control" id="categoryName" name="category_name" placeholder="Category Name" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <textarea class="form-control" id="categoryDescription" name="description" placeholder="Description" rows="3"></textarea>
                        </div>

                        <!-- Bullet Points -->
                        <div class="mb-3">
                            <label class="form-label">Bullet Points</label>
                            <input type="text" class="form-control mb-2" name="bullet_point_1" placeholder="Bullet Point 1">
                            <input type="text" class="form-control mb-2" name="bullet_point_2" placeholder="Bullet Point 2">
                            <input type="text" class="form-control mb-2" name="bullet_point_3" placeholder="Bullet Point 3">
                            <input type="text" class="form-control mb-2" name="bullet_point_4" placeholder="Bullet Point 4">
                            <input type="text" class="form-control" name="bullet_point_5" placeholder="Bullet Point 5">
                        </div>

                        <button type="submit" class="default-btn fs-5 w-100">Add new service</button>
                    </form>



                </div>
                <div class="col-lg-12 mt-4">
                    <h2 class="mb-4">Existing Services</h2>
                    <div class="row">
                        <?php foreach ($categories as $cat) : ?>
                            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
                                <div class="xodry-whatwedo-card p-0 rounded h-100">
                                    <img src="<?= htmlspecialchars((!empty($cat['image']) ? $cat['image'] : '/assets/images/Hero/hero-img.png')) ?>" alt="<?= htmlspecialchars($cat['category_name'] ?? '') ?>" class="mb-3 img-fluid">
                                    <div class="service-card-content p-4">
                                        <h4 class="xodry-whatwedo-card-title"><?= htmlspecialchars($cat['category_name'] ?? '') ?></h4>
                                        <p class="xodry-whatwedo-card-text"><?= htmlspecialchars($cat['description'] ?? '') ?></p>
                                        <ul>
                                            <?php if (!empty($cat['bullet_point_1'])) : ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_1'] ?? '') ?></li><?php endif; ?>
                                            <?php if (!empty($cat['bullet_point_2'])) : ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_2'] ?? '') ?></li><?php endif; ?>
                                            <?php if (!empty($cat['bullet_point_3'])) : ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_3'] ?? '') ?></li><?php endif; ?>
                                            <?php if (!empty($cat['bullet_point_4'])) : ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_4'] ?? '') ?></li><?php endif; ?>
                                            <?php if (!empty($cat['bullet_point_5'])) : ?><li><i class="fa-regular fa-circle-check"></i> &nbsp;<?= htmlspecialchars($cat['bullet_point_5'] ?? '') ?></li><?php endif; ?>
                                        </ul>
                                        <form class="mt-4" method="post" action="delete-service" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                            <input type="hidden" name="category_id" value="<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>">
                                            <button type="submit" class="btn btn-danger btn-sm mt-2 w-100">Delete</button>
                                            <button type="button" class="btn btn-primary btn-sm mt-2 w-100" data-bs-toggle="modal" data-bs-target="#updateServiceModal<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Update Category Modal -->
                            <div class="modal fade mt-5 py-2" id="updateServiceModal<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" tabindex="-1" aria-labelledby="updateServiceModalLabel<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="background: var(--secondary-color);">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateServiceModalLabel<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>">Update Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="admin-updateCategory" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" name="category_id" value="<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>">
                                                <div class="mb-3">
                                                    <label for="updateCategoryImage<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" class="form-label">Category Image</label>
                                                    <input type="file" class="form-control" id="updateCategoryImage<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" name="image" accept="image/*">
                                                    <input type="hidden" id="existing_image<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" name="existing_image" value="<?= htmlspecialchars($cat['image'] ?? '') ?>">
                                                    <small>Current: <img src="<?= htmlspecialchars((!empty($cat['image']) ? $cat['image'] : '/assets/images/Hero/hero-img.png')) ?>" alt="Current Image" style="max-width: 60px; max-height: 60px;"></small>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateCategoryName<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" class="form-label">Category Name</label>
                                                    <input type="text" class="form-control" id="updateCategoryName<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" name="category_name" value="<?= htmlspecialchars($cat['category_name'] ?? '') ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="updateCategoryDescription<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" class="form-label">Description</label>
                                                    <textarea class="form-control" id="updateCategoryDescription<?= array_key_exists('id', $cat) ? htmlspecialchars($cat['id']) : '' ?>" name="description" rows="3"><?= htmlspecialchars($cat['description'] ?? '') ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Bullet Points</label>
                                                    <input type="text" class="form-control mb-2" name="bullet_point_1" placeholder="Bullet Point 1" value="<?= htmlspecialchars($cat['bullet_point_1'] ?? '') ?>">
                                                    <input type="text" class="form-control mb-2" name="bullet_point_2" placeholder="Bullet Point 2" value="<?= htmlspecialchars($cat['bullet_point_2'] ?? '') ?>">
                                                    <input type="text" class="form-control mb-2" name="bullet_point_3" placeholder="Bullet Point 3" value="<?= htmlspecialchars($cat['bullet_point_3'] ?? '') ?>">
                                                    <input type="text" class="form-control mb-2" name="bullet_point_4" placeholder="Bullet Point 4" value="<?= htmlspecialchars($cat['bullet_point_4'] ?? '') ?>">
                                                    <input type="text" class="form-control" name="bullet_point_5" placeholder="Bullet Point 5" value="<?= htmlspecialchars($cat['bullet_point_5'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Update Category</button>
                                            </div>
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





    <?php include_once __DIR__ . '/../includes/Footer.php' ?>
</body>

</html>