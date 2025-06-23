<div class="px-3 overflow-hidden mb-4" data-aos="fade-up">
    <div class="service-slider overflow-hidden rounded-3 mt-3">
        <div class="slider">
            <?php foreach ($categories as $cat): ?>
                <p><?php echo $cat['category_name']; ?></p>
            <?php endforeach; ?>
        </div>
        <div class="slider">
            <?php foreach ($categories as $cat): ?>
                <p><?php echo $cat['category_name']; ?></p>
            <?php endforeach; ?>
        </div>
        <div class="slider">
            <?php foreach ($categories as $cat): ?>
                <p><?php echo $cat['category_name']; ?></p>
            <?php endforeach; ?>
        </div>
        <div class="slider">
            <?php foreach ($categories as $cat): ?>
                <p><?php echo $cat['category_name']; ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<style>
    .service-slider {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        width: 100%;
        scrollbar-width: none;
    }

    .slider {
        display: flex;
        animation: slider 15s linear infinite;
    }

    .slider p {
        padding: 10px 30px;
        background-color: #f0f0f0;
        margin: 5px;
        color: var(--dark-color);
        text-transform: uppercase;
        font-weight: bold;
        font-size: 1.2rem;
        border-radius: 5px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .slider p:hover {
        background: var(--primary-color);
        color: var(--light-color);
        cursor: pointer;
        border: 2px solid var(--light-color);
    }

    @keyframes slider {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }
</style>