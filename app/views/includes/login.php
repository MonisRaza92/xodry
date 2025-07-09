<div class="login-form">
    <div id="formClose"></div>
    <form id="loginForm" method="POST" class="text-white">
        <img src="assets/images/Logo/xodry-light-logo.png" alt="Brand Logo">
        <h3 class="text-white">Sign in</h3>
        <div data-mdb-input-init class="form-outline mb-2">
            <label class="form-label" for="loginNumber">Enter Your Number</label>
            <input type="number" id="loginNumber" name="number" class="form-control" placeholder="Enter Number" />
        </div>

        <!-- Password input -->
        <div class="form-outline mb-5>
            <label class=" form-label" for="loginPassword">Password</label>
            <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Enter Password" />
        </div>

        <!-- 2 column grid layout -->
        <div class="row mb-4 mt-4">
            <div class="col-md-6 col-6 d-flex justify-content-start">
                <!-- Checkbox -->
                <div class="form-check mb-3 mb-md-0">
                    <label class="form-check-label" for="forgotPassword"> Show Password </label>
                    <input class="form-check-input" type="checkbox" value="" id="showPassword"/>
                </div>
            </div>

            <div class="col-md-6 col-6 d-flex justify-content-end">
                <a href="#!">Forgot password?</a>
            </div>
        </div>
        <div id="loginError"></div>
        <div id="numberError"></div>

        <!-- Submit button -->
        <button type="submit"  class="default-btn-outline btn-block w-100 mb-4">Sign in</button>
    </form>
</div>
<script>
    document.getElementById('showPassword').addEventListener('change', function() {
    var pwd = document.getElementById('loginPassword');
    pwd.type = this.checked ? 'text' : 'password';
});

//Login Form Ajax
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

    fetch('login', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Login successful
            if (data.role === 'admin') {
            window.location.href = 'admin';
            } else if (data.role === 'rider') {
            window.location.href = 'rider';
            } else {
            window.location.href = 'home';
            }
        } else {
            // Login failed
            if (data.message === 'Invalid number') {
                document.getElementById('numberError').textContent = data.message;
            } else if (data.message === 'User not found' || data.message === 'Incorrect password') {
                document.getElementById('loginError').textContent = data.message;
            } else {
                document.getElementById('loginError').textContent = 'An error occurred. Please try again.';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('loginError').textContent = 'An error occurred. Please try again.';
    });
});

</script>