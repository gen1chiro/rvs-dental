<x-forms.container
    action="{{ route('patients.update', $patient) }}"
    method="POST"
>
    @method('PUT')

    <x-ui.button type="submit" variant="primary" class="px-2 py-4">
        Edit
    </x-ui.button>
</x-forms.container>