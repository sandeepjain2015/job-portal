<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Role') }}
        </h2>

        <nav class="flex space-x-4">
            <a href="{{ route('roles.index') }}" class="text-gray-600 hover:text-gray-900">All roles</a>
            <a href="{{ route('roles.create') }}" class="text-blue-600 hover:text-blue-900">Create role</a>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('roles.store') }}">

                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Role Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        @foreach ($permissions as $permission)
                            <div class="mb-4">
                                <x-input-label class="inline-flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        class="form-checkbox h-5 w-5 text-blue-600 ml-2">
                                    <span class="ml-2 text-gray-700">{{ $permission->name }}</span>
                                </x-input-label>
                                <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                            </div>
                        @endforeach
                        <x-primary-button>
                            {{ __('Create role') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
