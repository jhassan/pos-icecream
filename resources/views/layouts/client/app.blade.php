<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-light">

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-3">
    <a class="navbar-brand" href="#">Sale Invoice</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategories">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCategories">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item me-3">
                <a class="nav-link text-white" href="/client/dashboard">Dashboard</a>
            </li>
            <li class="nav-item me-3">
                <a class="nav-link text-white" href="{{ route('client.invoice.report') }}">Reports</a>
            </li>
            <li class="nav-item me-3">
                <a class="nav-link text-white" href="/client/products">Products</a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link active category-link text-white" href="#" data-category="all">All</a>
            </li>
            @foreach($categories as $category)
                <li class="nav-item">
                    <a class="nav-link category-link text-white" href="#" data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach --}}

        </ul>

        <div class="ms-auto">
            <form method="POST" action="{{ route('client.logout') }}">
                @csrf
                <button class="btn btn-light btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

{{-- Main Content --}}
<div class="container-fluid py-4">
    @yield('content')
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

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
</script>


</body>
</html>
