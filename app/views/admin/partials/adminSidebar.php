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
        <button class="default-btn-outline w-100 fs-6" id="showAddRiderBtn" type="button">add rider</button>

        <div class="add-rider-popup" id="addRiderPopup" style="display:none; position:fixed; top:50px; left:0; width:100vw; height:auto; background:rgba(0,0,0,0.4); z-index:9999; align-items:center; justify-content:center;">
            <div style="background:var(--secondary-color); padding:2rem; border-radius:8px; max-width:400px; width:90%; position:relative;">
            <button type="button" id="closeAddRiderPopup" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:1.5rem;">&times;</button>
            <form action="addRider" method="POST">
                <h4>Add Rider</h4>
                <div class="mb-3">
                <label for="riderName" class="form-label">Name</label>
                <input type="text" class="form-control" id="riderName" name="name" required>
                </div>
                <div class="mb-3">
                <label for="riderNumber" class="form-label">Number</label>
                <input type="text" class="form-control" id="riderNumber" name="number" required>
                </div>
                <div class="mb-3">
                <label for="riderEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="riderEmail" name="email" required>
                </div>
                <div class="mb-3">
                <label for="riderAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="riderAddress" name="address" required>
                </div>
                <div class="mb-3">
                <label for="riderPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="riderPassword" name="password" required>
                </div>
                <button type="submit" class="default-btn w-100">Add Rider</button>
            </form>
            </div>
        </div>

        <script>
            document.getElementById('showAddRiderBtn').onclick = function() {
            document.getElementById('addRiderPopup').style.display = 'flex';
            };
            document.getElementById('closeAddRiderPopup').onclick = function() {
            document.getElementById('addRiderPopup').style.display = 'none';
            };
            // Optional: Close popup when clicking outside the form
            document.getElementById('addRiderPopup').onclick = function(e) {
            if (e.target === this) this.style.display = 'none';
            };
        </script>
    </div>
</section>