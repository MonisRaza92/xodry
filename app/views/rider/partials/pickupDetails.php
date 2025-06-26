<div class="modal fade my-5 py-5" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: var(--secondary-color); color: white;">
            <div class="modal-header">
                <h5 class="modal-title" id="pickupModalLabel">Pickup Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="modalPickupId" value="">

                <!-- Category Checkbox List -->
                <div class="mb-3">
                    <label class="form-label">Select Categories</label>
                    <div id="categoryCheckboxes">
                        <?php foreach ($categories as $cat): ?>
                            <div class="form-check">
                                <input class="form-check-input category-checkbox" type="checkbox" value="<?= $cat['id'] ?>" id="cat_<?= $cat['id'] ?>">
                                <label class="form-check-label" for="cat_<?= $cat['id'] ?>">
                                    <?= $cat['category_name'] ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Services Area -->
                <div id="serviceArea"></div>

                <!-- Total Price -->
                <div class="mb-3 mt-3">
                    <label class="form-label">Total Price:</label>
                    <p id="totalPrice">₹0</p>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="submitPickupDetails()">Save & Mark Picked Up</button>
            </div>
        </div>
    </div>
</div>

<script>
    // ✅ When Category Checkbox is Changed
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('category-checkbox')) {
            const categoryId = e.target.value;
            const isChecked = e.target.checked;

            if (isChecked) {
                loadServicesForCategory(categoryId);
            } else {
                removeServiceSection(categoryId);
            }
        }
    });

    // ✅ Load Services for ONE Category
    function loadServicesForCategory(categoryId) {
        const checkbox = document.getElementById('cat_' + categoryId);
        const categoryName = checkbox.nextElementSibling.innerText;

        fetch('rider/get-services', {
                method: 'POST',
                body: new URLSearchParams({
                    category_id: categoryId
                })
            })
            .then(res => res.json())
            .then(services => {
                let html = `
                <div class="category-service-section" id="services_cat_${categoryId}">
                    <label class="form-label mt-3">${categoryName}</label>
                    <div class="row">
            `;

                services.forEach(service => {
                    html += `
                    <div class="col-md-6 mb-2">
                        <div class="form-check d-flex align-items-center">
                            <input 
                                class="form-check-input service-checkbox me-2" 
                                type="checkbox" 
                                data-category-id="${categoryId}"
                                data-service='${JSON.stringify(service)}'
                                id="service_${categoryId}_${service.id}"
                            >
                            <label class="form-check-label me-3" for="service_${categoryId}_${service.id}">
                                ${service.service_name} (₹${service.price})
                            </label>
                            <input 
                                type="number" 
                                min="1" 
                                value="1" 
                                class="form-control form-control-sm ms-2 service-qty" 
                                style="width:70px;" 
                                data-service-id="${service.id}" 
                                disabled
                            >
                        </div>
                    </div>
                `;
                });

                html += '</div></div>';
                document.getElementById('serviceArea').innerHTML += html;

                attachServiceEvents(); // Re-bind events
            });
    }

    // ✅ Remove Service Section when Category Unchecked
    function removeServiceSection(categoryId) {
        const section = document.getElementById('services_cat_' + categoryId);
        if (section) {
            section.remove();
        }
        updateTotalPrice();
    }

    // ✅ Attach Events to checkboxes + qty inputs
    function attachServiceEvents() {
        document.querySelectorAll('.service-checkbox').forEach(cb => {
            cb.addEventListener('change', function() {
                const service = JSON.parse(this.getAttribute('data-service'));
                const qtyInput = document.querySelector(`.service-qty[data-service-id="${service.id}"]`);
                if (this.checked) {
                    qtyInput.disabled = false;
                } else {
                    qtyInput.disabled = true;
                    qtyInput.value = 1;
                }
                updateTotalPrice();
            });
        });

        document.querySelectorAll('.service-qty').forEach(input => {
            input.addEventListener('input', updateTotalPrice);
        });
    }

    // ✅ Calculate Total Price
    function updateTotalPrice() {
        let total = 0;
        document.querySelectorAll('.service-checkbox:checked').forEach(cb => {
            const service = JSON.parse(cb.getAttribute('data-service'));
            const qtyInput = document.querySelector(`.service-qty[data-service-id="${service.id}"]`);
            const qty = parseInt(qtyInput.value) || 1;
            total += service.price * qty;
        });
        document.getElementById('totalPrice').innerText = '₹' + total;
    }

    // ✅ Submit All Selected Services
    function submitPickupDetails() {
        const pickupId = document.getElementById('modalPickupId').value;
        let items = [];

        document.querySelectorAll('.service-checkbox:checked').forEach(cb => {
            const service = JSON.parse(cb.getAttribute('data-service'));
            const categoryId = cb.getAttribute('data-category-id');
            const qtyInput = document.querySelector(`.service-qty[data-service-id="${service.id}"]`);
            const qty = parseInt(qtyInput.value) || 1;

            items.push({
                category_id: categoryId,
                service_id: service.id,
                quantity: qty,
                total_price: qty * service.price
            });
        });

        if (items.length === 0) {
            alert('Please select at least one service.');
            return;
        }

        fetch('rider/save-pickup-items', {
                method: 'POST',
                body: new URLSearchParams({
                    pickup_id: pickupId,
                    items: JSON.stringify(items)
                })
            })
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {
                    alert(result.message);
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            });
    }
</script>