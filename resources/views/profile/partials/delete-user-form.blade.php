<form method="POST" action="{{ route('profile.destroy') }}">
    @csrf
    @method('DELETE')

    <p class="mb-4 text-sm text-gray-600">
        Once your account is deleted, all of its resources and data will be permanently deleted. Please confirm that you want to permanently delete your account.
    </p>

    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium text-sm rounded-md hover:bg-red-700">
        Delete Account
    </button>
</form>
