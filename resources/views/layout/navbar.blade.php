<div class="header1">
    <nav class="navbar navbar-expand-lg mt-3 mb-3 ms-5 me-5">
        <div class="container-fluid" class="">
        <a class="navbar-brand" style="font-family: 'Unbounded'" href="{{ route('welcome') }}"><img style="height:80px" src="{{ asset('public\img\logo.png') }}" alt=""></a>
        <div class="d-flex align-items-center">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav_btn" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Услуги</a>
                <ul class="dropdown-menu"  style="border-radius: 0px">
                    @foreach ($services_navbar as $service)
                    <li><a class="dropdown-item" href="{{ route('pageService', ['service'=>$service]) }}">{{ $service->title }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="ms-5 nav_btn"><a href="{{ route('pageContacts') }}" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase">Контакты</a></div>
            <div class="ms-5 nav_btn"><a href="{{ route('pageCalculator') }}" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase">Калькулятор цен</a></div>
            <div class="ms-5 nav_btn"><a href="{{ route('pageDelivery') }}" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase">Доставка</a></div>
            @guest
                <div class="ms-5 nav_btn"><a href="{{ route('pageAuth') }}" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase">Войти</a></div>
            @endguest
            @auth
            @if (Auth::user()->role==='0')
                <div class="ms-5">
                    <a class="nav-link nav_btn" href="{{ route('pageProfile') }}" style="font-weight:500;text-decoration: none; color:#4563B0; text-transform:uppercase"  role="button" aria-expanded="false">ПРОФИЛЬ</a>
                </div>
            @endif
            @if (Auth::user()->role==='1')
                <div class="nav-item dropdown ms-5">
                    <a class="nav-link dropdown-toggle nav_btn" href="#" style="font-weight:500;text-decoration: none; color:#4563B0; text-transform:uppercase"  role="button" data-bs-toggle="dropdown" aria-expanded="false">Админ</a>
                    <ul class="dropdown-menu" style="border-radius: 0px">
                        <li><a class="dropdown-item" href="{{ route('pageAdminOrders') }}">Заказы</a></li>
                        <li><a class="dropdown-item" href="{{ route('pageAdminServices') }}">Услуги</a></li>
                        <li><a class="dropdown-item" href="{{ route('pageAdminGlasses') }}">Стеклопакеты</a></li>
                        <li><a class="dropdown-item" href="{{ route('pageAdminPrices') }}">Цены</a></li>
                        <li><a class="dropdown-item" href="{{ route('pageProfile') }}">Профиль</a></li>
                        <li><a class="dropdown-item" href="{{ route('exitUser') }}">Выход</a></li>
                    </ul>
                </div>
            @endif
            @endauth
            <div class="ms-5" id="ApplicationNavbar">
                <button type="button" class="nav_application" style="border:none; font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:15px" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Заказать звонок
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div style="border-radius: 0" class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Заявка на обратный звонок</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('addApplicationNavbar') }}" method="post">
                                @method('post')
                                @csrf
                                <div class="mb-3">
                                    <label for="nameA" style="color: black" class="form-label">Имя <span style="color: #4563B0">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" style="border-radius:0; border: 1px solid black; padding:10px 15px" type="text" id="nameA" name="name" >
                                    <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                        @error('name')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneA" style="color: black" class="form-label">Номер телефона <span style="color: #4563B0">*</span></label>
                                    <input class="form-control @error('phone') is-invalid @enderror" type="text" style="border-radius:0; border: 1px solid black; padding:10px 15px;" id="phoneA" name="phone">
                                    <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                        @error('phone')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="textA" style="color: black" class="form-label">Сообщение</label>
                                    <textarea class="form-control @error('text') is-invalid @enderror" style="border-radius:0; border: 1px solid black; padding:10px 15px;" id="textA" name="text"></textarea>
                                    <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                        @error('text')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center"><button type="submit" style="color:white; text-transform:uppercase; background: #4563B0; padding:15px; border:none">Отправить</button></div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="ms-5"><a href="#" style="font-family: 'Unbounded'; font-weight:400; font-size:20px;text-decoration: none; color:black; text-transform:uppercase">+7(960)172-18-13</a></div>
        </div>
        </div>
    </nav>
</div>
<div class="header2">
    <nav style="background-color: white" class="navbar fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('welcome') }}"><img style="width:25vh" src="{{ asset('public\img\logo.png') }}" alt=""></a>
          <button style="border: #4563B0 1px solid; border-radius:0" class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span style="background-image: none; padding-top: 4px" class="navbar-toggler-icon"><img src="{{ asset('img/burger.png') }}" alt=""></span>
          </button>
          <div class="offcanvas offcanvas-end" style="background: #fff" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Меню</h5>
              <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item mb-2">
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle nav_btn" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Услуги</a>
                            <ul class="dropdown-menu"  style="border-radius: 0px">
                                @foreach ($services_navbar as $service)
                                <li><a class="dropdown-item" href="{{ route('pageService', ['service'=>$service]) }}">{{ $service->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mb-2">
                        <div class="nav_btn"><a href="{{ route('pageContacts') }}" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase">Контакты</a></div>
                    </li>
                    <li class="nav-item mb-2">
                        <div class="nav_btn"><a href="{{ route('pageCalculator') }}" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase">Калькулятор цен</a></div>
                    </li>
                    <li class="nav-item mb-2">
                        <div class="nav_btn"><a href="{{ route('pageDelivery') }}" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase">Доставка</a></div>
                    </li>
                    @guest
                    <li class="nav-item mb-2">
                        <div class="nav_btn"><a href="{{ route('pageAuth') }}" style="font-weight:500;text-decoration: none; color:black; text-transform:uppercase">Войти</a></div>
                    </li>
                    @endguest
                    @auth
                    @if (Auth::user()->role==='0')
                    <li class="nav-item mb-2">
                        <div class="">
                            <a class="nav-link nav_btn" href="{{ route('pageProfile') }}" style="font-weight:500;text-decoration: none; color:#4563B0; text-transform:uppercase"  role="button" aria-expanded="false">ПРОФИЛЬ</a>
                        </div>
                    </li>
                </ul>
                @endif
                @endauth
                    {{-- <li class="nav-item mb-2">
                        <div id="ApplicationNavbar">
                            <button type="button" class="nav_application" style="border:none; font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:15px" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Заказать звонок
                            </button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div style="border-radius: 0" class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Заявка на обратный звонок</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('addApplicationNavbar') }}" method="post">
                                            @method('post')
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nameA" style="color: black" class="form-label">Название <span style="color: #4563B0">*</span></label>
                                                <input class="form-control @error('name') is-invalid @enderror" style="border-radius:0; border: 1px solid black; padding:10px 15px" type="text" id="nameA" name="name" >
                                                <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                                    @error('name')
                                                    {{$message}}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="phoneA" style="color: black" class="form-label">Номер телефона <span style="color: #4563B0">*</span></label>
                                                <input class="form-control @error('phone') is-invalid @enderror" type="text" style="border-radius:0; border: 1px solid black; padding:10px 15px;" id="phoneA" name="phone">
                                                <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                                    @error('phone')
                                                    {{$message}}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="text" style="color: black" class="form-label">Сообщение</label>
                                                <textarea class="form-control @error('text') is-invalid @enderror" style="border-radius:0; border: 1px solid black; padding:10px 15px;" id="text" name="text"></textarea>
                                                <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                                    @error('text')
                                                    {{$message}}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center"><button type="submit" style="color:white; text-transform:uppercase; background: #4563B0; padding:15px; border:none">Отправить</button></div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </li> --}}
            </div>
          </div>
        </div>
    </nav>
</div>
<style>
    .nav_btn:hover{
        border-bottom: #4563B0 2px solid;
    }
    .nav_application:hover{
        background: #1F1F1F;
    }
    .header1{
        display: block
    }
    .header2{
        display: none;
    }
    @media (min-width: 480px){

    }
    @media (max-width: 380px){
        .nav-link{
            font-size: 14px;
            padding: 0;
        }
        .header2{
            background-color: white;
            display: block;
        }
        .header1{
            display: none;
        }
        .nav_btn a{
            font-size: 14px
        }
    }
</style>
