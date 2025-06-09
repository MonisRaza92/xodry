<div class="pickup-form">
    <div id="pickupFormClose"></div>
    <form id="pickupForm" method="POST">
        <img class="img-fluid" src="assets/images/Logo/logo.png" alt="Brand Logo">
        <h3>Schedule Your PickUp</h3>
        <input type="text" name="name" placeholder="Enter Your Name">
        <input type="number" name="number" placeholder="Enter Your Number">
        <input type="text" name="address" placeholder="Enter Your Address">
        <input type="text" name="pickup_date" id="schedule" placeholder="Enter Pickup Date (DD/MM/YYYY)" maxlength="10" oninput="formatDateInput(this)">

        <script>
            function formatDateInput(input) {
                let value = input.value.replace(/\D/g, '');
                if (value.length > 2) value = value.slice(0, 2) + '/' + value.slice(2);
                if (value.length > 5) value = value.slice(0, 5) + '/' + value.slice(5, 9);
                input.value = value;
            }
        </script>
        <p><strong>NOTE:</strong> If you don't have account your account will be created automatically</p>
        <div id="pickupError"></div>
        <div id="pickupNumberError"></div>
        <button type="submit" class="default-btn-outline btn-block w-100 mb-4">Schedule Now</button>
    </form>
</div>