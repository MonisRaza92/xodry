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
                    <?php $pageName = "Users";
                    include_once __DIR__ . '/../includes/breadcrumb.php' ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card bg-transparent border-0 mb-4">
                                <div class="card-body p-4">
                                    <h2 class="mb-4 text-white text-uppercase fw-bold">Add Subscription</h2>
                                    <form method="post" action="admin-addSubscription" class="add-subscription-form needs-validation" novalidate>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="subscriptionTitle" name="title" placeholder="Subscription Title" required>
                                                <div class="invalid-feedback">
                                                    Please enter a subscription title.
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" id="subscriptionPrice" name="price" placeholder="Subscription Price" required>
                                                <div class="invalid-feedback">
                                                    Please enter a subscription price.
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="subscriptionPoint1" name="point1" placeholder="Point 1" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="subscriptionPoint2" name="point2" placeholder="Point 2" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="subscriptionPoint3" name="point3" placeholder="Point 3" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="subscriptionPoint4" name="point4" placeholder="Point 4" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="subscriptionPoint5" name="point5" placeholder="Point 5" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="buttonText" name="button_text" placeholder="Button Text" required>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="url" class="form-control" id="buttonLink" name="button_link" placeholder="Button Link">
                                            </div>
                                        </div>
                                        <div class="d-grid mt-4">
                                            <button type="submit" class="btn btn-success btn-lg">Add Subscription</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>
                            // Bootstrap validation
                            (function() {
                                'use strict'
                                var forms = document.querySelectorAll('.needs-validation')
                                Array.prototype.slice.call(forms)
                                    .forEach(function(form) {
                                        form.addEventListener('submit', function(event) {
                                            if (!form.checkValidity()) {
                                                event.preventDefault()
                                                event.stopPropagation()
                                            }
                                            form.classList.add('was-validated')
                                        }, false)
                                    })
                            })()
                        </script>
                        <style>
                            .add-subscription-form input:focus {
                                border-color: #0d6efd;
                                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
                            }

                            @media (max-width: 767.98px) {
                                .card-body {
                                    padding: 1.5rem 0.5rem;
                                }

                                .add-subscription-form .row.g-3>[class^="col-"] {
                                    margin-bottom: 1rem;
                                }
                            }
                        </style>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center gy-4 mt-4">
                <!-- Basic Plan -->
                <?php foreach ($subscriptions as $subscription): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <div class="xodry-pricing-card">
                            <div class="pricing-icon"><i class="fas fa-tshirt"></i></div>
                            <h3 class="pricing-title"><?php echo $subscription['title']; ?></h3>
                            <div class="pricing-price">₹<?php echo $subscription['price']; ?></div>
                            <ul class="pricing-features">
                                <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point1']; ?></li>
                                <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point2']; ?></li>
                                <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point3']; ?></li>
                                <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point4']; ?></li>
                                <li><i class="fas fa-check-circle"></i> <?php echo $subscription['point5']; ?></li>
                            </ul>
                            <a href="<?php echo $subscription['button_link']; ?>" class="pricing-btn"><?php echo $subscription['button_text']; ?></a>
                            <form method="post" action="deleteSubscription" class="mt-3">
                                <input type="hidden" name="subscription_id" value="<?php echo $subscription['id']; ?>">
                                <button type="submit" class="btn btn-danger rounded-5 btn-sm" onclick="return confirm('Are you sure you want to delete this subscription?');">Delete Subscription</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . '/../includes/Footer.php' ?>
</body>

</html>

<?php include_once __DIR__ . '/../includes/Footer.php' ?>
</body>

</html>