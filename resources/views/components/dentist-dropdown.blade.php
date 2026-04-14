<div class="flex flex-col gap-1 w-full">
    <select 
        name="{{$fieldName}}" 
        id="{{$fieldName}}"
        @required($isRequired)
        class="w-full bg-white border border-gray-300 focus:border-primary focus:ring-1 focus:ring-primary rounded-lg px-4 py-2 outline-none font-mono cursor-pointer"
    >
        <option value="" class="font-mono">
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