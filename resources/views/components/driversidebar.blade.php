<!-- resources/views/components/sidebar.blade.php -->
<aside class="asidebar  collapse navbar-collapse" id="navbarSupportedContent">
    <div class="asidebar-top">
        <ul class="internal-icon">
            <li ><a href="{{route('driver.viewRoute')}}" class="active">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                     Bus Route Location
                </a>
            </li>
           
          
        </ul>
    </div>
    <div class="asidebar-bottom">
        <ul class="internal-icon">
            <li>
                
            <form method="POST" action="{{ route('logout') }}">
                @csrf
    
                <button type="submit" class="button button-primiary">
                    {{ __('Log Out') }}
                </button>
            </form>
            </li>
        </ul>
        <div class="divider"></div>
        <div class="asidebar-copyright">
            <p>© FlexInvest 2024</p>
        </div>
    </div>
</aside>
