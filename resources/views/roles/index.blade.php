<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
                <nav class="flex space-x-4">
            <a href="{{ route('roles.index') }}" class="text-gray-600 hover:text-gray-900">All roles</a>
            <a href="{{ route('roles.create') }}" class="text-blue-600 hover:text-blue-900">Create role</a>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Role Name</th>
                            <th class="px-4 py-2">Permissions</th>
                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                       
                            <tr>
                                <td class="border px-4 py-2">{{ $role->name }}</td>
                                <td class="border px-4 py-2">{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                                <td class="border px-4 py-2">{{ $role->created_at->format('Y-m-d H:i') }}</td>
                                <td class="border px-4 py-2">
                                    <x-anchor-link
                                        href="{{ route('roles.edit', $role->id) }}"
                                        class="mb-2">
                                        {{ __('Edit') }}
                                    </x-anchor-link>
                                    |
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-primary-button>
                                            {{ __('Delete') }}
                                        </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $roles->links() }}
                </div>
            </div>
           
    </div>
</x-app-layout>
