<div class="login-area">
    @if(\Illuminate\Support\Facades\Auth::guard('landless')->check())
        <a class="" href="{{ route('admin.login-form') }}">
            <div class="btn w-100 py-2 text-white mb-3" style="background: #FC7F98">
                <div class="float-left" style="font-size: 17px">
                    <img src="{{ asset('/') }}images/logout.png" alt=""
                         style="background: white;padding: 10px;border-radius: 50%;">
                    <span href="{{ route('landless.logout') }}"
                          onclick="event.preventDefault(); document.getElementById('landless-logout-form').submit();">Logout</span>
                    <form id="landless-logout-form" action="{{ route('landless.logout') }}"
                          method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </a>
    @else
        <a class="" href="{{ route('landless.login') }}">
            <div class="btn w-100 py-2 text-white mb-3" style="background: #A7196D">
                <div class="float-left" style="font-size: 17px">
                    <img src="{{ asset('/') }}images/nagorik-corner.svg" alt=""
                         style="background: white;padding: 10px;border-radius: 50%;">
                    <span>User Login</span>
                </div>
            </div>
        </a>
        <a class="" href="{{ route('admin.login-form') }}">
            <div class="btn w-100 py-2 text-white mb-3" style="background: #FC7F98">
                <div class="float-left" style="font-size: 17px">
                    <img src="{{ asset('/') }}images/office-login.svg" alt=""
                         style="background: white;padding: 10px;border-radius: 50%;">
                    <span>Office  Login</span>
                </div>
            </div>
        </a>
    @endif
    <a class="" href="#">
        <div class="btn w-100 py-2 text-white mb-3" style="background: #19A79E">
            <div class="float-left" style="font-size: 17px">
                <img src="{{ asset('/') }}images/hotline.svg" alt=""
                     style="background: white;padding: 10px;border-radius: 50%;">
                <span>(+88 09613 570 632) Hotline Number</span>
            </div>
        </div>
    </a>
</div>

<div class="district-map-area">
    <div class="card">
        <div class="card-body">
            <label>জেলা ম্যাপ</label>
            <img style="width: 100%" src="{{ asset('/') }}images/map.png">
        </div>
    </div>
</div>
