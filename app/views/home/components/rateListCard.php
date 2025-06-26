<div class="custom-services-container container px-lg-0">
    <?php
    $grouped = [];
    foreach ($serviceListByCategory as $service) {
        $grouped[$service['category_name']][] = $service;
    }
    ?>
    <?php if (!empty($grouped)): ?>
        <?php foreach ($grouped as $category => $services): ?>
            <div class="custom-service-card">
                <div class="custom-service-card-header">
                    <h5><?= htmlspecialchars($category) ?></h5>
                </div>
                <div class="custom-service-card-body">
                    <table class="custom-service-table">
                        <thead>
                            <tr>
                                <th class="text-dark">Service</th>
                                <th class="text-dark">Price (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $srv): ?>
                                <tr>
                                    <td><?= htmlspecialchars($srv['service_name']) ?></td>
                                    <td>₹<?= number_format($srv['price'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No services found.</p>
    <?php endif; ?>
</div>