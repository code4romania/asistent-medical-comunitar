
@if($this->getNotification() !== null)
    <x-filament::widget class="dashboard-notification-widget" id="dashboard-notification">
        <div id="dashboard-notification" class="py-3 px-8 bg-[#FEFAEA] border border-[#FBBF24] rounded-lg">
            <div class="flex justify-between items-center">
                <div class="flex flex-row gap-3 items-center">
                    <img src="{{Vite::asset($this->getNotificationIcon())}}" alt="warning icon" class="w-10 h-10">
                    <p class="text-base font-medium">{{$this->getNotification()}}</p>
                    @if(auth()->user()->isCoordinator())
                        <a href="{{route('filament.resources.users.index')}}" class="underline font-bold">Vezi lista →</a>
                    @endif
                </div>
                @if(!auth()->user()->isCoordinator() && !$this->hideDismissButton)
                <div class="flex items-center">
                    <button wire:click="dismissNotification" class="focus:outline-none" onclick="hideNotification()">
                        <img src="{{Vite::asset('resources/svg/dismiss.svg')}}" alt="dismiss icon" class="w-6 h-6">
                    </button>
                </div>
                @endif
            </div>
        </div>
    </x-filament::widget>
@else
    <div class="hidden"></div>
@endif
