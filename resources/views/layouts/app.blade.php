<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'POS')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body>

    @include('layouts.navbar')

    <main class="container mt-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    @stack('scripts')

<script>
$(document).ready(function() {
    $(document).on('click', '#filterBtn', function() {
        var formData = $('#filterForm').serialize();
        $.ajax({
            url: "{{ route('admin.invoice.report.data') }}",
            type: "GET",
            data: formData,
            beforeSend: function() {
                $('#reportTable').html('<p class="text-center">Loading...</p>');
            },
            success: function(data) {
                $('#reportTable').html(data);
            },
            error: function(err) {
                console.error(err);
                $('#reportTable').html('<p class="text-center text-danger">Error loading data.</p>');
            }
        });
    });

    // Optional: live filtering on change
    $('#filterForm select, #filterForm input[type="date"]').on('change', function() {
        $('#filterBtn').click();
    });
});
</script>

</body>
</html>
