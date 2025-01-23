<!-- Send Invoice Sidebar -->
<div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
  <div class="offcanvas-header mb-3">
    <h5 class="offcanvas-title">Send Invoice</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body flex-grow-1">
    <form id="sendInvoiceForm" action="{{ route('invoices.send') }}" method="POST">
      @csrf
      <div class="form-floating form-floating-outline mb-4">
        <input
          type="email"
          class="form-control"
          id="invoice-from"
          name="from_email"
          value="{{ auth()->user()->email }}"
          placeholder="your-email@example.com"
          required
        />
        <label for="invoice-from">From</label>
      </div>
      <div class="form-floating form-floating-outline mb-4">
        <input
          type="email"
          class="form-control"
          id="invoice-to"
          name="to_email"
          placeholder="recipient@example.com"
          required
        />
        <label for="invoice-to">To</label>
      </div>
      <div class="form-floating form-floating-outline mb-4">
        <input
          type="text"
          class="form-control"
          id="invoice-subject"
          name="subject"
          placeholder="Invoice Subject"
          required
        />
        <label for="invoice-subject">Subject</label>
      </div>
      <div class="form-floating form-floating-outline mb-4">
        <textarea
          class="form-control"
          name="message"
          id="invoice-message"
          style="height: 190px;"
          placeholder="Write your message here..."
          required
        >Dear [Recipient Name],
Thank you for your business. We are pleased to attach the invoice for your recent transaction.
Please process payment by [Due Date].
Best regards,</textarea>
        <label for="invoice-message">Message</label>
      </div>
      <div class="mb-4">
        <span class="badge bg-label-primary rounded-pill">
          <i class="ri-links-line ri-14px me-1"></i>
          <span class="align-middle">Invoice Attached</span>
        </span>
      </div>
      <div class="mb-3 d-flex flex-wrap">
        <button type="submit" class="btn btn-primary me-3">Send</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
      </div>
    </form>
  </div>
</div>
<!-- /Send Invoice Sidebar -->
