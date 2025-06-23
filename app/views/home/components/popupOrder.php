<div class="modal mt-5 py-5 text-dark fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3">
            <div class="modal-header bg-light">
                <h6 class="modal-title fw-bold" id="pickupModalLabel"><i class="fas fa-truck-pickup me-2"></i> Pickup Details</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body small">
                <p><strong>Schedule:</strong> <span id="modalSchedule"></span></p>
                <p><strong>Address:</strong> <span id="modalAddress"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            </div>
            <div class="modal-footer">
                <form method="post" action="cancelPickupStatus" class="d-inline">
                    <input type="hidden" name="pickup_id" id="pickup_Id" value="<?= htmlspecialchars($pickup['id']) ?>">
                    <button type="submit" class="btn btn-outline-danger btn-sm" id="cancelPickupBtn">
                        <i class="fas fa-xmark me-1"></i> Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>