<!-- Reusable Modal Component -->
<div class="modal fade" id="reusableModal" tabindex="-1" aria-labelledby="reusableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="reusableModalLabel">Modal Title</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="reusableModalBody">
                Modal message here.
            </div>
            <div class="modal-footer border-secondary" id="reusableModalFooter">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="reusableModalAction">Action</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showReusableModal(title, message, actionText, actionCallback) {
        document.getElementById('reusableModalLabel').textContent = title;
        document.getElementById('reusableModalBody').textContent = message;
        const actionBtn = document.getElementById('reusableModalAction');
        actionBtn.textContent = actionText;
        actionBtn.onclick = actionCallback;
        const modal = new bootstrap.Modal(document.getElementById('reusableModal'));
        modal.show();
    }
</script>