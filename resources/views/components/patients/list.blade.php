@foreach($patients as $patient)
    <x-patients.item :patient="$patient" />
@endforeach
