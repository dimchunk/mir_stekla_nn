<footer>
    <div class="foot">
        <div class="container-sm pt-5 pb-5 block-footer" >
            <div class="d-flex flex-column one-block">
                <div class="logo-footer"><img class="mb-3"  src="{{ asset('public\img\logoblack.png') }}" alt=""></div>
                <p class="mb-3">г. Нижний Новгород ул. Кондукторская 3Б</p>
                <p class="mb-3">mir-stekla@bk.ru</p>
                <p>+7(960)172-18-13 (Андрей), +7(903)848-78-36(Сергей)</p>
            </div>
            <div class="d-flex flex-column one-block">
                <p style="text-decoration: underline 2px #4563B0; text-underline-offset: 7px;">УСЛУГИ</p>
                @foreach ($services as $service)
                <a  class="mb-3" style="color:white; text-decoration:none" href="{{ route('pageService', ['service'=>$service]) }}">{{ $service->title }}</a>
                @endforeach
                <a style="color:white; text-decoration:none" href="{{ route('pageCalculator')}}">Калькулятор цен</a>
            </div>
            <div class="d-flex flex-column">
                <p style="text-decoration: underline 2px #4563B0; text-underline-offset: 7px;">О КОМПАНИИ</p>
                <a class="mb-3" style="color:white; text-decoration:none" href="{{ route('pageDelivery') }}">Доставка</a>
                <a style="color:white; text-decoration:none" href="{{ route('pageContacts') }}">Контакты</a>
            </div>
        </div>
    </div>
</footer>
<style>
    .foot{
        background:#20252C;
        color:white
    }
    .block-footer{
        display: flex;
        justify-content: space-between;
    }
    .logo-footer img{
        width: 350px;
    }

    /* Адаптивная верстка */
    @media (min-width: 480px){

    }
    @media (max-width: 380px){
        .one-block{
            margin-bottom: 2rem;
        }
        .block-footer{
            flex-direction: column;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        p, a{
            font-size: 14px;
        }
        .logo-footer img{
            width: 200px;
        }

    }
</style>
