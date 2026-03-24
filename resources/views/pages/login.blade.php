@extends('layouts.layout')

@section('content')
<div class="relative min-h-screen flex items-center justify-start p-4 md:p-20 lg:px-30">
    <div class="w-full flex flex-col gap-36 items-start md:p-10 lg:p-20">
        <x-forms.container 
            class="w-full max-w-sm flex flex-col gap-8 items-start"
            action="{{ route('login.post') }}"
            method="POST"
        >
            <div class="flex flex-col gap-2 w-full">
                <x-forms.label
                    for="email"
                    value="Email"
                    class="font-bold"
                />
                <x-forms.input
                    name="email"
                    type="email"
                    placeholder="Enter your email"
                    class="w-full bg-secondary border border-primary py-2 px-4 placeholder:text-[#00000033]"
                />
            </div>
            <div class="flex flex-col gap-2 w-full">
                <x-forms.label
                    for="password"
                    value="Password"
                    class="font-bold text-base"
                />
                <x-forms.input
                    name="password"
                    type="password"
                    placeholder="Enter your password"
                    class="w-full bg-secondary border border-primary py-2 px-4 placeholder:text-[#00000033]"
                />
            </div>
            <x-ui.button type="submit" variant="primary" class="w-full">
                LOG IN
            </x-ui.button>
        </x-forms.container>
        <div class="flex flex-col gap-8">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-serif italic">RV Singbenco Dental Clinic</h1>
            <div class="flex flex-col font-mono items-start text-sm md:text-base">
                <p>1 UNIT SAKURA ARCADE, SAKURA TOWN CENTER</p>
                <p>GM CORDOVA AVE. BRGY. MANDALAGAN BACOLOD CITY 6100</p>
                <p>+63 917 700 9767</p>
            </div>
        </div>
    </div>

    <svg class="absolute right-0 top-1/2 -translate-y-1/2 h-[60vh] lg:h-[80vh] -z-50" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 570 784" fill="none">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M570 3.12563C499.665 -10.0837 430.509 46.8669 349.135 46.8669C231.63 46.8669 133.088 -78.1394 30.7825 80.1625C-52.6528 209.257 59.9589 355.245 59.9589 444.247C59.9589 591.122 90.453 784 167.112 784C276.147 784 237.559 492.565 351.677 492.565C465.794 492.565 404.806 782.473 537.229 782.473C549.341 782.473 560.233 778.221 570 770.491V3.12563Z" fill="url(#paint0_linear_1762_1252)"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M570 3.12563C499.665 -10.0837 430.509 46.8669 349.135 46.8669C231.63 46.8669 133.088 -78.1394 30.7825 80.1625C-52.6528 209.257 59.9589 355.245 59.9589 444.247C59.9589 591.122 90.453 784 167.112 784C276.147 784 237.559 492.565 351.677 492.565C465.794 492.565 404.806 782.473 537.229 782.473C549.341 782.473 560.233 778.221 570 770.491V3.12563Z" fill="#9BECF7"/>
        <defs>
            <linearGradient id="paint0_linear_1762_1252" x1="285" y1="0" x2="285" y2="784" gradientUnits="userSpaceOnUse">
                <stop offset="0.365385" stop-color="white"/>
                <stop offset="0.759615" stop-color="#FFC400"/>
                <stop offset="1" stop-color="#997500"/>
            </linearGradient>
        </defs>
    </svg>
</div>
@endsection
