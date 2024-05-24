@extends('layout.app')
@section('title')
    Доставка
@endsection
@section('content')
<div class="main">
    <div class="container">
        <div class="text-center d-flex flex-column align-items-center">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Доставка</h3>
            <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
    </div>
<div class="text-center mt-5"><p class="act">Доставка от 10 стеклопакетов бесплатная (по городу)</p></div>
    <div class="container mt-5"> 
        <p style="font-weight:500">Доставка осуществляется по Нижегородской области</p>
        <ul>
            <li>Верхняя часть города 1700р</li>
            <li>Нижняя часть города 1500р</li>
            <li>По области цена договорная</li>
        </ul>
        <p style="font-weight:500">Возможен самовывоз</p>
    </div>
</div>


    <style>
        .act{
            font-size: 20px;
            background: #4563B0;
            color: white;
            text-transform: uppercase;
            font-weight: 500;
            padding: 20px 0;
            width: 100%;
            position: relative;
        }
        li::marker{
            color: #4563B0;
        }
        .main{
            flex: 1 1 auto;
            margin-top: 3rem;
            margin-bottom: 100px;
        }
        /* Адаптивная верстка */
    @media (min-width: 480px){

    }
    @media (max-width: 380px){
        .act{
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 500;
            padding: 5px 0;
        }
        .main{
            margin-top: 5rem;
            margin-bottom: 40px;
        }
        h3{
            margin-bottom: 10px;
            font-size: 20px;
            text-decoration: none;
        }
    }
    </style>
@endsection
