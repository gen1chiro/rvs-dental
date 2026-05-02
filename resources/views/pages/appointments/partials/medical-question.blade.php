@php
    $questionId = (int) $question->question_id;
    $answer = $resolveAnswer($questionId);
    $notes = $resolveNotes($questionId);
    $bloodTypeOptions = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Unknown'];
    $notesValue = old("responses.{$questionId}.notes", $notes);
@endphp

<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6">
        <label class="font-bold text-sm md:text-base">
            {{ (!$isFemale && $questionId > 9) ? $questionId - 3 : ($isFemale && $questionId > 12 ? $questionId - 2 : $questionId) }}. {{ $question->question }}
        </label>

        @if (in_array($questionId, $radioOnly, true) || in_array($questionId, $radioWithNotes, true))
            <div class="flex flex-wrap items-center gap-4 md:shrink-0">
                @foreach (['Yes', 'No'] as $option)
                    <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                        <input
                            type="radio"
                            name="responses[{{ $questionId }}][answer]"
                            value="{{ $option }}"
                            class="h-4 w-4 accent-primary"
                            @checked($answer === $option)
                        >
                        <span>{{ $option }}</span>
                    </label>
                @endforeach
            </div>
        @endif
    </div>

    <div class="flex-1 w-full space-y-3">

        @if ($questionId === 13)
            <div class="flex flex-wrap items-center gap-4">
                @foreach ($bloodTypeOptions as $option)
                    <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                        <input
                            type="radio"
                            name="responses[{{ $questionId }}][notes]"
                            value="{{ $option }}"
                            class="h-4 w-4 accent-primary"
                            @checked($notesValue === $option)
                        >
                        <span>{{ $option }}</span>
                    </label>
                @endforeach
            </div>
        @elseif (in_array($questionId, $radioWithNotes, true) || in_array($questionId, $textOnly, true))
            <input
                type="text"
                name="responses[{{ $questionId }}][notes]"
                class="w-full border border-border bg-white rounded-sm px-4 py-2 focus:outline-none focus:ring-1 focus:ring-primary"
                value="{{ $notesValue }}"
            >
        @endif

        @error("responses.{$questionId}.answer")
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        @error("responses.{$questionId}.notes")
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
</div>
