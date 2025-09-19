{{-- File: resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
        <title>Hospital Management System</title>
    </head>
    <body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-blue-100 bg-center selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-white text-blue-600 border border-blue-500 rounded-md font-semibold shadow transition hover:scale-105 hover:shadow-2xl">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 px-5 py-2 bg-white text-green-600 border border-green-500 rounded-md font-semibold shadow transition hover:scale-105 hover:shadow-2xl">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <h1 id="animated-title" class="text-4xl font-bold text-gray-900 h-16 flex items-center justify-center"></h1>
                    <script>
                        const titleEl = document.getElementById("animated-title");
                        let step = 0;
                        function animateTitle() {
                            if (step === 0) {
                                titleEl.innerHTML = `<span id='word-hospital' style='opacity:0; position:relative; left:20px;'>Hospital</span>`;
                                setTimeout(() => {
                                    document.getElementById('word-hospital').style.transition = 'opacity 0.7s, left 0.7s';
                                    document.getElementById('word-hospital').style.opacity = 1;
                                    document.getElementById('word-hospital').style.left = '0px';
                                }, 100);
                                setTimeout(() => { step++; animateTitle(); }, 1200);
                            } else if (step === 1) {
                                titleEl.innerHTML = `<span id='word-hospital'>Hospital</span>&nbsp;&nbsp;<span id='word-appointment' style='opacity:0; position:relative; left:20px;'>Appointment</span>`;
                                setTimeout(() => {
                                    document.getElementById('word-appointment').style.transition = 'opacity 0.7s, left 0.7s';
                                    document.getElementById('word-appointment').style.opacity = 1;
                                    document.getElementById('word-appointment').style.left = '0px';
                                }, 100);
                                setTimeout(() => { step++; animateTitle(); }, 1200);
                            } else if (step === 2) {
                                titleEl.innerHTML = `<span id='word-hospital'>Hospital</span>&nbsp;&nbsp;<span id='word-appointment'>Appointment</span>&nbsp;&nbsp;<span id='word-system' style='opacity:0; position:relative; left:20px;'>System</span>`;
                                setTimeout(() => {
                                    document.getElementById('word-system').style.transition = 'opacity 0.7s, left 0.7s';
                                    document.getElementById('word-system').style.opacity = 1;
                                    document.getElementById('word-system').style.left = '0px';
                                }, 100);
                                setTimeout(() => { step++; animateTitle(); }, 1200);
                            } else {
                                titleEl.innerHTML = `<span id='word-hospital'>Hospital</span>&nbsp;&nbsp;<span id='word-appointment'>Appointment</span>&nbsp;&nbsp;<span id='word-system'>System</span>`;
                            }
                        }
                        animateTitle();
                    </script>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div class="scale-100 p-10 min-h-[20rem] w-full bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex flex-col justify-center motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">For Patients</h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    Book appointments with our expert doctors, manage your healthcare records, and stay connected with your medical team.
                                </p>
                            </div>
                        </div>
                        <div class="scale-100 p-10 min-h-[20rem] w-full bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex flex-col justify-center motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">For Healthcare Providers</h2>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    Manage patient appointments, access medical records, and streamline your practice with our comprehensive tools.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>