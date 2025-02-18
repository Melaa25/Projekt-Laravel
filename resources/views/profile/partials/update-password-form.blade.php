<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
        <input type="password" name="current_password" id="current_password" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
        <input type="password" name="password" id="password" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    </div>

    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-md hover:bg-blue-700">
        Save
    </button>
</form>
