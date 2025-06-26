<!-- adminUsersList.php -->
<div class="users-list-xodry mt-3">
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
            <div class="user-row-xodry user-row-xodry-<?php echo (int)$user['id']; ?>">
                <div class="user-name-xodry user-name-xodry-<?php echo (int)$user['id']; ?>">
                    <span class="user-name-text-xodry">Name:  <?php echo htmlspecialchars($user['name'] ?? ''); ?></span>
                </div>
                <div class="user-phone-xodry user-phone-xodry-<?php echo (int)$user['id']; ?>">
                    <span class="user-phone-text-xodry"><strong>Phone:</strong> <?php echo htmlspecialchars($user['number'] ?? ''); ?></span>
                </div>
                <div class="user-email-xodry user-email-xodry-<?php echo (int)$user['id']; ?>">
                    <span class="user-email-text-xodry"><?php echo htmlspecialchars($user['email'] ?? ''); ?></span>
                </div>
                <div class="user-actions-xodry user-actions-xodry-<?php echo (int)$user['id']; ?>">
                    <form action="deleteUser" method="post" class="user-delete-form-xodry">
                        <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm user-delete-btn-xodry" onclick="return confirm('Are you sure to delete this user?');">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info users-list-empty-xodry">No users found.</div>
    <?php endif; ?>
</div>