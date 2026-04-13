<div class="flex flex-col gap-1">
    <label for="{{$fieldName}}" class="font-bold text-sm md:text-base">Assigned Dentist</label>
    <select 
        name="{{$fieldName}}" 
        id="{{$fieldName}}"
        @required($isRequired)
    >
        <option value="">
            {{ $dentists->isEmpty() ? 'No dentists available.' : 'Select a dentist.' }}
        </option>

        @foreach ($dentists as $dentist)
            <option 
                value="{{ $dentist->dentist_id }}"
                @selected(old($fieldName, $selected) == $dentist->dentist_id)
            >
                Dr. {{ $dentist->full_name }}            
            </option>
        @endforeach
    </select>
</div>