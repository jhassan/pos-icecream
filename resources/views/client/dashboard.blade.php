<!DOCTYPE html>
<html>
<head>
    <title>Client Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-primary px-3 navbar-expand">
    <span class="navbar-brand">Sale Invoice</span>

    <div class="d-flex align-items-center ms-auto">
        <ul class="navbar-nav flex-row">
            @auth('client')
                <li class="nav-item me-3">
                    <a class="nav-link text-white" href="/client/products">Products</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link text-white" href="/client/dashboard">Dashboard</a>
                </li>
            @endauth
        </ul>

        @auth('client')
            <form method="POST" action="{{ route('client.logout') }}" class="mb-0">
                @csrf
                <button class="btn btn-light btn-sm">Logout</button>
            </form>
        @endauth
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <h4>Welcome, {{ auth('client')->user()->name }}</h4>
            <p>Email: {{ auth('client')->user()->email }}</p>
        </div>
    </div>
</div>

</body>
</html>
