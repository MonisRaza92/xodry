<?php

use helpers\HelperFunctions;

$user = HelperFunctions::userDetails();
?>
<div class="user-details-form">
    <div id="userDetailsFormClose"></div>
    <form id="userDetailsForm" method="POST" action="updateProfile">
        <img class="img-fluid" src="assets/images/Logo/logo.png" alt="Brand Logo">
        <h3>Update Your Details</h3>
        <input type="text" name="name" placeholder="Enter Your Name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
        <input type="number" name="number" placeholder="Enter Your Number" value="<?= htmlspecialchars($user['number'] ?? '') ?>">
        <input type="email" name="email" placeholder="Enter Your Email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
        <input type="text" name="address" placeholder="Enter Your Address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
        <div id="updateError"></div>
        <button type="submit" class="default-btn-outline btn-block w-100 mb-4">Update Now</button>
    </form>
</div>