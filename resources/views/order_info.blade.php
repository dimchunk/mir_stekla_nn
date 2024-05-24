@extends('layout.app')
@section('title')
    Информация о заказе
@endsection
@section('content')
    <div class="container" id="OrderInfoAdmin">
        <div :class="message ? 'alert alert-primary':''">
            @{{ message }}
        </div>
        @if (session()->has('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
        @endif
        <div class="text-center d-flex flex-column align-items-center mb-5">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Заказ</h3>
           <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
        <div>
            <div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Наименование</th>
                        <th scope="col">Размеры (мм)</th>
                        <th scope="col">Кол-во</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr style="line-height: 40px">
                            <td>{{ $item->price->formula }}</td>
                            <td>{{ $item->width }}X{{ $item->height }}</td>
                            <td>{{ $item->count }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    prices:[],
                    errors:[],
                    message:'',
                    categories:[],

                    choise_category:0,
                    data:[],
                    items:[],
                }
            },
            methods: {

            },
            computed:{
                filter(){
                    let prices = this.prices;
                    if(this.choise_category!=0){
                        prices = prices.filter(e=>e.glass_id===this.choise_category);
                    }
                    this.data = prices;
                }
            },
            mounted() {
                this.getPriceGlasses();
                this.getGlasses();
                this.getOrder();
            },
        }
        Vue.createApp(app).mount('#OrderInfoAdmin');
    </script>
    <style>
        .container{
            flex: 1 1 auto;
            margin-bottom: 100px;
            margin-top: 3rem;
        }

        /* Адаптивная верстка */
        @media (min-width: 480px){

        }
        @media (max-width: 380px){
            th, td{
                font-size: 14px
            }
            .container{
                margin-top: 5rem;
            }
            h3{
                margin-bottom: 10px;
                font-size: 20px;
                text-decoration: none;
            }
        }
    </style>
@endsection
