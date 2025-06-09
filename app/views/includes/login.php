<div class="login-form">
    <div id="formClose"></div>
    <form id="loginForm" method="POST">
        <img src="assets/images/Logo/logo.png" alt="Brand Logo">
        <h3>Sign in</h3>
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