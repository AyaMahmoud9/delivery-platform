<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>

    <h1>Create New User</h1>

    <a href="{{ route('admin.users.index') }}">
        Back to Users
    </a>

    <br><br>

    @if ($errors->any())
        <div>
            <strong>Please fix the following errors:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   

    <form
        method="POST"
        action="{{ route('admin.users.store') }}"
        enctype="multipart/form-data"
    >
        @csrf

        <div>
            <label for="username">Username</label>
            <br>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="mobile">Mobile</label>
            <br>
            <input
                type="text"
                id="mobile"
                name="mobile"
                value="{{ old('mobile') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="password">Password</label>
            <br>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <br>

        <div>
            <label for="type">Type</label>
            <br>

            <select id="type" name="type" required>
                <option value="">Select type</option>
                <option value="user" {{ old('type') === 'user' ? 'selected' : '' }}>
                    User
                </option>
                <option value="delivery" {{ old('type') === 'delivery' ? 'selected' : '' }}>
                    Delivery
                </option>
                <option value="admin" {{ old('type') === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
            </select>
        </div>

        <br>

        <div>
            <label for="latitude">Latitude</label>
            <br>
            <input
                type="number"
                id="latitude"
                name="latitude"
                step="any"
                value="{{ old('latitude') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="longitude">Longitude</label>
            <br>
            <input
                type="number"
                id="longitude"
                name="longitude"
                step="any"
                value="{{ old('longitude') }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="profile_image">Profile Image</label>
            <br>
            <input
                type="file"
                id="profile_image"
                name="profile_image"
                accept="image/*"
            >
        </div>

        <br>

        <button type="submit">
            Create User
        </button>
    </form>

</body>
</html>