@extends('layouts.admin')

@section('content')
<style>
  .items-grid { display: grid; grid-template-columns: 1fr 3fr 1fr 1fr 1fr auto; gap: 8px; align-items: center; }
  .items-grid > div { display:flex; flex-direction:column; }
  .items-grid .header { font-weight:600; }
  .rm-btn { border: none; background: #eee; padding: 6px 10px; cursor: pointer; }
</style>

<div class="main-content-inner">
  <div class="main-content-wrap">
    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
      <h3>Add Order</h3>
      <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
        <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
        <li><i class="icon-chevron-right"></i></li>
        <li><a href="{{ route('admin.orders.index') }}"><div class="text-tiny">Orders</div></a></li>
        <li><i class="icon-chevron-right"></i></li>
        <li><div class="text-tiny">Add</div></li>
      </ul>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul style="margin:0;">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.orders.store') }}">
      @csrf

      <div class="wg-box mb-4">
        <h4>Customer</h4>
        <div class="grid" style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;">
          <div><label>Name</label><input type="text" name="name" value="{{ old('name') }}"></div>
          <div><label>Email</label><input type="email" name="email" value="{{ old('email') }}"></div>
          <div><label>Phone</label><input type="text" name="phone" value="{{ old('phone') }}"></div>
          <div style="grid-column:1/-1;"><label>Address</label><input type="text" name="address" value="{{ old('address') }}"></div>
          <div><label>City</label><input type="text" name="city" value="{{ old('city') }}"></div>
          <div><label>State</label><input type="text" name="state" value="{{ old('state') }}"></div>
          <div><label>Country</label><input type="text" name="country" value="{{ old('country') }}"></div>
          <div><label>ZIP</label><input type="text" name="zip" value="{{ old('zip') }}"></div>
        </div>
      </div>

      <div class="wg-box mb-4">
        <h4>Order Meta</h4>
        <div class="grid" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;">
          <div>
            <label>Status</label>
            <select name="status" required>
              @php $statusOld = old('status','pending'); @endphp
              <option value="pending"   {{ $statusOld==='pending'?'selected':'' }}>Pending</option>
              <option value="completed" {{ $statusOld==='completed'?'selected':'' }}>Completed</option>
              <option value="delivered" {{ $statusOld==='delivered'?'selected':'' }}>Delivered</option>
              <option value="canceled"  {{ $statusOld==='canceled'?'selected':'' }}>Canceled</option>
            </select>
          </div>
          <div>
            <label>Tracking #</label>
            <input type="text" name="tracking_number" value="{{ old('tracking_number') }}">
          </div>
          <div>
            <label>Tax % (optional)</label>
            <input type="number" step="0.01" min="0" max="100" name="tax_percent" value="{{ old('tax_percent','0') }}">
          </div>
          <div style="grid-column:1/-1;">
            <label>Notes</label>
            <textarea name="notes" rows="3">{{ old('notes') }}</textarea>
          </div>
        </div>
      </div>

      <div class="wg-box mb-4">
        <h4>Items</h4>

        {{-- Headers --}}
        <div class="items-grid" style="margin-bottom:8px;">
          <div class="header">SKU</div>
          <div class="header">Name</div>
          <div class="header">Qty</div>
          <div class="header">Price</div>
          <div class="header">Line Total</div>
          <div></div>
        </div>

        <div id="items-container">
          {{-- One default row --}}
          <div class="items-grid item-row">
            <div><input type="text" name="items[0][sku]" placeholder="SKU"></div>
            <div><input type="text" name="items[0][name]" placeholder="Product name" required></div>
            <div><input type="number" name="items[0][qty]"  value="1" min="1" oninput="calcRow(this)" required></div>
            <div><input type="number" name="items[0][price]" value="0" step="0.01" min="0" oninput="calcRow(this)" required></div>
            <div><input type="text" class="line-total" value="0.00" readonly></div>
            <div><button type="button" class="rm-btn" onclick="removeRow(this)">×</button></div>
          </div>
        </div>

        <div class="mt-2">
          <button type="button" class="btn btn-secondary" onclick="addRow()">+ Add Item</button>
        </div>

        <div class="mt-3" style="display:flex;gap:24px;align-items:center;">
          <div><strong>Subtotal:</strong> <span id="subtotal">0.00</span></div>
          <div><strong>Tax (%):</strong> <span id="taxp">0</span></div>
          <div><strong>Tax Amount:</strong> <span id="taxamt">0.00</span></div>
          <div><strong>Total:</strong> <span id="grand">0.00</span></div>
        </div>
      </div>

      <div>
        <button type="submit" class="btn btn-primary">Create Order</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light">Cancel</a>
      </div>
    </form>
  </div>
</div>

<script>
let idx = 1;

function addRow() {
  const wrap = document.getElementById('items-container');
  const row = document.createElement('div');
  row.className = 'items-grid item-row';
  row.innerHTML = `
    <div><input type="text" name="items[${idx}][sku]" placeholder="SKU"></div>
    <div><input type="text" name="items[${idx}][name]" placeholder="Product name" required></div>
    <div><input type="number" name="items[${idx}][qty]" value="1" min="1" oninput="calcRow(this)" required></div>
    <div><input type="number" name="items[${idx}][price]" value="0" step="0.01" min="0" oninput="calcRow(this)" required></div>
    <div><input type="text" class="line-total" value="0.00" readonly></div>
    <div><button type="button" class="rm-btn" onclick="removeRow(this)">×</button></div>
  `;
  wrap.appendChild(row);
  idx++;
  recalcTotals();
}

function removeRow(btn) {
  const row = btn.closest('.item-row');
  row.remove();
  recalcTotals();
}

function calcRow(el) {
  const row = el.closest('.item-row');
  const qty = parseFloat(row.querySelector('input[name*="[qty]"]').value || 0);
  const price = parseFloat(row.querySelector('input[name*="[price]"]').value || 0);
  const total = (qty * price).toFixed(2);
  row.querySelector('.line-total').value = total;
  recalcTotals();
}

function recalcTotals() {
  let subtotal = 0;
  document.querySelectorAll('#items-container .item-row').forEach(row => {
    const val = parseFloat(row.querySelector('.line-total').value || 0);
    subtotal += val;
  });
  const taxpInput = document.querySelector('input[name="tax_percent"]');
  const taxp = taxpInput ? parseFloat(taxpInput.value || 0) : 0;
  const taxamt = +(subtotal * (taxp/100)).toFixed(2);
  const grand = +(subtotal + taxamt).toFixed(2);

  document.getElementById('subtotal').innerText = subtotal.toFixed(2);
  document.getElementById('taxp').innerText = isNaN(taxp) ? 0 : taxp;
  document.getElementById('taxamt').innerText = taxamt.toFixed(2);
  document.getElementById('grand').innerText = grand.toFixed(2);
}

// keep totals in sync if user edits tax %
document.querySelector('input[name="tax_percent"]')?.addEventListener('input', recalcTotals);
document.addEventListener('input', function(e){
  if(e.target.matches('input[name^="items"]')) recalcTotals();
});
</script>
@endsection
