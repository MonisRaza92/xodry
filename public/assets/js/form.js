//login Popup Form Functionality

const loginBtn = document.getElementById('loginBtn');
const loginForm = document.querySelector('.login-form');
const formClose = document.querySelector('#formClose');

if (loginBtn) {
    loginBtn.addEventListener('click', () => {
        loginForm.classList.add('login-form-active');
    });
}

formClose.addEventListener('click', () => {
    loginForm.classList.remove('login-form-active'); 
});
document.addEventListener('click', function (event) {
    if (!loginForm.contains(event.target)&& !loginBtn.contains(event.target)) {
        loginForm.classList.remove('login-form-active');
    }
});
//Pickup Popup Form Functionality

const scheduleBtn = document.querySelector('#scheduleBtn');
const pickupForm = document.querySelector('.pickup-form');
const pickupFormClose = document.querySelector('#pickupFormClose');

scheduleBtn.addEventListener('click', (e) => {
    e.preventDefault();
    pickupForm.classList.add('pickup-form-active');
});

pickupFormClose.addEventListener('click', () => {
    pickupForm.classList.remove('pickup-form-active');
});
document.addEventListener('click', function (event) {
    if (!pickupForm.contains(event.target) && !scheduleBtn.contains(event.target)) {
        pickupForm.classList.remove('pickup-form-active');
    }
});

const userDetaailsBtn = document.querySelector('#userDetailsBtn');
const userDetailsForm = document.querySelector('.user-details-form');
const userDetailsFormClose = document.querySelector('#userDetailsFormClose');

if (userDetaailsBtn) {
    userDetaailsBtn.addEventListener('click', (e) => {
        e.preventDefault();
        userDetailsForm.classList.add('user-details-form-active');
    });
}

userDetailsFormClose.addEventListener('click', () => {
    userDetailsForm.classList.remove('user-details-form-active');
});
document.addEventListener('click', function (event) {
    if (!userDetailsForm.contains(event.target) && !userDetaailsBtn.contains(event.target)) {
        userDetailsForm.classList.remove('user-details-form-active');
    }
});


//Password Show function
document.getElementById('showPassword').addEventListener('change', function() {
    var pwd = document.getElementById('loginPassword');
    pwd.type = this.checked ? 'text' : 'password';
});



//Login Form Ajax Function
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
        console.log(" Raw Response:", text);  // Yeh check karo console me

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
