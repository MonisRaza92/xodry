<div class="pickup-form">
    <div id="pickupFormClose"></div>
    <form id="pickupForm" method="POST">
        <img class="img-fluid" src="assets/images/Logo/logo.png" alt="Brand Logo">
        <h3>Schedule Your PickUp</h3>
        <input type="text" name="name" placeholder="Enter Your Name">
        <input type="number" name="number" placeholder="Enter Your Number">
        <input type="text" name="address" placeholder="Enter Your Address">
        <div class="d-flex gap-2 mb-3">
            <select name="pickup_date" id="schedule_date" class="form-control">
                <option value="<?= date('d/m/Y') ?>">Today (<?= date('d/m/Y') ?>)</option>
                <option value="<?= date('d/m/Y', strtotime('+1 day')) ?>">Tomorrow (<?= date('d/m/Y', strtotime('+1 day')) ?>)</option>
            </select>
            <select name="pickup_time" id="pickup_time" class="form-control">
                <?php
                // Generate time slots from 9:00 AM to 8:00 PM
                for ($hour = 9; $hour <= 24; $hour++) {
                    $time = DateTime::createFromFormat('H:i', "$hour:00");
                    echo "<option value='{$time->format('H:i')}'>{$time->format('g:i A')}</option>";
                }
                ?>
            </select>
        </div>

        <p><strong>NOTE:</strong> If you don't have account your account will be created automatically</p>
        <div id="pickupError"></div>
        <div id="pickupNumberError"></div>
        <button type="submit" class="default-btn-outline text-dark btn-block w-100 mb-4">Schedule Now</button>
    </form>
</div>

<script>
    const form = document.getElementById('pickupForm');

    form.addEventListener('submit', async function(e) {
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