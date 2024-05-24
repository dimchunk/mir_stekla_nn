@extends('layout.app')
@section('title')
    Главная
@endsection
@section('content')
<div class="main">
    <div class="header">
            <div style="position: absolute; z-index:0"><img src="{{ asset('public\img\back_header.png') }}" style="width: 100%"  alt=""></div>
            <div class="w-100 text-center header-block">
                <h1 class="header-main" style="font-family: 'Unbounded'; color:white; font-weight:400;">ИЗГОТОВЛЕНИЕ СТЕКЛОПАКЕТОВ <br>
                ЛЮБОЙ СЛОЖНОСТИ</h1>
                <p class="header_delivery mt-3">Производство стеклопакетов с доставкой по Нижегородской области</p>
            </div>
        </div>
        <div class="container cont-main" style="color:black">
            <div>
                <div class="text-center d-flex flex-column align-items-center services-block">
                    <h3 class="sub-header" style="font-family: 'Unbounded'; font-weight:400">Наши услуги</h3>
                    <div style="background: #4563B0; height:3px; width: 80px"></div>
                </div>
                <div class="services">
                    @foreach ($services as $service)
                    <div class="service-block ">
                        <div class="service-img"><img src="{{ '/public/'.$service->img }}" alt=""></div>
                        <div class="mt-3 service-p">
                            <p style="font-weight: 600">{{ $service->title }}</p>
                            <p>от {{ $service->price }}р</p>
                        </div>
                        <div class="d-flex justify-content-center btn-service">
                            <a class="more" href="{{ route('pageService', ['service'=>$service]) }}">Подробнее</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            </div>
            <div class="delivery">
                <div class="delivery-block container pt-5 pb-5">
                    <div class="delivery-block-p">
                        <p class="delivery-h">Доставка по Нижегородской области</p>
                        <p class="delivery-p">При заказе от 10 стеклопакетов доставка бесплатная</p>
                    </div>
                    <div>
                        <a href="{{ route('pageDelivery') }}" class="more_delivery">Подробнее</a>
                    </div>
                </div>
            </div>
            <div class="container" id="ApplicationWelcome">
            <div class="glasses-block">
                <div class="header-glass">
                    <div class="glass-h">
                        <div class="line-bl1"></div>
                        <h3 class="ms-3" style="font-family: 'Unbounded'; font-weight:400; ">Cтеклопакеты</h3>
                        <div class="line-bl2"></div>
                    </div>
                    <div class="more-delivery-block">
                        <a href="{{route('pageGlasses')}}" style="font-weight:500;text-decoration: none;color:black">Смотреть все ></a>
                    </div>
                </div>
                <div class="glasses mt-5">
                    @foreach ($glasses as $glass)
                        <div class="glass-item">
                            <img src="{{ '/public/'.$glass->img }}" alt="">
                            <a class="mt-3" style="font-weight:600; width:80%; color:black; text-decoration:none">{{ $glass->title }}</a>
                        </div>
                    @endforeach
                </div>
                <div class="more-delivery-block1">
                    <a href="{{route('pageGlasses')}}" style="font-weight:500;text-decoration: none;color:black">Смотреть все</a>
                </div>
            </div>
            <div class="application">
                <div class="d-flex flex-column justify-content-between">
                    <div class="application-head">
                        <h3>Остались вопросы? Заполните форму</h3>
                        <p>Получите бесплатную консультацию</p>
                    </div>
                    <div class="call-block">
                        <p class="me-3 call-p">Или позвоните по номеру</p>
                        <p class="call-num">+7 (960) 172-18-13</p>
                    </div>
                </div>
                <div class="form-application">
                    <div :class="message ? 'alert alert-primary':''">
                        @{{ message }}
                    </div>
                    <form id="formAdd" @submit.prevent="add">
                        <div class="mb-3">
                            <input class="input-application" style="border: 1px solid black; padding:10px 15px" type="text" id="name" name="name" :class="errors.name ? 'is-invalid':''" placeholder="Имя">
                            <div :class="errors.name ? 'invalid-feedback':''" v-for="error in errors.name">
                              @{{ error }}
                            </div>
                        </div>
                        <div class="mb-3">
                              <input class="input-application" type="text" style="border: 1px solid black; padding:10px 15px" id="phone" name="phone" :class="errors.phone ? 'is-invalid':''" placeholder="Номер телефона">
                              <div class="invalid-feedback" v-for="error in errors.phone">
                                @{{ error }}
                              </div>
                        </div>
                          <div class="d-flex justify-content-center"><button type="submit" class="send">Отправить</button></div>
                    </form>
                </div>
            </div>
        </div>
</div>

        <script>
            const app = {
                data() {
                    return {
                        errors:[],
                        message:'',
                    }
                },
                methods: {
                    async add(){
                        let form = await document.getElementById('formAdd');
                        let formData = new FormData(form);

                        const response = await fetch('{{ route('addApplication') }}',{
                            method:'post',
                            headers:{
                                'X-CSRF-TOKEN':'{{ csrf_token() }}'
                            },
                            body:formData
                        });
                        if(response.status==400){
                            this.errors = await response.json();
                            setTimeout(() => {
                                this.errors = [];
                            }, 3000);
                        }
                        if(response.status==200){
                            this.message = await response.json();
                            setTimeout(() => {
                                this.message = '';
                            }, 3000);
                        }
                    },
                },
            }
            Vue.createApp(app).mount('#ApplicationWelcome')
        </script>
        <style>
            .header{
                margin: 0 auto;
            }
            .send{
                color:white;
                text-transform:uppercase;
                background: #4563B0;
                padding:15px;
                border:none
            }
            .call-num{
                font-weight: 600;
                font-size:28px;
                font-family:'Unbounded';
                color:#4563B0;
            }
            .call-p{
                font-size:18px;
                font-weight:500;
            }
            .call-block{
                display: flex;
                align-items: center;
            }
            .application-head{
                padding-bottom: 40px;
            }
            .application-head h3{
                font-weight: 600;
                font-size:28px;
            }
            .application-head p{
                font-size: 18px;
                font-weight:500;
            }
            .glass-item{
                display: flex;
                text-align: center;
                flex-direction: column;
                align-items: center;
            }
            .header-glass{
                display: flex;
                justify-content: space-between;
                align-items: center
            }
            .line-bl1{
                background: #4563B0;
                height:70px;
                width: 3px;
                display: block;
            }
            .line-bl2{
                background: #4563B0;
                height:3px;
                width: 80px;
                display: none;
            }
            .glass-h{
                color: black;
                display: flex;
                align-items: center;
            }
            .more-delivery-block1{
                text-align: center;
                display: none;
            }
            .more-delivery-block{
                display: block;
            }
            .glasses-block{
                margin-top: 90px;
            }
            .delivery{
                margin-top: 100px;
                background:#4563B0;
                color:white;
            }
            .more_delivery{
                font-weight:500;
                text-decoration: none;
                color:black;
                text-transform:uppercase;
                background: #fff;
                padding:15px
            }
            .delivery-p{
                font-size: 18px;
            }
            .delivery-h{
                text-transform: uppercase;
                font-size:32px;
                font-weight:600
            }
            .delivery-block{
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .more{
                border: #4563B0 1px solid;
                padding:15px;
                text-decoration:none;
                text-transform:uppercase;
                color:black
            }
            .btn-service{
                margin-top: 40px;
            }
            .service-p{
                margin-left: 10px;
            }
            .service-p p{
                font-size: 18px;
            }
            .service-img{
                display: flex;
                justify-content: center;
            }
            h3{
                margin-bottom: 10px;
                font-size: 20px;
                text-decoration: none;
            }
            .header_delivery{
                color: white;
                font-weight:400;
                font-size:24px;
                display: block;
            }
            .header-block{
                position: absolute;
                margin-left: auto;
                margin-right: auto;
                margin-top: 260px;
            }
            .cont-main{
                margin-top: 800px;
            }
            .application{
                margin-top: 100px;
                margin-bottom: 100px;
                border-top:#20252C 1px solid;
                padding-top:70px;
                display: flex;
                justify-content: space-between;
            }
            .services{
                margin-top: 70px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .more:hover{
                background: #4563B0;
                color: #fff;
            }
            .more_delivery:hover{
                background: #1F1F1F;
                color: #fff;
            }
            .header-main{
                font-size: 54px;
            }
            .glasses{
                display: flex;
                justify-content: space-between;
            }
            .input-application{
                box-sizing: content-box;
                    width: 350px;
            }

            /* Адаптивная верстка */
            @media (min-width: 480px){

            }
            /* @media (max-width: 390px){
                .header-block{
                    margin-top: 60px;
                }
            } */
            @media (max-width: 380px){
                .application{
                    margin-top: 30px;
                    border-top:#20252C 1px solid;
                    padding-top:10px;
                    display: flex;
                    justify-content: space-between;
                }
                .send{
                    padding: 12px
                }
                #formAdd{
                    display: flex;
                    align-items: center;
                    flex-direction: column;
                    justify-content: space-between
                }
                .call-num{
                    font-size:14px;
                }
                .call-p{
                    font-size:16px;
                }
                .call-block{
                    flex-direction: column;
                }
                .application-head{
                    padding-bottom: 10px;
                    text-align: center
                }
                .application-head h3{
                    font-size:16px;
                }
                .application-head p{
                    font-size: 14px;
                }
                .glass-item{
                    margin: 0 auto;
                    margin-bottom: 30px;
                }
                .glass-item img{
                    width: 80%;
                }
                .header-glass{
                    display: flex;
                    justify-content: center;
                }
                .line-bl1{
                    display: none;
                }
                .line-bl2{
                    display: block;
                }
                .glass-h{
                    flex-direction: column;
                    justify-content: center;
                }
                .more-delivery-block1{
                    display: block;
                }
                .more-delivery-block{
                    display: none;
                }
                .glasses-block{
                    margin-top: 30px;
                }
                .delivery{
                    margin-top: 30px;
                }
                .more_delivery{
                    padding:10px
                }
                .delivery-block-p{
                    text-align: center;
                    margin-bottom: 12px;
                }
                .delivery-p{
                    font-size: 14px;
                }
                .delivery-h{
                    font-size:18px;
                }
                .delivery-block{
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    flex-direction: column;
                }
                .more{
                    padding: 10px;
                    background: #4563B0;
                    color: white;
                }
                .btn-service{
                    margin-top: 10px;
                }
                .service-p{
                    margin-left: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
                .service-p p{
                    font-size: 14px;
                }
                h3{
                    text-decoration: none;
                    font-size: 16px;
                    margin-bottom: 5px;
                }
                .services-block{
                    padding-top: 160px;
                }
                .header_delivery{
                    display: none;
                }
                .header{
                    margin-top: 65px;
                }
                .header-block{
                    margin-top: 40px;
                }
                .cont-main{
                    margin-top: 55px;
                }
                .input-application{
                    width: 85%;
                }
                .application{
                    flex-direction: column;
                }
                .header-main{
                    font-size: 16px;
                }
                .services{
                    margin-top: 25px;
                    flex-direction: column;
                }
                .service-block img{
                    width: 80%;
                }
                .service-block{
                    margin-bottom: 20px;
                }
                .glasses{
                    flex-direction: column;
                }
                .more:hover{
                    background: none;
                    color: #fff;
                }
            }
        </style>
@endsection
