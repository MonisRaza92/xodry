<section id="adminSidebar" class="admin-sidebar rounded">
    <ul class="side-menu w-100">
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin' ? 'active-li' : '' ?> mt-3">
            <a href="admin"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
        </li>
        <div class="divider-text">Main</div>
        <div class="divider"></div>
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin-users' ? 'active-li' : '' ?>"><a href="admin-users"><i class="fa-solid fa-users"></i> Users</a></li>
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin-riders' ? 'active-li' : '' ?>"><a href="admin-riders"><i class="fa-solid fa-users-gear"></i> Riders</a></li>
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin-orders' ? 'active-li' : '' ?>"><a href="admin-orders"><i class="fa-solid fa-table-list"></i> Orders</a></li>
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin-services' ? 'active-li' : '' ?>"><a href="admin-services"><i class="fa-solid fa-sliders"></i> Services</a></li>
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin-prices' ? 'active-li' : '' ?>"><a href="admin-prices"><i class="fa-solid fa-wallet"></i> Prices</a></li>
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin-subscriptions' ? 'active-li' : '' ?>"><a href="admin-subscriptions"><i class="fa-solid fa-money-bill-transfer"></i> Subscriptions</a></li>
        <div class="divider-text">Extra</div>
        <div class="divider"></div>
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin-feedbacks' ? 'active-li' : '' ?>"><a href="admin-feedbacks"><i class="fa-solid fa-comments"></i> Feedbacks</a></li>
        <li class="<?php echo basename($_SERVER['REQUEST_URI']) == 'admin-complaints' ? 'active-li' : '' ?>"><a href="admin-complaints"><i class="fa-solid fa-circle-info"></i> Complaints</a></li>
    </ul>
    <div class="admin-sidebar-bottom mt-2">
        <button class="default-btn w-100 mt-5 mb-2 fs-6"> add user</button>
        <button class="default-btn-outline w-100 fs-6">add rider</button>
    </div>
</section>