<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ $title ?? 'Page Title' }}</title>

    <link rel="manifest" href="/manifest.json" />

    @vite('resources/css/app.css')
    {{-- Notfys --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>

<body>
    <main class="w-full bg-no-repeat bg-cover bg-[rgba(0,0,0,.5)] bg-blend-darken bg-center"
        style="background-image: url('{{ asset('assets/images/authentication-bg.png') }}')">
        <div class="min-h-screen max-w-xl container mx-auto">
            {{ $slot }}
        </div>
    </main>
    {{-- Notfy --}}
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    {{-- Flowbite --}}
    <script src="{{ asset('build/assets/app-DdQ1e7RN.js') }}"></script>
    <script src="{{ asset('assets/js/flowbite.min.js') }}"></script>
    {{-- Lottie --}}
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <script>
        const sendNotfy = new Notyf({
            duration: 3000,
            position: {
                x: 'center',
                y: 'bottom',
            },
            types: [{
                type: 'info',
                className: 'bg-ocean-600',
                icon: false
            }, {
                type: 'default',
                className: 'bg-gray-600',
                icon: false
            }]
        });
        initFlowbite()
        document.addEventListener('livewire:init', () => {
            Livewire.on('notify', (payload) => {
                switch (payload.type) {
                    case 'success':
                        sendNotfy.success(payload.message);
                        break;
                    case 'error':
                        sendNotfy.error(payload.message)
                        break;
                    case 'info':
                        sendNotfy.open({
                            type: 'info',
                            message: payload.message
                        });
                        break;
                    default:
                        sendNotfy.open({
                            type: 'default',
                            message: 'Something went wrong'
                        });
                        break;
                }
            });
        });
    </script>
</body>

</html>
