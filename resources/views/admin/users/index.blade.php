<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>

    <h1>Manage Users</h1>

    <a href="{{ route('admin.dashboard') }}">
        Back to Dashboard
    </a>

    <br><br>

    <a href="{{ route('admin.users.create') }}">
        Create New User
    </a>

    <br><br>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>

        <br>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Mobile</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ $user->type }}</td>

                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}">
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route('admin.users.destroy', $user) }}"
                            style="display: inline;"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        No users found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>