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
            <input type="text" wire:model.lazy="website" wire:loading.attr="disabled" cleaname="company_website" id="company_website" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full h-16 text-2xl border-gray-300 rounded-md m-auto" placeholder="www.example.com">
            <svg wire:loading.delay class="absolute top-1/4 right-0 animate-spin -ml-1 mr-3 h-5 w-5 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        @error('website') <div class="p-4 mt-5 bg-red-50 text-red-500 rounded" id="website-error" wire:loading.remove>{{ $message }}</div> @enderror
    </div>
    @if ($stats)
        <div class="text-center w-3/4 m-auto">
            <p>These scores which represent the end user experience are based on a scale of 0 - 100. Read more about what each score represents here <a class="text-blue-400 underline" href="https://web.dev/performance-scoring/" target="_blank" title="https://web.dev/performance-scoring/">https://web.dev/performance-scoring</a>.</p>
        </div>
        <div class="my-20" wire:loading.remove>
            @component('components.website-performance-stats', ['stats' => $stats, 'overall' => $overall])@endcomponent
        </div>
        <div class="text-center m-auto">
            <h2 class="mb-4">Based on this report we have indentified opportunities in which yu can provided a better end user experience.</h2>
            <a href="#contact-us" class="bg-green-400 p-4 rounded text-white font-weight-bold block w-40 m-auto">Learn More</a>
        </div>
    @endif
    <div class="my-10">
        <div class="rounded bg-black text-white p-4 pb-6 mt-5">
            <h3 class="font-bold text-2xl leading-tight mb-1.5">Did you know?</h3>
            <div class="pt-1" x-text="quote"
            ></div>
        </div>
    </div>
</div>