@foreach($appointments as $date => $items)
    <div class="px-6 py-4 border-t border-edge bg-gray-50 sticky top-0 z-10 animate-fade-in-up">
        <h2 class="text-base font-bold text-gray-900">{{ $date }}</h2>
    </div>

    <div class="divide-y divide-edge">
        @foreach($items as $item)
            <x-appointments.item
                :appointmentId="$item['appointment_id']"
                :name="$item['name']"
                :remarks="$item['remarks']"
                :status="$item['status']"
                :color="$item['color']"
            />
        @endforeach
    </div>
@endforeach
