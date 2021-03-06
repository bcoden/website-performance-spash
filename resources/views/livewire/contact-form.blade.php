<div class="relative bg-white my-10 w-full pl-8 pr-8 pb-8">
    <a id="contact-us"></a>
    <div class="relative md:grid md:grid-cols-2 ">
        <div class="bg-gray-100 p-10 flex flex-col justify-content-center">
            <div class="max-w-lg mx-auto my-auto">
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                    {{ __('Get in touch') }}
                </h2>
                <p class="mt-3 text-lg leading-6 text-gray-500">
                    {{__('If you would like to learn more about how you can improve your website user experience please contact us.') }}
                </p>
                <dl class="mt-8 text-base text-gray-500">
                    <div class="mt-6">
                        <dt class="sr-only">{{ ucfirst(__('views.phoneNumber')) }}</dt>
                        <dd class="flex">
                            <!-- Heroicon name: phone -->
                            <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="ml-3">(360) 218-4351</span>
                        </dd>
                    </div>
                    <div class="mt-3">
                        <dt class="sr-only">{{ ucfirst(__('views.email')) }}</dt>
                        <dd class="flex">
                            <!-- Heroicon name: mail -->
                            <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="ml-3">joemccorison@gmail.com</span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        <div class="bg-white p-10">
            <div class="max-w-lg mx-auto lg:max-w-none">

                @if (session()->has('success_message'))
                    <div class="bg-green-600 mb-5 text-white rounded p-4 alert alert-success">
                        {{ session('success_message') }}
                    </div>
                @elseif(session()->has('error_message'))
                    <div class="bg-red-600 mb-5 text-white rounded p-4 alert alert-success">
                        {{ session('error_message') }}
                    </div>
                @endif

                @if (!session()->has('success_message'))
                <form wire:submit.prevent="submitForm" method="post" class="grid grid-cols-1 gap-y-6">
                    @csrf
                    <div>
                        <label for="full_name" class="sr-only">{{ ucfirst(__('views.fullname')) }}</label>
                        <input wire:model.lazy="name" type="text" name="name" id="name" autocomplete="name" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="{{ ucfirst(__('views.fullname')) }}">
                        @error('name') <div class="text-red-500 font-weight-bold mt-2 error">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="email" class="sr-only">{{ ucfirst(__('views.email')) }}</label>
                        <input wire:model.lazy="email" id="email" name="email" type="email" autocomplete="email" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="{{ ucfirst(__('views.email')) }}">
                        @error('email') <div class="text-red-500 font-weight-bold mt-2 error">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="phone" class="sr-only">{{ ucfirst(__('views.phoneNumber')) }}</label>
                        <input wire:model.lazy="phone" type="text" name="phone" id="phone" autocomplete="tel" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="{{ ucfirst(__('views.phoneNumber')) }}">
                        @error('phone') <div class="text-red-500 font-weight-bold mt-2 error">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label for="message" class="sr-only">{{ ucfirst(__('views.message')) }}</label>
                        <textarea wire:model.lazy="message" id="message" name="message" rows="4" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="{{ ucfirst(__('views.message')) }}"></textarea>
                        @error('message') <div class="text-red-500 font-weight-bold mt-2 error">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <button class="bg-blue-700 text-white rounded p-3 disabled:opacity-50 inline-flex" type="submit">
                            <svg wire:loading wire:target="submitForm" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading wire:target="submitForm">{{ ucfirst(__('views.processing')) }}</span>
                            <span wire:loading.remove wire:target="submitForm">{{ ucfirst(__('views.submit')) }}</span>
                        </button>
                    </div>

                    <div class="hidden">
                        <input wire:model.lazy="load_time" type="input" name="load_time">
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

