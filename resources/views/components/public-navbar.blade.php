<nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded px-4 py-3 my-4 rounded-5">
    <!-- Link principali a sinistra -->
    <div class="collapse navbar-collapse justify-content-start" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">What's Included</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Stories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Our Why</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">FAQs</a>
            </li>
        </ul>
    </div>

    <!-- Pulsanti a destra -->
    <div class="d-flex ms-auto">
        @guest
            <a href="{{ route('login') }}" class="btn btn-link text-white me-2">Login</a>
            <a href="#" class="btn btn-warning text-dark">Start Testing</a>
        @else
            <div class="btn btn-warning text-dark dropdown">
                <a class="btn btn-link dropdown-toggle me-2" href="#" role="button" id="userDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item text-dark" href="#">Profilo</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
        </div @endguest </div>

</nav>
