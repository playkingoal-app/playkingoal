<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') |
        @endif {{ __('navbar.name') }}
    </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    {{-- <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('estilos.css') }}?v={{ time() }}">

    <!-- datatable -->
    @yield('css')

    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div id="app">


        <button id="toggleBtn" class="toggle-btn" onclick="toggleSidebar()" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div id="langSelector" class="language-dropdown">
            <div class="selected-lang" onclick="toggleLangDropdown()">
                @if (app()->getLocale() === 'en')
                    <img src="{{ asset('img/en.png') }}?v={{ time() }}" alt="EN">
                @elseif (app()->getLocale() === 'fr')
                    <img src="{{ asset('img/fr.png') }}?v={{ time() }}" alt="FR">
                @else
                    <img src="{{ asset('img/es.png') }}?v={{ time() }}" alt="ES">
                @endif
            </div>

            <div id="langDropdown" class="lang-options">
                <form action="{{ route('change.language') }}" method="POST">
                    @csrf
                    <button type="submit" name="locale" value="en">
                        <img src="{{ asset('img/en.png') }}" alt="en"> {{ __('navbar.language_english') }}
                    </button>
                    <button type="submit" name="locale" value="fr">
                        <img src="{{ asset('img/fr.png') }}" alt="fr"> {{ __('navbar.language_french') }}
                    </button>
                    <button type="submit" name="locale" value="es">
                        <img src="{{ asset('img/es.png') }}" alt="es"> {{ __('navbar.language_spanish') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Overlay -->
        <div class="overlay" onclick="closeSidebar()"></div>


        <!-- Sidebar -->
        <div class="sidebar">
            <button class="toggle-btn-close" type="button" aria-label="Cerrar menú">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <a class="navbar-brand" href="{{ url('/home') }}">El Rey Del Gol</a>

            @auth()
                <ul class="nav flex-column">
                    @role('Administrador')
                        @can('modulo-pronosticos')
                            <li class="nav-item">
                                <a href="{{ url('/predictions') }}" class="nav-link"><i
                                        class="fa-solid fa-circle-nodes"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.my_predictions') }}</a>
                            </li>
                        @endcan
                        @can('modulo-resultados')
                            <li class="nav-item">
                                <a href="{{ url('/results') }}" class="nav-link"> <i class="fa-solid fa-chart-simple"
                                        style="color: #ff6600 !important"></i>
                                    {{ __('navbar.results') }}</a>
                            </li>
                        @endcan


                        @can('modulo-equipos')
                            <li class="nav-item">
                                <a href="{{ url('/teams') }}" class="nav-link"><i
                                        class="fa-solid fa-shield-halved"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.teams') }}</a>
                            </li>
                        @endcan
                        @can('modulo-torneos')
                            <li class="nav-item">
                                <a href="{{ url('/tournaments') }}" class="nav-link"><i
                                        class="fa-solid fa-trophy"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.tournaments') }}</a>
                            </li>
                        @endcan
                        @can('modulo-jornadas')
                            <li class="nav-item">
                                <a href="{{ url('/matchdays') }}" class="nav-link"><i class="bi bi-calendar-day"></i>
                                    {{ __('navbar.rounds') }}</a>
                            </li>
                        @endcan
                        @can('modulo-partidos')
                            <li class="nav-item">
                                <a href="{{ url('/matches') }}" class="nav-link"><i
                                        class="fa-solid fa-futbol"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.matches') }}</a>
                            </li>
                        @endcan
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/my-invitations') }}"><i
                                        class="fa-solid fa-envelope-circle-check" style="color: #ff6600 !important"></i>
                                    {{ __('navbar.my_invitations') }}

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/groups') }}" class="nav-link"><i
                                        class="fa-solid fa-users"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.my_groups') }}
                                </a>
                            </li>
                        <li class="nav-item">
                            <a href="{{ url('/allpredictions') }}" class="nav-link"><i class="bi bi-clipboard2-data-fill"></i>
                                {{ __('navbar.predictions') }}</a>
                        </li>



                        <li class="nav-item">
                            <a href="{{ url('/standings') }}" class="nav-link"><i
                                    class="fa-solid fa-ranking-star text-info "style="color: #ff6600 !important"></i>
                                {{ __('navbar.standings') }}</a>
                        </li>
                        @can('modulo-perfil')
                            <li class="nav-item">
                                <a href="{{ url('/profile') }}" class="nav-link"><i class="bi bi-person-circle"></i>
                                    {{ __('navbar.profile') }}</a>
                            </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ url('/rules') }}" class="nav-link"><i
                                    class="fa-solid fa-handshake-angle text-info"style="color: #ff6600 !important"></i>
                                {{ __('navbar.rules') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/registrations') }}" class="nav-link"><i
                                    class="fa-solid fa-star"style="color: #ff6600 !important"></i>
                                {{ __('navbar.registrations') }}</a>
                        </li>
                    @endrole

                    @role('Jugador')
                        @if (auth()->user()->tieneInscripcionActiva())
                            @if (auth()->user()->tieneSuscripcionActiva())
                                <li class="nav-item">
                                    <a href="{{ url('/matchdays') }}" class="nav-link">
                                        <i class="bi bi-calendar-day"></i>
                                        {{ __('navbar.rounds') }}
                                    </a>
                                </li>
                            @endif
                            @can('modulo-pronosticos')
                                <li class="nav-item">
                                    <a href="{{ url('/predictions') }}" class="nav-link"><i
                                            class="fa-solid fa-circle-nodes"style="color: #ff6600 !important"></i>
                                        {{ __('navbar.my_predictions') }}</a>
                                </li>
                            @endcan
                            @can('modulo-resultados')
                                <li class="nav-item">
                                    <a href="{{ url('/results') }}" class="nav-link"> <i class="fa-solid fa-chart-simple"
                                            style="color: #ff6600 !important"></i>
                                        {{ __('navbar.results') }}</a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ url('/allpredictions') }}" class="nav-link"><i
                                        class="bi bi-clipboard2-data-fill"></i>
                                    {{ __('navbar.predictions') }}</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/standings') }}" class="nav-link"><i
                                        class="fa-solid fa-ranking-star text-info "style="color: #ff6600 !important"></i>
                                    {{ __('navbar.standings') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/rules') }}" class="nav-link"><i
                                        class="fa-solid fa-handshake-angle text-info"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.rules') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/registrations') }}" class="nav-link"><i
                                        class="fa-solid fa-star"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.registrations') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/my-invitations') }}"><i
                                        class="fa-solid fa-envelope-circle-check" style="color: #ff6600 !important"></i>
                                    {{ __('navbar.my_invitations') }}

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/groups') }}" class="nav-link"><i
                                        class="fa-solid fa-users"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.my_groups') }}
                                </a>
                            </li>
                            @can('modulo-perfil')
                                <li class="nav-item">
                                    <a href="{{ url('/profile') }}" class="nav-link"><i class="bi bi-person-circle"></i>
                                        {{ __('navbar.profile') }}</a>
                                </li>
                            @endcan
                        @else
                            @if (auth()->user()->tieneSuscripcionActiva())
                                <li class="nav-item">
                                    <a href="{{ url('/matchdays') }}" class="nav-link">
                                        <i class="bi bi-calendar-day"></i>
                                        {{ __('navbar.rounds') }}
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ url('/rules') }}" class="nav-link"><i
                                        class="fa-solid fa-handshake-angle text-info"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.rules') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/registrations') }}" class="nav-link"><i
                                        class="fa-solid fa-star"style="color: #ff6600 !important"></i>
                                    {{ __('navbar.registrations') }}</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/plans') }}" class="nav-link"><i class="fa-solid fa-bag-shopping"
                                        style="color: #ff6600 !important"></i>
                                    {{ __('navbar.plans') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/groups') }}" class="nav-link"><i class="fa-solid fa-users"
                                        style="color: #ff6600 !important"></i>
                                    {{ __('navbar.my_groups') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/my-invitations') }}"><i
                                        class="fa-solid fa-envelope-circle-check" style="color: #ff6600 !important"></i>
                                    {{ __('navbar.my_invitations') }}
                                </a>
                            </li>
                            @can('modulo-perfil')
                                <li class="nav-item">
                                    <a href="{{ url('/profile') }}" class="nav-link"><i class="bi bi-person-circle"></i>
                                        {{ __('navbar.profile') }}</a>
                                </li>
                            @endcan
                        @endif
                    @endrole

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket"></i> {{ __('navbar.logout') }}
                            </a>
                            <a href="{{ url('/password') }}" class="dropdown-item">
                                <i class="fa-solid fa-file-pen "></i> {{ __('navbar.change_password') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>

                <div class="user-box">
                    <h6>{{ Auth::user()->name }}</h6>

                </div>
            @endauth()
        </div>



        <!-- Contenido principal -->
        <div class="content p-4">
            <main class="py-5">
                @yield('content')
            </main>
        </div>





        @livewireScripts
        @yield('js')
        @stack('custom-scripts')




        <script type="module">
            const addModal = new bootstrap.Modal('#createDataModal');
            const editModal = new bootstrap.Modal('#updateDataModal');
            window.addEventListener('closeModal', () => {

                addModal.hide();
                editModal.hide();
            })
        </script>

        <script>
            Livewire.on('bloqueado', () => {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El partido ya inicio, no se puede pronosticar.',
                }).then((result) => {
                    if (result.isConfirmed) {

                    }
                })
            });
        </script>

        <script>
            // IDIOMA
            function toggleLangDropdown() {
                const dropdown = document.getElementById('langDropdown');
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            }

            // Cerrar al hacer clic fuera
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('langDropdown');
                const selector = document.querySelector('.language-dropdown');
                if (!selector.contains(event.target)) {
                    dropdown.style.display = 'none';
                }
            });
        </script>
        <script>
            const toggleBtn = document.getElementById('toggleBtn');
            const langSelector = document.getElementById('langSelector');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');
            const closeBtn = document.querySelector('.toggle-btn-close');

            function hideTopControls() {
                toggleBtn?.classList.add('hidden-control');
                langSelector?.classList.add('hidden-control');
            }

            function showTopControls() {
                toggleBtn?.classList.remove('hidden-control');
                langSelector?.classList.remove('hidden-control');
            }

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');

                if (sidebar.classList.contains('show')) {
                    hideTopControls();
                } else if (window.scrollY <= 1) {
                    showTopControls();
                }
            }

            function closeSidebar() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');

                if (window.scrollY <= 1) {
                    showTopControls();
                }
            }

            closeBtn?.addEventListener('click', closeSidebar);
            overlay?.addEventListener('click', closeSidebar);

            window.addEventListener('scroll', () => {
                if (sidebar.classList.contains('show')) {
                    hideTopControls();
                    return;
                }

                if (window.scrollY <= 1) {
                    showTopControls();
                } else {
                    hideTopControls();
                }
            });

            function toggleLangDropdown() {
                const dropdown = document.getElementById('langDropdown');

                dropdown.style.display =
                    dropdown.style.display === 'block' ? 'none' : 'block';
            }

            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('langDropdown');
                const selector = document.querySelector('.language-dropdown');

                if (selector && !selector.contains(event.target)) {
                    dropdown.style.display = 'none';
                }
            });
        </script>


</body>

</html>
