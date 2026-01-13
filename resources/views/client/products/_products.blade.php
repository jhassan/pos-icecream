{{-- LEFT SIDE: Products --}}
@foreach($categories as $category)
    <h5 class="mt-3">{{ $category->name }}</h5>
    <div class="row">
        @foreach($category->products as $product)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm p-3 h-100">
                    <h6>{{ $product->name }}</h6>
                    <p>Rs {{ number_format($product->sale_price, 2) }}</p>
                    <button class="btn btn-sm btn-primary w-100 addProduct"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->sale_price }}">
                        Add
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
