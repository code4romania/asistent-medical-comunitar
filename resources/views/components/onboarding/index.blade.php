@props(['onboarding'])

@php
    $nextUnfinishedStep = $onboarding->nextUnfinishedStep();
@endphp

<nav class="flex justify-center">
    <ol class="lg:flex lg:items-center">
        @foreach ($onboarding->steps as $step)
            <x-onboarding.step :step="$step" :current="$step === $nextUnfinishedStep" :last="$loop->last" />
        @endforeach
    </ol>
</nav>
