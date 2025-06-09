<div class="admin-stats mt-4">
    <div class="row">
        <?php include  __DIR__ . '/../components/statsCards.php'  ?>
        <?php include  __DIR__ . '/../components/statsCards.php'  ?>
        <?php include  __DIR__ . '/../components/statsCards.php'  ?>
        <?php include  __DIR__ . '/../components/statsCards.php'  ?>
    </div>
    <canvas class="rounded mt-4 my-chart" id="myChart"></canvas>
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="recent-users-container rounded">
                <div class="recent-users-heading py-0">
                    <h5 class="mb-0">RECENT USERS</h5>
                    <a href="users" class=" text-uppercase small fw-bold">show all users <i class="ms-1 fa-solid fa-arrow-right"></i></a>
                </div>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>
                <?php include __DIR__ . '/../components/recentUserList.php' ?>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="short-list-riders rounded">
                <div class="short-riders-list-heading py-0">
                    <h5 class="mb-0">RIDERS</h5>
                    <a href="users" class=" text-uppercase small fw-bold">show all <i class="ms-1 fa-solid fa-arrow-right"></i></a>
                </div>
                <?php include __DIR__ . '/../components/shortRidersList.php' ?>
                <?php include __DIR__ . '/../components/shortRidersList.php' ?>
                <?php include __DIR__ . '/../components/shortRidersList.php' ?>
                <?php include __DIR__ . '/../components/shortRidersList.php' ?>
                <?php include __DIR__ . '/../components/shortRidersList.php' ?>
            </div>
        </div>
    </div>
</div>