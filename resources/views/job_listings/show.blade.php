<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                {{ __('Job Detail') }}
            </h2>
            <nav class="flex space-x-4">
                <a href="{{ route('job-listings.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Create Job') }}
                </a>
            </nav>
        </div>
    </x-slot>

    <!-- Flash Messages -->
    <section class="py-4 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
            @if (session($type))
                <div
                    class="mb-4 flex items-start bg-{{ $color }}-50 border-l-4 border-{{ $color }}-500 p-4 rounded-lg shadow-sm">
                    <div class="flex-grow text-{{ $color }}-800 font-medium">
                        {{ session($type) }}
                    </div>
                    <button type="button" class="ml-4 text-{{ $color }}-500 hover:text-{{ $color }}-700"
                        onclick="this.parentElement.remove()">
                        &times;
                    </button>
                </div>
            @endif
        @endforeach
    </section>

    <!-- Article Card -->
    <section class="py-6 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden p-6 sm:p-8">
                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $jobListing->title }}</h1>

                <!-- Description -->
                <p class="text-gray-700 leading-relaxed mb-6">
                    {{ $jobListing->description }}
                </p>

                <!-- Details Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center">
                        <span class="font-semibold text-gray-600 mr-2">{{ __('Pay Range:') }}</span>
                        <span class="text-gray-800">{{ $jobListing->pay_range }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-semibold text-gray-600 mr-2">{{ __('Company:') }}</span>
                        <span class="text-gray-800">{{ $jobListing->company_name }}</span>
                    </div>
                </div>

                <!-- Call-to-Action -->
                <div class="mb-6">
                    @auth
                        @if (!auth()->user()->appliedJobs->contains($jobListing->id))
                            <form method="POST" action="{{ route('jobs.apply', $jobListing->id) }}">
                                @csrf

                                <x-input-label for="contact_number" :value="__('Contact Number')" />
                                <x-text-input id="contact_number" class="block mt-1 w-full" type="text"
                                    name="contact_number" required />

                                <label for="resume">Resume</label>
                                <input type="file" name="resume">

                                <x-input-label for="message" :value="__('message')" />
                                <x-textarea-input id="message" name="message" rows="5" required />
                                <x-primary-button>
                                    {{ __('Apply Now') }}
                                </x-primary-button>

                            </form>
                        @else
                            <span
                                class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                {{ __('Already Applied') }}
                            </span>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-base font-semibold rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Login to Apply') }}
                        </a>
                    @endauth
                </div>

                <!-- Footer Actions -->
                <div class="bg-gray-100 border-t px-8 py-4 flex justify-between items-center">
                    <a href="{{ route('job-listings.index') }}"
                        class="text-sm text-gray-600 hover:text-gray-900 flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>{{ __('Back to Listings') }}</span>
                    </a>

                    <div class="space-x-3">
                        @can('edit article')
                            <a href="{{ route('job-listings.edit', $jobListing->id) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ __('Edit') }}
                            </a>
                        @endcan

                        @can('delete article')
                            <form action="{{ route('job-listings.destroy', $jobListing->id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-700 bg-white border border-red-300 rounded-md shadow hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
