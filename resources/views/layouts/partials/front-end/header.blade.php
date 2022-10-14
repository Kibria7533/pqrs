<div class="bg-success">
    <div class="container">
        <nav class="navbar navbar-expand-lg pr-0">
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <span class="nav-link">Center for alternative development trust</span>
                    </li>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                            <span class="nav-link pr-0" style="display:-webkit-inline-box">
                               <p id="datetime"></p>
                               <p  style="margin-left: 5px" id="dayName"></p>
                            </span>
                    </li>
                </ul>

            </div>
        </nav>
    </div>
</div>

<div class="d-flex flex-column flex-md-row align-items-center px-md-4 bg-white border-bottom shadow-sm sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light pr-0" style="background: #ffffff">
            <img class="logo-img" src="{{ asset('images/cadtbd.png') }}" alt="">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                    aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    &nbsp;
                </ul>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item menu-active">
                        <a class="nav-link text-dark" href="#"> Home </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#"> Donate </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#"> Career </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#"> Press </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark pr-0" href="#"> Contact </a>
                    </li>
                    @if(Auth::guard('landless')->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('My Profile') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="nav-link text-dark pr-0"
                                   href="{{ route('landless.dashboard') }}"> <i class="far fa-user-circle"></i> {{ __('My Profile') }} </a>

                                <a class="nav-link text-dark pr-0"
                                   href="{{ route('landless.my-applications') }}"> <i class="far fa-copy"></i> {{ __('My Application') }} </a>

                                <a class="nav-link text-dark pr-0" href="{{ route('admin.login-form') }}">
                                    <span href="{{ route('landless.logout') }}"
                                          onclick="event.preventDefault(); document.getElementById('landless-logout-form').submit();"> <i class="fas fa-sign-out-alt"></i>Logout</span>
                                    <form id="landless-logout-form" action="{{ route('landless.logout') }}"
                                          method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </a>
                            </div>
                        </li>
                    @endif

                </ul>
            </div>
        </nav>
    </div>
</div>
<script>
    var dt = new Date();
    document.getElementById("datetime").innerHTML = dt.toLocaleDateString();
    var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    document.getElementById("dayName").innerHTML = dayName = days[new Date().getDay()];
</script>
