@props(['onboarding'])

@php
    $nextUnfinishedStep = $onboarding->nextUnfinishedStep();
@endphp

<nav class="flex justify-center py-4 lg:py-8">
    <ol class="w-full lg:flex">
        @foreach ($onboarding->steps as $step)
            <x-onboarding.step
                :step="$step"
                :current="$step === $nextUnfinishedStep"
                :loop="$loop" />
        @endforeach
    </ol>
</nav>
