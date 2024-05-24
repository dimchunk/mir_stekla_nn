@extends('layout.app')
@section('title')
    {{ $service->title }}
@endsection
@section('content')
    <div class="container">
        @if (session()->has('ok'))
        <div class="alert alert-primary">
            {{ session('ok') }}
        </div>
        @endif
        <div class="service-header">
            <div class="d-flex flex-column align-items-start">
                <div class="head-s">
                    <div style="background: #4563B0; height:70px; width: 3px"></div>
                    <div>
                        <h3 class="mb-2 ms-3" style="font-family: 'Unbounded'; font-weight:400">{{ $service->title }}</h3>
                    </div>
                </div>
                <div class="mb-2"><p>от <span style="font-family: 'Unbounded'; font-weight:500; font-size:18px; text-transform:uppercase">{{ $service->price }} руб</span></p></div>
                <div>
                    <button type="button" class="service_application" style="border:none; font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:15px" data-bs-toggle="modal" data-bs-target="#serviseApplication">
                        Оставить заявку
                    </button>
                    <div class="modal fade" id="serviseApplication" tabindex="-1" aria-labelledby="serviseApplicationLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div style="border-radius: 0" class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="serviseApplicationLabel">Заявка на обратный звонок</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('addApplicationService', ['service'=>$service]) }}" method="post">
                                    @method('post')
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" style="color: black" class="form-label">Имя<span style="color: #4563B0">*</span></label>
                                        <input class="form-control @error('name') is-invalid @enderror" style="border-radius:0; border: 1px solid black; padding:10px 15px" type="text" id="name" name="name" >
                                        <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                            @error('name')
                                            {{$message}}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" style="color: black" class="form-label">Номер телефона <span style="color: #4563B0">*</span></label>
                                        <input class="form-control @error('phone') is-invalid @enderror" type="text" style="border-radius:0; border: 1px solid black; padding:10px 15px;" id="phone" name="phone">
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
            </div>
            <div class="block-img"><img class="ser-img" src="{{ '/public/'.$service->img }}" alt=""></div>
        </div>
        <div style="text-align: justify" class="mt-3 d-flex flex-column align-items-center">
            <p class="mt-3">{{ $service->text }}</p>
        </div>
        <div class="price-block">
            <div class="text-center d-flex flex-column align-items-center">
                <h3 style="font-family: 'Unbounded'; font-weight:400">Цены</h3>
                <div style="background: #4563B0; height:3px; width: 80px"></div>
            </div>
            <div class="mt-4 mb-4">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Название</th>
                        <th scope="col">Цена за кв/м</th>
                        <th scope="col">Категория</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($prices as $price)
                            <tr>
                                <td scope="row">{{ $price->title }}</td>
                                <td>{{ $price->price }}</td>
                                <td>{{ $price->service->title }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <style>
        .price-block{
            margin-top: 3rem;
        }
        .ser-img{
            width: 500px;
        }
        .head-s{
            display: flex;
            align-items: center;
            margin-bottom: 70px;
        }
        .container{
            flex: 1 1 auto;
            margin-top: 3rem;
            margin-bottom: 100px;
        }
        .service-header{
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        /* Адаптивная верстка */
        @media (min-width: 480px){

        }
        @media (max-width: 380px){
            table{
                width: 90%;
            }
            th, td{
                font-size: 14px
            }
            .price-block{
                margin-top: 1rem;
            }
            .block-img{
                display: flex;
                justify-content: center;
            }
            .ser-img{
                width: 90%;
            }
            .head-s{
                margin-bottom: 20px;
            }
            .container{
                width: 90%;
                margin-top: 5rem;
                margin-bottom: 30px;
            }
            .service-header{
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: flex-start;
            }
            h3{
                margin-bottom: 10px;
                font-size: 20px;
                text-decoration: none;
            }
        }
    </style>
@endsection
