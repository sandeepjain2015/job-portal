<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permission Detail') }}
        </h2>

        <nav class="flex space-x-4">
            <a href="{{ route('permissions.index') }}" class="text-gray-600 hover:text-gray-900">All Permissions</a>
            <a href="{{ route('permissions.create') }}" class="text-blue-600 hover:text-blue-900">Create Permission</a>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- // Display the permission details --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">{{ $permission->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $permission->description }}</p>
                    <span class="text-xs text-gray-500">Created at: {{ $permission->created_at->format('Y-m-d H:i') }}</span>
                    
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="text-blue-600 hover:text-blue-900 ml-4">Edit</a>
                </div>
        </div>
    </div>
</x-app-layout>
