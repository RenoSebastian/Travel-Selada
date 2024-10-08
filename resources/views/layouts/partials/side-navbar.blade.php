<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky">
        <ul class="nav flex-column">
            @if(Auth::user()->isAdmin())
            <li class="nav-item">
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                        <span data-feather="home"></span>
                        Admin Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('transactions') }}">
                        <span data-feather="file"></span>
                        Manage Transactions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('terminals') }}">
                        <span data-feather="credit-card"></span>
                        Manage Terminals
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user-dashboard') }}">
                        <span data-feather="home"></span>
                        My Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('transactions') }}">
                        <span data-feather="file"></span>
                        My Transactions
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('agents') }}">
                    <span data-feather="users"></span>
                    Agents
                </a>
            </li>
        </ul>
    </div>
</nav>
