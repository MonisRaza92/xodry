<div class="slider-container" data-aos="fade-up">
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
    .slider-container{
        background: var(--secondary-color);
        border-radius: 5px;
        overflow: hidden;
        padding: 0 15px; 
    }
    .service-slider {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        width: 100%;
        scrollbar-width: none;
        margin-bottom:15px;
    }
    
    .slider {
        display: flex;
        animation: slider 15s linear infinite;
    }

    .slider p {
        padding: 10px 30px;
        background-color: var(--contrast-color);
        margin: 5px;
        color: var(--primary-color);
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
        color: var(--contrast-color);
        cursor: pointer;
        border: 2px solid var(--contrast-color);
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