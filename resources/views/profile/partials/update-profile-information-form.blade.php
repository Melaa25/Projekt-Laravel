<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    </div>

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    </div>

    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-md hover:bg-blue-700">
        Save
    </button>
</form>
