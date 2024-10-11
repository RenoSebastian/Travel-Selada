<form action="{{ route('user_travel.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="fullname">Full Name:</label>
        <input type="text" name="fullname" class="form-control" required>
    </div>
    
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <div class="form-group">
        <label for="role_id">Role:</label>
        <select name="role_id" class="form-control">
            <option value="">Select Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Create User</button>
</form>
