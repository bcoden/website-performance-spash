<div class="w-full" x-data="websiteAnalytics()" x-init="scaffold()">
    <div class="my-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Are you getting the most out of your website?
                </h2>
                <p class="mt-3 text-xl text-gray-500 sm:mt-4">
                    Enter your website url in the field below to see how you are doing.
                </p>
            </div>
        </div>
    </div>
    <div class="my-10">
        <div class="relative">
            <input type="text" wire:model.lazy="website" wire:loading.attr="disabled" cleaname="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full border-gray-300 rounded-md" placeholder="www.example.com">
            <svg wire:loading.delay class="absolute top-1/4 right-0 animate-spin -ml-1 mr-3 h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
    @if ($stats)
        <div class="my-20" wire:loading.remove>
            @component('components.website-performance-stats', ['stats' => $stats, 'overall' => $overall])@endcomponent
        </div>
    @endif
    <div class="my-10">
        @error('website') <div class="p-4 mt-5 bg-red-50 text-red-500 rounded" id="website-error" wire:loading.remove>{{ $message }}</div> @enderror
        <div class="rounded bg-black text-white p-4 mt-5">
            <span class="font-bold">Did you know?</span>
            <div class="pt-1" x-text="quote"></div>
        </div>
    </div>
</div>