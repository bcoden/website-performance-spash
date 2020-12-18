<div>
    <div class="grid grid-cols-1 md:grid-cols-2 bg-gray-50 w-full rounded p-3 shadow mt-5">
        <div>
            <h2>This is a great form</h2>
            <p>We would love to hear from you please fill out the form and we will get back to you as soon as possile.</p>
        </div>
        <div>
            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session('success_message') }}
                </div>
            @endif
            <form wire:submit.prevent="submitForm" method="post">
                @csrf
                <div class="form-element">
                    <label for="name">Name</label>
                    <input type="text" wire:model.lazy="name" name="name" placeholder="Name" class="border-gray-50 rounded w-full p-2"/>
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-element">
                    <label for="name">Email</label>
                    <input type="text" wire:model.lazy="email" name="email" placeholder="Email" class="border-gray-50 rounded w-full p-2"/>
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-element">
                    <label for="name">Phone</label>
                    <input type="text" wire:model.lazy="phone" name="phone" placeholder="Phone" class="border-gray-50 rounded w-full p-2"/>
                    @error('phone') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-element">
                    <label for="name">Message</label>
                    <textarea name="message" wire:model.lazy="message" placeholder="Messaage" class="border-gray-50 rounded w-full p-2"></textarea>
                    @error('message') <span class="error">{{ $message }}</span> @enderror
                </div>
                <button class="bg-black text-white rounded p-2 disabled:opacity-50 inline-flex" type="submit">
                    <svg wire:loading wire:target="submitForm" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading wire:target="submitForm">Processing</span>
                    <span wire:loading.remove>Submit</span>
                </button>
            </form>
        </div>
    </div>
</div>
