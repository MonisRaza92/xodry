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
                    <?php $pageName = "Settings";
                    include_once __DIR__ . '/../includes/breadcrumb.php' ?>
                    <h2 class="text-white mt-3">Add New Slider Image</h2>
                    <form action="add-slider-image" method="POST" enctype="multipart/form-data" class="mb-4">
                        <div class="input-group">
                            <input type="file" name="image" id="image" class="form-control" required>
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </form>
                    <h2 class="text-white">Slider Images</h2>
                    <div class="row">
                        <?php foreach ($images as $img): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <img src="<?php echo $img['image_url']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <a href="delete-slider-image?id=<?php echo $img['id']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this image?');">
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    
                    <h2 class="text-white mt-3">Add Compare Images</h2>
                    <form action="add-compare-image" method="POST" enctype="multipart/form-data" class="mb-4">
                        <div class="input-group">
                            <input type="file" name="before_image" id="image" class="form-control" required>
                            <input type="file" name="after_image" id="image" class="form-control" required>
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </form>
                    <h2 class="text-white">Slider Images</h2>
                    <div class="row">
                        <?php foreach ($compare as $img): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <img src="<?php echo $img['before_image']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <img src="<?php echo $img['after_image']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <a href="delete-compare-image?id=<?php echo $img['id']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this image?');">
                                            Delete
                                        </a>
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