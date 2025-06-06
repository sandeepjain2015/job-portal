<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <nav class="flex space-x-4">
            <a href="{{ route('permissions.index') }}" class="text-gray-600 hover:text-gray-900">All permissions</a>
            <a href="{{ route('permissions.create') }}" class="text-blue-600 hover:text-blue-900">Create Permission</a>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">

                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Permission Name</th>

                            <th class="px-4 py-2">Created At</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td class="border px-4 py-2">{{ $permission->name }}</td>

                                <td class="border px-4 py-2">{{ $permission->created_at->format('Y-m-d H:i') }}</td>
                                <td class="border px-4 py-2">

                                    <x-anchor-link
                                        href="{{ route('permissions.edit', $permission->id) }}"
                                        class="">
                                        {{ __('Edit') }}
                                    </x-anchor-link>
                                    |
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
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
                    {{ $permissions->links() }}
                </div>
            </div>

        </div>
</x-app-layout>
