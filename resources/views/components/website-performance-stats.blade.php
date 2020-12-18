<!-- This example requires Tailwind CSS v2.0+ -->
<div class="bg-white">
    <div class="relative">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto md:grid grid-cols-2">
                <dl class="p-6 text-center">
                    <livewire:animated-circle :percent="$overall" :color="$this->getColor($overall)"/>
                    <h3>Overall</h3>
                </dl>
                <dl class="rounded-lg bg-white shadow-lg md:grid grid-cols-2">
                    @foreach($stats as $key => $stat)
                    <div class="flex flex-row items-center justify-start border-b border-r border-gray-100">
                        <dd class="order-1 text-5xl font-extrabold text-indigo-600 w-1/2 h-auto">
                            <livewire:animated-circle :percent="$stat" :color="$this->getColor($stat)"/>
                        </dd>
                        <dt class="flex-grow order-2 mt-2 text-lg leading-6 font-medium text-gray-500">
                            <h5 class="text-sm">{{ ucfirst($key) }}</h5>
                        </dt>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</div>

