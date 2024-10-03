<div @if ($shouldPoll) wire:poll.5s.visible @endif>
    {{ $getChildComponentContainer() }}
</div>
