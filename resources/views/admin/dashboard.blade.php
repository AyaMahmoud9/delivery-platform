<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>

    <h1>Delivery Platform Admin</h1>

    <hr>

    <h2>Dashboard</h2>

    <p>
        <strong>Users:</strong>
        {{ $counts['users'] }}
    </p>

    <p>
        <strong>Delivery Representatives:</strong>
        {{ $counts['delivery'] }}
    </p>

    <p>
        <strong>Admins:</strong>
        {{ $counts['admins'] }}
    </p>

    <hr>

    <a href="{{ route('admin.users.index') }}">
        Manage Users
    </a>

    <br><br>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>

        <br>
    @endif

    <form method="POST" action="{{ route('admin.notifications.send') }}">
        @csrf

        <button type="submit">
            Send Notification to All Users
        </button>
    </form>

    <br><br>

    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf

        <button type="submit">Logout</button>
    </form>

</body>
</html>