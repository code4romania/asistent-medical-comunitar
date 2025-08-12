<div class="relative flex items-center justify-between gap-4">
    <div class="flex gap-1 truncate">
        <span>#{{ $intervention->id }}</span>
        <span>-</span>
        <span class="truncate">{{ $intervention->service_name }}</span>
    </div>

    @if ($intervention->appointment_id !== null && $intervention->appointment_id !== $appointment->id)
        <x-heroicon-o-exclamation class="w-6 h-6 text-warning-500" />
    @endif
</div>
