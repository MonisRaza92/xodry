<!-- 🟢 Step 1: Main Modal - List of Item Groups -->
<div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="background: var(--secondary-color); margin-top: 80px; color: white; border: 1px solid var(--contrast-color);">
            <div class="modal-header">
                <h5 class="modal-title">Pickup Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modalPickupId">

                <div id="itemListContainer"></div>

                <button class="btn btn-primary my-3" onclick="openNewListPopup()">+ Add New List</button>

                <div class="mt-3">
                    <strong>Grand Total Items:</strong> <span id="grandTotalQty">0</span><br>
                    <strong>Grand Total Price:</strong> ₹<span id="grandTotalPrice">0</span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="submitPickupDetails()">Save & Mark Picked Up</button>
            </div>
        </div>
    </div>
</div>

<!-- 🟡 Step 2: Add List Popup (Service + Category Select) -->
<div class="modal fade" id="addListPopup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--secondary-color); margin-top: 100px; color: white; border: 1px solid var(--contrast-color);">
            <div class="modal-header">
                <h5 class="modal-title">Add New List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Choose Category</label>
                    <select class="form-select" id="demoServiceSelect">
                        <option selected disabled>Select</option>
                        <?php foreach ($demoServices as $demo): ?>
                            <option value=""><?= $demo['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Select Service</label>
                    <select class="form-select" id="categorySelect">
                        <option selected disabled>Select</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🔵 Step 3: Item Selection Popup (After category chosen) -->
<div class="modal fade" id="itemPopup" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: var(--secondary-color);  margin-top: 100px; color: white; border: 1px solid var(--contrast-color);">
            <div class="modal-header">
                <h5 class="modal-title">Select Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="itemsArea"></div>
                <div class="mt-3">
                    <button class="btn btn-success" onclick="saveItemList()">Save This List</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let allLists = [];

    function openNewListPopup(editIndex = null) {
        const modal = new bootstrap.Modal(document.getElementById('addListPopup'));
        document.getElementById('demoServiceSelect').selectedIndex = 0;
        document.getElementById('categorySelect').selectedIndex = 0;
        modal.show();

        document.getElementById('categorySelect').onchange = function () {
            const catId = this.value;
            const catName = this.options[this.selectedIndex].text;
            const serviceName = document.getElementById('demoServiceSelect').value || 'Unknown';

            if (catId && serviceName !== 'Select') {
                bootstrap.Modal.getInstance(document.getElementById('addListPopup')).hide();
                loadItemsForCategory(catId, catName, serviceName, editIndex);
            } else {
                alert('Please select service and category');
            }
        };
    }

    function loadItemsForCategory(categoryId, categoryName, serviceName, editIndex = null) {
        fetch('rider/get-services', {
            method: 'POST',
            body: new URLSearchParams({ category_id: categoryId })
        })
            .then(res => res.json())
            .then(items => {
                let html = '';
                items.forEach(item => {
                    html += `
        <div class="row align-items-center mb-2">
          <div class="col-md-5">${item.service_name}</div>
          <div class="col-md-3 d-flex align-items-center">
            <button class="btn btn-sm btn-light me-2" onclick="changeQty(this, -1)">-</button>
            <span class="qty-val" data-price="${item.price}" data-id="${item.id}" data-name="${item.service_name}">0</span>
            <button class="btn btn-sm btn-light ms-2" onclick="changeQty(this, 1)">+</button>
          </div>
          <div class="col-md-4">
            <input type="text" class="form-control comment-input" placeholder="Comment (optional)">
          </div>
        </div>`;
                });
                document.getElementById('itemsArea').innerHTML = html;
                document.getElementById('itemPopup').setAttribute('data-category-id', categoryId);
                document.getElementById('itemPopup').setAttribute('data-category-name', categoryName);
                document.getElementById('itemPopup').setAttribute('data-demo-service', serviceName);
                document.getElementById('itemPopup').setAttribute('data-edit-index', editIndex);
                new bootstrap.Modal(document.getElementById('itemPopup')).show();
            });
    }

    function changeQty(btn, delta) {
        const span = btn.parentElement.querySelector('.qty-val');
        let qty = parseInt(span.innerText);
        qty = Math.max(0, qty + delta);
        span.innerText = qty;
    }

    function saveItemList() {
        const popup = document.getElementById('itemPopup');
        const categoryId = popup.getAttribute('data-category-id');
        const categoryName = popup.getAttribute('data-category-name');
        const demoService = popup.getAttribute('data-demo-service');
        const editIndex = popup.getAttribute('data-edit-index');

        const rows = document.querySelectorAll('#itemsArea .row');
        const items = [];
        let totalQty = 0;
        let totalPrice = 0;

        rows.forEach(row => {
            const span = row.querySelector('.qty-val');
            const qty = parseInt(span.innerText);
            if (qty > 0) {
                const price = parseFloat(span.getAttribute('data-price'));
                const comment = row.querySelector('.comment-input').value;
                items.push({
                    service_id: span.getAttribute('data-id'),
                    service_name: span.getAttribute('data-name'),
                    quantity: qty,
                    total_price: qty * price,
                    comment: comment
                });
                totalQty += qty;
                totalPrice += qty * price;
            }
        });

        if (items.length > 0) {
            const newList = {
                demo_service: demoService,
                category_id: categoryId,
                category_name: categoryName,
                items: items,
                total_quantity: totalQty,
                total_price: totalPrice
            };

            if (editIndex !== 'null') {
                allLists[editIndex] = newList;
            } else {
                allLists.push(newList);
            }
            renderItemLists();
        }
        bootstrap.Modal.getInstance(popup).hide();
    }

    function renderItemLists() {
        const container = document.getElementById('itemListContainer');
        container.innerHTML = '';
        let grandQty = 0, grandPrice = 0;

        allLists.forEach((list, index) => {
            container.innerHTML += `
      <div class="d-flex justify-content-between align-items-center border-bottom py-2">
        <div><strong>${list.demo_service}</strong></div>
        <div>${list.category_name}</div>
        <div>Qty: ${list.total_quantity}</div>
        <div>Total: ₹${list.total_price}</div>
        <div>
          <button class="btn btn-sm btn-warning me-1" onclick="editList(${index})">Edit</button>
          <button class="btn btn-sm btn-danger" onclick="deleteList(${index})">Delete</button>
        </div>
      </div>
    `;
            grandQty += list.total_quantity;
            grandPrice += list.total_price;
        });

        document.getElementById('grandTotalQty').innerText = grandQty;
        document.getElementById('grandTotalPrice').innerText = grandPrice;
    }

    function editList(index) {
        const list = allLists[index];
        document.getElementById('demoServiceSelect').value = list.demo_service;
        document.getElementById('categorySelect').value = list.category_id;
        openNewListPopup(index);
    }

    function deleteList(index) {
        allLists.splice(index, 1);
        renderItemLists();
    }

    function submitPickupDetails() {
        const pickupId = document.getElementById('modalPickupId').value;
        if (allLists.length === 0) {
            alert('Please add at least one list.');
            return;
        }
        fetch('rider/save-pickup-items', {
            method: 'POST',
            body: new URLSearchParams({
                pickup_id: pickupId,
                items: JSON.stringify(allLists),
                grand_total: document.getElementById('grandTotalPrice').innerText
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
    }
</script>