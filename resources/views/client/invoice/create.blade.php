@extends('layouts.client.app')

@section('title', 'Create Invoice')

@section('content')
<div class="row">

    {{-- LEFT SIDE: Products --}}
    <div class="col-md-7">
        @foreach($categories as $category)
            <h5 class="mt-3">{{ $category->name }}</h5>
            <div class="row">
                @foreach($category->products as $product)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm p-3 h-100">
                            <h6>{{ $product->name }}</h6>
                            <p>Rs {{ number_format($product->price, 2) }}</p>
                            <button class="btn btn-sm btn-primary w-100 addProduct"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}">
                                Add
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    {{-- RIGHT SIDE: Invoice Panel --}}
    <div class="col-md-5">
        <div class="card shadow-sm p-3">
            <h4>Invoice</h4>
            <table class="table table-sm table-bordered mt-3">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="invoiceItems"></tbody>
            </table>

            <div class="d-flex justify-content-between mt-2">
                <h5>Total:</h5>
                <h5>Rs <span id="grandTotal">0</span></h5>
            </div>

            <button class="btn btn-success w-100 mt-3" id="saveInvoice">Save & Print Invoice</button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
let cart = {};

function renderInvoice() {
    let html = '';
    let total = 0;

    Object.values(cart).forEach(item => {
        let subtotal = item.qty * item.price;
        total += subtotal;

        html += `
        <tr>
            <td>${item.name}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-secondary" onclick="changeQty(${item.id}, -1)">-</button>
                ${item.qty}
                <button class="btn btn-sm btn-secondary" onclick="changeQty(${item.id}, 1)">+</button>
            </td>
            <td>Rs ${subtotal.toFixed(2)}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-danger" onclick="removeItem(${item.id})">X</button>
            </td>
        </tr>`;
    });

    document.getElementById('invoiceItems').innerHTML = html;
    document.getElementById('grandTotal').innerText = total.toFixed(2);
}

function changeQty(id, change) {
    if(cart[id]){
        cart[id].qty += change;
        if(cart[id].qty <= 0) delete cart[id];
        renderInvoice();
    }
}

function removeItem(id) {
    delete cart[id];
    renderInvoice();
}

document.querySelectorAll('.addProduct').forEach(btn => {
    btn.addEventListener('click', function () {
        let id = this.dataset.id;
        if(!cart[id]){
            cart[id] = {
                id: id,
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                qty: 1
            };
        } else {
            cart[id].qty++;
        }
        renderInvoice();
    });
});

document.getElementById('saveInvoice').addEventListener('click', function () {
    fetch("{{ route('client.invoice.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            items: cart,
            total: parseFloat(document.getElementById('grandTotal').innerText)
        })
    })
    .then(res => res.json())
    .then(data => {
        window.open(`/client/invoice/print/${data.invoice_id}`, '_blank');
        cart = {};
        renderInvoice();
    });
});
</script>
@endpush
