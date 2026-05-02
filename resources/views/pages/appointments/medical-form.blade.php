@extends('layouts.layout')

@php
    $radioOnly = [1, 6, 7];
    $radioWithNotes = [2, 3, 4, 5, 8];
    $textOnly = [9, 13, 14];

    $stepOne = $questions->whereIn('question_id', [1, 2, 3, 4, 5])->values();
    $stepTwo = $questions->whereIn('question_id', [6, 7, 8, 9])->values();
    $womenOnlyQuestions = $questions->whereIn('question_id', [10, 11, 12])->values();
    $stepThree = $questions->whereNotIn('question_id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])->values();

    $oldResponses = old('responses', []);
    $selectedConditions = collect(old('conditions', $existingConditionIds ?? []))
        ->map(fn ($id) => (int) $id)
        ->all();

    $otherConditionId = (int) ($conditions->firstWhere('condition_name', 'Others')?->id ?? 0);
    $existingOtherConditionNotes = $otherConditionNotes ?? null;
    $oldOtherConditionNotes = old('other_condition_notes');
    $otherConditionNotes = $oldOtherConditionNotes !== null ? $oldOtherConditionNotes : $existingOtherConditionNotes;

    $resolveAnswer = function ($questionId) use ($oldResponses, $existingResponses) {
        $oldValue = data_get($oldResponses, "{$questionId}.answer");
        if ($oldValue !== null) {
            return $oldValue;
        }

        return data_get($existingResponses, "{$questionId}.answer");
    };

    $resolveNotes = function ($questionId) use ($oldResponses, $existingResponses) {
        $oldValue = data_get($oldResponses, "{$questionId}.notes");
        if ($oldValue !== null) {
            return $oldValue;
        }

        return data_get($existingResponses, "{$questionId}.notes");
    };
@endphp

@section('hideNavbar', true)
@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 py-4 md:py-8 mx-4 md:mx-8 border-b border-border sticky top-0 z-50 bg-background">
        <h1 class="text-2xl md:text-5xl">Medical Form</h1>
        <x-ui.button variant="secondary" class="rounded-xl text-xs md:text-sm">
            <a href="{{ route('appointments.view', $appointment) }}">RETURN TO APPOINTMENT</a>
        </x-ui.button>
    </div>

    <x-forms.container action="{{ route('appointments.medical-form.store', $appointment) }}" method="POST" id="medical-form" class="flex flex-col gap-4 w-full md:w-2/3 p-4 md:p-8 font-mono" data-is-female="{{ $isFemale ? '1' : '0' }}">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded p-3">
                    <p class="text-red-500 text-sm">Please fill in all required inputs</p>
                </div>
            @endif

            <section data-step="1" class="form-step space-y-4">
                @foreach ($stepOne as $question)
                    @include('pages.appointments.partials.medical-question', [
                        'question' => $question,
                        'radioOnly' => $radioOnly,
                        'radioWithNotes' => $radioWithNotes,
                        'textOnly' => $textOnly,
                        'resolveAnswer' => $resolveAnswer,
                        'resolveNotes' => $resolveNotes,
                    ])
                @endforeach
            </section>

            <section data-step="2" class="form-step hidden space-y-4">
                @foreach ($stepTwo as $question)
                    @include('pages.appointments.partials.medical-question', [
                        'question' => $question,
                        'radioOnly' => $radioOnly,
                        'radioWithNotes' => $radioWithNotes,
                        'textOnly' => $textOnly,
                        'resolveAnswer' => $resolveAnswer,
                        'resolveNotes' => $resolveNotes,
                    ])
                @endforeach
            </section>

            <section data-step="3" class="form-step hidden space-y-4">
                @if ($isFemale)
                    <div class="flex flex-col gap-3">
                        <p class="font-bold text-sm md:text-base">10. For Women Only</p>

                        @foreach ($womenOnlyQuestions as $question)
                            @php
                                $questionId = (int) $question->question_id;
                                $answer = $resolveAnswer($questionId);
                                $questionText = preg_replace('/^For women only:\s*/i', '', $question->question);
                            @endphp
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                <p class="text-sm">{{ $questionText }}</p>
                                <div class="flex flex-wrap items-center gap-4 md:shrink-0">
                                    @foreach (['Yes', 'No', 'N/A'] as $option)
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
                            </div>

                            @error("responses.{$questionId}.answer")
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        @endforeach
                    </div>
                @endif

                @foreach ($stepThree as $question)
                    @include('pages.appointments.partials.medical-question', [
                        'question' => $question,
                        'radioOnly' => $radioOnly,
                        'radioWithNotes' => $radioWithNotes,
                        'textOnly' => $textOnly,
                        'resolveAnswer' => $resolveAnswer,
                        'resolveNotes' => $resolveNotes,
                    ])
                @endforeach

                <div class="flex flex-col gap-2">
                    <h2 class="font-bold text-sm md:text-base">Medical Conditions</h2>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3 p-4">
                        @foreach ($conditions as $condition)
                            @php
                                $checked = in_array((int) $condition->id, $selectedConditions, true);
                            @endphp
                            <li>
                                <label class="flex items-center gap-3 text-sm cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="conditions[]"
                                        value="{{ $condition->id }}"
                                        @if ($otherConditionId !== 0 && (int) $condition->id === $otherConditionId)
                                            data-other-condition="true"
                                        @endif
                                        class="sr-only peer"
                                        @checked($checked)
                                    >
                                    <span class="h-4 w-4 border border-border rounded-sm peer-checked:bg-primary peer-checked:border-primary"></span>
                                    <span>{{ $condition->condition_name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    <div id="other-condition-notes-wrapper" class="{{ in_array($otherConditionId, $selectedConditions, true) ? '' : 'hidden' }}">
                        <label for="other-condition-notes" class="block text-sm font-bold mb-1">Others (please specify)</label>
                        <input
                            type="text"
                            id="other-condition-notes"
                            name="other_condition_notes"
                            class="w-full border border-border bg-white rounded-sm px-4 py-2 focus:outline-none focus:ring-1 focus:ring-primary"
                            value="{{ $otherConditionNotes }}"
                        >
                        @error('other_condition_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <div class="flex justify-end mt-4 gap-2">
                <x-ui.button type="button" id="prev-step" variant="outline" class="rounded-xl text-xs md:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    Previous
                </x-ui.button>
                <x-ui.button type="button" id="next-step" variant="primary" class="rounded-xl text-xs md:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    Next
                </x-ui.button>
                <x-ui.button type="submit" id="save-form" variant="primary" class="hidden rounded-xl text-xs md:text-sm">
                    Save
                </x-ui.button>
            </div>
    </x-forms.container>
@endsection

@push('scripts')
    @vite(['resources/js/appointments/medical-form.js'])
@endpush
