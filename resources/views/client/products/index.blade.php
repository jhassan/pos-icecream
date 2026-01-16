@extends('layouts.client.app')

@section('title', 'Create Invoice')

@section('content')
<div class="row">
    <div class="col-md-1 mb-2">
        <span class="badge rounded-pill text-bg-success category-link" data-category="all" style="cursor: pointer;">All</span>
    </div>
    @foreach($categories as $category)
        <div class="col-md-1 mb-2">
            <span class="badge rounded-pill text-bg-primary category-link" style="cursor: pointer;" data-category="{{ $category->id }}">{{ $category->name }}</span>
        </div>
    @endforeach
</div>
<div class="row">
    {{-- LEFT SIDE: Products --}}
    <div class="col-md-7" id="product-area">
        @include('client.products._products')
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
<iframe id="printFrame" style="display:none;"></iframe>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).on('click', '.category-link', function (e) {
    e.preventDefault();

    let categoryId = $(this).data('category');
    $('.category-link').removeClass('active');
    $(this).addClass('active');

    $.ajax({
        url: "{{ route('client.products.by.category') }}",
        type: "GET",
        data: { category_id: categoryId },
        success: function (html) {
            $('#product-area').html(html);
        }
    });

});
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

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('addProduct')) {
        let btn = e.target;
        let id = btn.dataset.id;

        if (!cart[id]) {
            cart[id] = {
                id: id,
                name: btn.dataset.name,
                price: parseFloat(btn.dataset.price),
                qty: 1
            };
        } else {
            cart[id].qty++;
        }
        renderInvoice();
    }
});


// document.getElementById('saveInvoice').addEventListener('click', function () {
//     fetch("{{ route('client.invoice.store') }}", {
//         method: 'POST',
//         headers: {
//             'Content-Type':'application/json',
//             'X-CSRF-TOKEN': '{{ csrf_token() }}'
//         },
//         body: JSON.stringify({
//             items: cart,
//             total: parseFloat(document.getElementById('grandTotal').innerText)
//         })
//     })
//     .then(res => res.json())
//     .then(data => {
//         window.open(`/client/invoice/print/${data.invoice_id}`);
//         cart = {};
//         renderInvoice();
//     });
// });
document.getElementById('saveInvoice').addEventListener('click', function () {

    fetch("{{ route('client.invoice.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            items: cart,
            total: parseFloat(document.getElementById('grandTotal').innerText)
        })
    })
    .then(res => res.json())
    .then(data => {

        // Load print page in iframe
        let iframe = document.getElementById('printFrame');
        iframe.src = `/client/invoice/print/${data.invoice_id}`;

        iframe.onload = function () {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        };

        // Reset invoice
        cart = {};
        renderInvoice();
    })
    .catch(error => {
        console.error('Invoice save failed:', error);
    });

});
</script>
@endpush
