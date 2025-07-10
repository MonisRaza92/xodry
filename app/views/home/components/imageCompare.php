<?php foreach ($compare as $image): ?>
<div class="xodry-compare-container" data-aos="fade-up">
    <div class="xodry-compare-image-wrapper">
        <img src="<?php echo $image['before_image']; ?>" class="xodry-before-img" alt="Before">
        <img src="<?php echo $image['after_image']; ?>" class="xodry-after-img" alt="After">
        <div class="xodry-slider-bar" id="xodrySlider"></div>
        <div class="xodry-label-left">Before</div>
        <div class="xodry-label-right">After</div>
    </div>
</div>
<?php endforeach; ?>
