<div class="image-slider px-0" id="imageSlider">
    <img src="assets/images/Hero/slider1.jpg" alt="" class="img-fluid slider-img active">
    <img src="assets/images/Hero/slider2.jpg" alt="" class="img-fluid slider-img">
    <img src="assets/images/Hero/slider3.jpg" alt="" class="img-fluid slider-img">
    <div class="sliding-btns">
        <button id="prevBtn"></button>
        <button id="nextBtn"></button>
    </div>
<script>
    let current = 0;
    const images = document.querySelectorAll('#imageSlider .slider-img');
    const total = images.length;
    let timer;

    function showImage(index, direction = 1) {
        if(index === current) return;
        const prev = current;
        images[prev].classList.remove('active', 'slide-in-left', 'slide-in-right', 'slide-out-left', 'slide-out-right');
        images[index].classList.remove('active', 'slide-in-left', 'slide-in-right', 'slide-out-left', 'slide-out-right');

        if(direction === 1) {
            images[prev].classList.add('slide-out-left');
            images[index].classList.add('slide-in-right');
        } else {
            images[prev].classList.add('slide-out-right');
            images[index].classList.add('slide-in-left');
        }
        images[index].classList.add('active');

        setTimeout(() => {
            images[prev].classList.remove('slide-out-left', 'slide-out-right', 'active');
            images[index].classList.remove('slide-in-right', 'slide-in-left');
        }, 500);

        current = index;
    }

    function nextImage() {
        let next = (current + 1) % total;
        showImage(next, 1);
    }

    function prevImage() {
        let prev = (current - 1 + total) % total;
        showImage(prev, -1);
    }

    function startAutoSlide() {
        timer = setInterval(nextImage, 3000);
    }

    function resetAutoSlide() {
        clearInterval(timer);
        startAutoSlide();
    }

    document.getElementById('nextBtn').onclick = () => {
        nextImage();
        resetAutoSlide();
    };
    document.getElementById('prevBtn').onclick = () => {
        prevImage();
        resetAutoSlide();
    };

    // Initialize
    images.forEach((img, i) => {
        img.style.zIndex = i === current ? 2 : 1;
        if(i === current) img.classList.add('active');
    });
    startAutoSlide();
</script>