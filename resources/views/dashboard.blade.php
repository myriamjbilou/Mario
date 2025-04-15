<x-app-layout>
    <x-slot name="header">
        <h2 class="sr-only">Dashboard</h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Bloc principal avec texte et logo --}}
            <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-gray-800 via-gray-900 to-black p-8 flex flex-col items-center">

                {{-- Texte --}}
                <div class="text-white text-2xl font-bold tracking-wide animate-fade-in-slow opacity-50 select-none text-center mb-8">
                    Bienvenue dans <span class="text-[#ff2d20]">la gestion des films</span> !
                </div>

                {{-- Logo centré avec animation sans ombre --}}
                <img src="{{ asset('images/logo.png') }}" alt="Logo de l'application"
                    class="h-24 w-auto opacity-80 animate-fade-in-out">
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in-slow {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 0.5;
                transform: translateY(0);
            }
        }

        .animate-fade-in-slow {
            animation: fade-in-slow 1.5s ease-out forwards;
        }

        @keyframes fade-in-out {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            20% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                opacity: 1;
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(0.9);
            }
        }

        .animate-fade-in-out {
            animation: fade-in-out 4s ease-in-out forwards;
        }

    </style>
</x-app-layout>