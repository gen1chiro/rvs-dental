<div class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-xl shadow-md p-10 font-serif text-gray-900">
    <div class="flex justify-between items-start mb-8">
        <div class="w-10"> 
            <svg width="30" height="39.375" viewBox="0 0 30 39.375" fill="none" class="w-full h-auto">
                <path d="[SVG_PATH_DATA_HERE]" fill="#66D1D1" /> // to be updated
            </svg>
        </div>
        <div class="flex space-x-3 font-sans mt-1"> 
            <div class="bg-[#1A625E] text-white text-[0.65rem] font-bold px-4 py-1.5 rounded-full tracking-widest uppercase">
                LATEST
            </div>
            <div class="bg-[#66D1D1] text-white text-[0.65rem] font-bold px-4 py-1.5 rounded-full tracking-widest uppercase">
                VERIFIED
            </div>
        </div>
    </div>
    
    <h1 class="text-4xl text-gray-900 mb-8 tracking-tight">Dental Certificate</h1>
    
    <div class="space-y-5 text-[1.15rem] leading-relaxed">
        <p class="italic">
            This is to certify that <strong class="font-bold">{{ $patient->first_name }} {{ $patient->last_name }}</strong>, 
            age <strong class="font-bold">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</strong>,
            examined on <strong class="font-bold">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('F d, Y') }}</strong>, 
            address <strong class="font-bold">{{ $patient->address }}</strong>, 
            underwent the following procedure(s): <strong class="font-bold">@foreach($appointment->appointmentProcedures as $ap){{ $ap->procedure->name }}{{ !$loop->last ? ' & ' : '' }}@endforeach</strong>.
        </p>
        
        @foreach($appointment->appointmentProcedures as $ap)
            @if($ap->notes)
                <p class="italic">Recommendation for <strong>{{ $ap->procedure->name }}</strong>: <strong>{{ $ap->notes }}</strong></p>
            @endif
        @endforeach
        
        <p class="italic">
            This certificate is issued upon the patient's request for whatever purpose it may serve. 
            The undersigned shall not be held liable for any legal implications arising from the use of this certificate.
        </p>
        
        <div class="flex justify-between items-end pt-10">
            <div class="max-w-[55%]">
                <p class="italic mb-6">Issued on {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('F d, Y') }}.</p>
                <p class="text-[0.65rem] leading-tight text-gray-600 italic">
                    This Dental Certificate is printed using PIMS owned by RV SingBenco Dental Clinic. 
                    If the name of the owner and clinic did not match with letterhead this Dental Certificate 
                    is invalid because this copy of PIMS is not genuine.
                </p>
            </div>
            <div class="flex flex-col items-start not-italic text-[1.05rem]">
                <p class="italic mb-1">sgd.</p>
                <p class="font-bold doctor-name">Dr. {{$dentist->first_name}} {{$dentist->last_name}}</p>
                <p>License No. {{ $dentist->license_no }}</p>
                <p>FTR No: _______</p>
            </div>
        </div>
    </div>
</div>