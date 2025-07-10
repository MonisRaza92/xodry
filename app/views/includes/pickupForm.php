<?php

use helpers\HelperFunctions;

$user = HelperFunctions::userDetails();
?>
<div class="pickup-form">
    <div id="pickupFormClose"></div>
    <form id="pickupForm" method="POST">
        <img class="img-fluid" src="assets/images/Logo/xodry-light-logo.png" alt="Brand Logo">
        <h3 class="text-white">Schedule Your PickUp</h3>
        <input type="text" name="name" placeholder="Enter Your Name"
            value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>">
        <input type="number" name="number" placeholder="Enter Your Number"
            value="<?php echo htmlspecialchars($user['number'] ?? ''); ?>">
        <input type="text" name="address" placeholder="Enter Your Address"
            value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
        <div class="d-flex gap-2 mb-3">
            <select name="pickup_date" id="schedule_date" class="form-control" style="width:60%;">
                <option value="<?= date('d/m/Y') ?>">Today (<?= date('d/m/Y') ?>)</option>
                <option value="<?= date('d/m/Y', strtotime('+1 day')) ?>">Tomorrow
                    (<?= date('d/m/Y', strtotime('+1 day')) ?>)</option>
            </select>
            <select name="pickup_time" id="pickup_time" class="form-control" style="width:40%;">
                <?php
                for ($hour = 9; $hour <= 21; $hour++) {
                    $time = DateTime::createFromFormat('H:i', "$hour:00");
                    $formatted = $time->format('g:i A'); // e.g. 2:00 PM
                    echo "<option value='{$formatted}'>{$formatted}</option>";
                }
                ?>
            </select>

        </div>

        <p class="text-white"><strong>NOTE:</strong> If you don't have account your account will be created
            automatically</p>
        <div id="pickupError"></div>
        <div id="pickupNumberError"></div>
        <button type="submit" class="default-btn-outline btn-block w-100 mb-4">Schedule Now</button>
    </form>
</div>

<script>
    const form = document.getElementById('pickupForm');

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Form reload na ho

        const formData = new FormData(form); // Form ke saare input data

        try {
            // Step 1: Fetch request bhejo
            const response = await fetch('createPickup', {
                method: 'POST',
                body: formData
            });

            // Step 2: Raw response text nikalo
            const text = await response.text();
            console.log(" Raw Response:", text); // Yeh check karo console me

            // Step 3: Try to parse JSON
            const result = JSON.parse(text);

            // Step 4: Result handle karo
            if (result.status === 'success') {
                alert('Pickup Scheduled!');
                form.reset();
                window.location.href = 'home';
            } else {
                alert('Error: ' + result.message);
            }

        } catch (error) {
            console.error("Fetch Error:", error);
            alert('Server or Network Error.');
        }
    });
</script>