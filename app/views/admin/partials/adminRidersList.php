<div class="user-list-xodry mt-3">
    <?php if (!empty($riders)): ?>
        <div class="user-header-xodry d-none d-md-grid">
            <div>Rider Name</div>
            <div>Phone</div>
            <div>Email</div>
            <div>Action</div>
        </div>

        <?php foreach ($riders as $rider): ?>
            <div class="user-row-xodry my-2">
                <div data-label="Name"><?php echo htmlspecialchars($rider['name'] ?? ''); ?></div>
                <div data-label="Phone"><a href="tel:<?php echo htmlspecialchars($rider['number'] ?? ''); ?>"><?php echo htmlspecialchars($rider['number'] ?? ''); ?></a>
                </div>
                <div data-label="Email"><?php echo htmlspecialchars($rider['email'] ?? ''); ?></div>
                <div class="delete" data-label="Action">
                    <form action="deleteRider" method="POST"
                        onsubmit="return confirm('Do you want to delete this rider? This action cannot be undone.')">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($rider['id'] ?? ''); ?>">
                        <button type="submit" class="border rounded">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info riders-list-empty-xodry">No riders found.</div>
    <?php endif; ?>
</div>