<aside class="asidebar collapse navbar-collapse" id="navbarSupportedContent">
    <div class="asidebar-top">
        <ul class="internal-icon">

            <li>
                <a href="{{ route('bussiness.index') }}"
                    class="{{ request()->routeIs('bussiness.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">
                        {{-- home --}}
                    </span>
                    Bussiness
                </a>
            </li>

            <li>
                <a href="{{ route('customers.index') }}"
                    class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">
                        {{-- finance_mode --}}
                    </span>
                    Customers
                </a>
            </li>

            <li>
                <a href="{{ route('reviews.all', config('app.default_business_id')) }}"
                    class="{{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined"></span>
                    Reviews
                </a>

            </li>

            <li>
                <a href="{{ route('logout') }}">
                    <span class="material-symbols-outlined">
                        {{-- logout --}}
                    </span>
                    Logout
                </a>
            </li>

        </ul>
    </div>
</aside>