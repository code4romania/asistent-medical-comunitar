<div {{ $getExtraAttributeBag() }}>
    @php
        $file = $getState();
    @endphp

    @switch($file?->type)
        @case('image')
            <img
                src="{{ $file->getFullUrl() }}"
                alt="{{ $file->original_file_name }}"
                class="w-full" />
        @break

        @case('pdf')
            <iframe
                src="{{ $file->getFullUrl() }}"
                title="{{ $file->original_file_name }}"
                class="w-full h-screen">
            </iframe>
        @break

        @default
            <x-filament::empty-state
                icon="icon-empty-state"
                :heading="__('document.empty_preview.title')"
                :description="__('document.empty_preview.description')" />
    @endswitch
</div>
