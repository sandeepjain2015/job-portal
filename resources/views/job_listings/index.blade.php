<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <nav class="flex space-x-4">
            <a href="{{ route('job-listings.index') }}" class="text-gray-600 hover:text-gray-900">All jobs</a>
             @can('create jobs')
            <a href="{{ route('job-listings.create') }}" class="text-blue-600 hover:text-blue-900">Create job</a>
            @endcan
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        article="alert">

                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Company name</th>
                            <th class="px-4 py-2">Pay range</th>

                            <th class="px-4 py-2">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jobListings as $jobListing)
                            <tr>
                                <td class="border px-4 py-2">{{ $jobListing->title }}</td>
                                <td class="border px-4 py-2">{{ $jobListing->description }}</td>
                                <td class="border px-4 py-2">{{ $jobListing->company_name }}</td>
                                <td class="border px-4 py-2">{{ $jobListing->pay_range }}</td>

                                <td class="border px-4 py-2">

                                    <x-anchor-link href="{{ route('job-listings.show', $jobListing->id) }}"
                                        class="">
                                        {{ __('Show') }}
                                    </x-anchor-link>

                                    @can('update jobs')
                                        <x-anchor-link href="{{ route('job-listings.edit', $jobListing->id) }}"
                                            class="">
                                            {{ __('Edit') }}
                                        </x-anchor-link>
                                    @endcan
                                    @can('delete jobs')
                                        <form action="{{ route('job-listings.destroy', $jobListing->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <x-primary-button>
                                                {{ __('Delete') }}
                                            </x-primary-button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $jobListings->links() }}
                </div>
            </div>

        </div>
</x-app-layout>
