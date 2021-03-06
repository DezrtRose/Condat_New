<div class="modal fade" id="deleteInvoice" tabindex="-1" role="dialog" aria-labelledby="deleteInvoiceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Delete Invoice?</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the invoice? The deleted invoices cannot be recovered later.</p>
                <p class="text-muted">You can choose between the delete options.</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-action btn-primary btn-delete" data-action="deleteInvoiceOnly" id="" onclick="return confirm('Are you sure? The action cannot be undone.')">Delete Invoice Only</a>
                <a href="#" class="btn btn-action btn-danger btn-delete" data-action="deleteInvoice" id="" onclick="return confirm('Are you sure? The action cannot be undone.')">Delete Invoice and Payments</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--<a href="' . route("tenant.student.deleteInvoice", [$tenant_id, $data->student_invoice_id])--}}