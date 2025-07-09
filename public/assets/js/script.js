const mobileMenuBtn = document.getElementById('mobile-menu-icon');
const mobileMenu = document.getElementById('mobile-menu');
const mobileMenuCloseBtn = document.getElementById('mobile-menu-close');

mobileMenuBtn.addEventListener('click', function () {
    mobileMenu.classList.add('mobile-menu-active');
});

mobileMenuCloseBtn.addEventListener('click', function () {
    mobileMenu.classList.remove('mobile-menu-active');
});
document.addEventListener('click', function (event) {
    if (!mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
        mobileMenu.classList.remove('mobile-menu-active');
    }
});

const accountMenuBtn = document.querySelector('#accountMenuBtn');
const accountMenu = document.querySelector('.account-menu');
const adminMenuBtn = document.querySelector('.admin-menu-open-btn');
const adminMenu = document.querySelector('.admin-sidebar');
const cartBtn = document.querySelector('#cartBtn');
const cart = document.querySelector('#cart');
if (cartBtn) {
    cartBtn.addEventListener('click', function (e) {
        e.preventDefault();
        cart.classList.toggle('cart-active');
        accountMenu.classList.remove('account-menu-active');
    });
};
if (accountMenuBtn) {
    accountMenuBtn.addEventListener('click', function (e) {
        e.preventDefault();
        accountMenu.classList.toggle('account-menu-active');
        cart.classList.remove('cart-active');
    });
};
if (adminMenuBtn) {
    adminMenuBtn.addEventListener('click', function (e) {
        e.preventDefault();
        adminMenu.classList.toggle('admin-sidebar-active');
    });
}
document.addEventListener('click', function (event) {
   if (accountMenu) {
       if (!accountMenu.contains(event.target) && !accountMenuBtn.contains(event.target) && !cartBtn.contains(event.target) && !cart.contains(event.target)) {
           accountMenu.classList.remove('account-menu-active');
           cart.classList.remove('cart-active')
       }
    }
    if (adminMenu) {
        if (!adminMenu.contains(event.target) && (!adminMenuBtn || !adminMenuBtn.contains(event.target))) {
            adminMenu.classList.remove('admin-sidebar-active');
        }
    }
});


AOS.init();


const slider = document.getElementById("xodrySlider");
const afterImg = document.querySelector(".xodry-after-img");
const wrapper = document.querySelector(".xodry-compare-image-wrapper");

let isDragging = false;
if(slider){
slider.addEventListener("mousedown", (e) => {
    isDragging = true;
});}

document.addEventListener("mouseup", () => {
    isDragging = false;
});

document.addEventListener("mousemove", (e) => {
    if (!isDragging) return;

    const rect = wrapper.getBoundingClientRect();
    let offsetX = e.clientX - rect.left;
    offsetX = Math.max(0, Math.min(offsetX, rect.width));

    const percent = (offsetX / rect.width) * 100;

    slider.style.left = `${percent}%`;
    afterImg.style.clipPath = `inset(0 0 0 ${percent}%)`;
});

// Mobile support
if(slider){
slider.addEventListener("touchstart", () => isDragging = true);
}
document.addEventListener("touchend", () => isDragging = false);
document.addEventListener("touchmove", (e) => {
    if (!isDragging) return;
    const touch = e.touches[0];
    const rect = wrapper.getBoundingClientRect();
    let offsetX = touch.clientX - rect.left;
    offsetX = Math.max(0, Math.min(offsetX, rect.width));
    const percent = (offsetX / rect.width) * 100;

    slider.style.left = `${percent}%`;
    afterImg.style.clipPath = `inset(0 0 0 ${percent}%)`;
});

