<header>
    <nav class="navbar navbar-expand-lg p-0">
        <div class="nav-wrap">
            <a class="navbar-brand" href="#">
                {{-- <img src="assets/images/Layer_1.svg" alt=""> --}}
                <h3 style="font-weight: bold">Business Tracking</h3>
            </a>
            <button class="menu" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                onclick="this.classList.toggle('opened');this.setAttribute('aria-expanded', this.classList.contains('opened'))">
                <svg width="400" height="40" viewBox="0 0 100 100">
                    <path class="line line1"
                        d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
                    <path class="line line2" d="M 20,50 H 80" />
                    <path class="line line3"
                        d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
                </svg>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-md-auto ">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Customer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bussiness</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reviews</a>
                    </li>
                   
                </ul>
                <div class="navbar-right">
                    <ul class="navbar-nav navbar-right-link">
                        @if (Route::has('login'))
                            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                                @auth
                                    <!-- Authenticated User -->
                                    <a href="{{ url('/dashboard') }}"
                                        class="button button-outline-primary button-round">
                                        Dashboard
                                    </a>
                                @else
                                    <!-- Login Link -->
                                    <div style="display: flex; justify-content: center; flex-direction: row; gap: 10px">
                                        <li class="nav-item">
                                            <a href="{{ route('login') }}" class="button button-outline-primary button-round">
                                                Log in
                                            </a>
                                        </li>
                                        <!-- Register Link -->
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a href="{{ route('register') }}" class="button button-primary button-round">
                                                    Sign up
                                                </a>
                                            </li>
                                        @endif
                                    </div>
                                    
                                @endauth
                            </div>
                        @endif
                    </ul>
                </div>

            </div>


        </div>
    </nav>
</header>
