<div class="users-list-xodry mt-3">
    <?php if (!empty($users)): ?>
        <div class="user-header-xodry d-none d-md-grid">
            <div>Name</div>
            <div>Phone</div>
            <div>Email</div>
            <div>Pickups</div>
        </div>

        <?php foreach ($users as $user): ?>
            <div class="user-row-xodry">
                <div data-label="Name"><?php echo htmlspecialchars($user['name'] ?? ''); ?> #<?php echo htmlspecialchars($user['id'] ?? ''); ?></div>
                <div data-label="Phone"><a href="tel:<?php echo htmlspecialchars($user['number'] ?? ''); ?>"><?php echo htmlspecialchars($user['number'] ?? ''); ?></a></div>
                <div data-label="Email"><?php echo htmlspecialchars($user['email'] ?? ''); ?></div>
                <div data-label="Pickups"><?php echo htmlspecialchars($user['pickup_count'] ?? '0'); ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info users-list-empty-xodry">No users found.</div>
    <?php endif; ?>
</div>