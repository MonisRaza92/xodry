//login Popup Form Functionality

const loginBtn = document.getElementById('loginBtn');
const loginForm = document.querySelector('.login-form');
const formClose = document.querySelector('#formClose');

if (loginBtn) {
    loginBtn.addEventListener('click', () => {
        loginForm.classList.add('login-form-active');
    });
}
if(formClose){
formClose.addEventListener('click', () => {
    loginForm.classList.remove('login-form-active'); 
});}
document.addEventListener('click', function (event) {
    if (
        loginForm &&
        loginBtn &&
        !loginForm.contains(event.target) &&
        !loginBtn.contains(event.target)
    ) {
        loginForm.classList.remove('login-form-active');
    }
});
//Pickup Popup Form Functionality

const scheduleBtn = document.querySelector('#scheduleBtn');
const pickupForm = document.querySelector('.pickup-form');
const pickupFormClose = document.querySelector('#pickupFormClose');

if(scheduleBtn){
scheduleBtn.addEventListener('click', (e) => {
    e.preventDefault();
    pickupForm.classList.add('pickup-form-active');
});
}
if (pickupFormClose) {
    pickupFormClose.addEventListener('click', () => {
        pickupForm.classList.remove('pickup-form-active');
    });
}
document.addEventListener('click', function (event) {
    if (
        pickupForm &&
        scheduleBtn &&
        !pickupForm.contains(event.target) &&
        !scheduleBtn.contains(event.target)
    ) {
        pickupForm.classList.remove('pickup-form-active');
    }
});
document.addEventListener('click', function (event) {
    if (
        pickupForm &&
        scheduleBtn &&
        !pickupForm.contains(event.target) && !scheduleBtn.contains(event.target)
    ) {
        pickupForm.classList.remove('pickup-form-active');
    }
});

const userDetailsBtn = document.querySelector('#userDetailsBtn');
const userDetailsForm = document.querySelector('.user-details-form');
const userDetailsFormClose = document.querySelector('#userDetailsFormClose');

document.addEventListener('click', function (event) {
    if (
        userDetailsForm &&
        userDetaailsBtn &&
        !userDetailsForm.contains(event.target) &&
        !userDetaailsBtn.contains(event.target)
    ) {
        userDetailsForm.classList.remove('user-details-form-active');
    }
});

if (userDetailsFormClose) {
    userDetailsFormClose.addEventListener('click', () => {
        userDetailsForm.classList.remove('user-details-form-active');
    });
    document.addEventListener('click', function (event) {
    
        if (
            userDetailsForm &&
            userDetailsBtn &&
            !userDetailsForm.contains(event.target) && !userDetailsBtn.contains(event.target)
        ) {
            userDetailsForm.classList.remove('user-details-form-active');
        }
    });
}