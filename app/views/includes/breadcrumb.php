<section class="xodry-breadcrumb pb-1 mt-5 pt-5 container-fluid px-0">
    <div class="container px-0">
        <h2><?php echo htmlspecialchars(isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'XODRY'); ?></h2>
        <p><a href="/">Home</a>/<?= $pageName ?></p>
    </div>
</section>