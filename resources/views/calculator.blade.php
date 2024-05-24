@extends('layout.app')
@section('title')
Калькулятор цен
@endsection
@section('content')
<div class="container" id="Calculator">
        <div class="text-center d-flex flex-column align-items-center mb-5">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Калькулятор цен</h3>
            <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
        <div class="col-5 d-flex justify-content-center" style="margin: 0 auto">
            <form id="form" @submit.prevent="calculate">
                <div class="mb-3">
                    <label for="category" class="form-label">Категория стеклопакета</label>
                    <select class="form-select inp-calc" name="category" id="category" v-model="choise_category">
                        <option v-for="c in categories" :value="c.id">@{{ c.title }}</option>
                    </select>
                    <div><button class="btn btn-primary col-12" hidden @click='filter'>Применить</button></div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Наименование</label>
                    <select class="form-select inp-calc" name="price" id="price">
                        <option value="0" selected></option>
                        <option v-for="p in data" :value="p.price">@{{ p.title }}(@{{ p.formula }})</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="width" class="form-label">Ширина стеклопакета (мм)</label>
                    <input class="form-control inp-calc" type="text" value="" id="width">
                </div>
                <div class="mb-3">
                    <label for="height" class="form-label">Высота стеклопакета (мм)</label>
                    <input class="form-control inp-calc" type="text" value="" id="height">
                </div>
                <div class="d-flex justify-content-center mb-3"><button class="btn-auth">Рассчитать</button></div>
                <div style="height: 50px">
                    <p style="font-size: 20px; font-weight:500" id="total"></p>
                </div>
            </form>
        </div>
        <div>
            <p>*Цена указана в среднем значении, для уточнения итоговой стоимости оформите заявку на обратный звонок или позвоните по номеру, указанному в шапке профиля</p>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    categories:[],
                    prices:[],

                    choise_category:0,
                }
            },
            methods: {
                async getGlasses(){
                    const response = await fetch('{{ route('getGlasses') }}');
                    this.categories = await response.json();
                },
                async getPriceGlasses(){
                    const response = await fetch('{{ route('getPriceGlasses') }}');
                    this.prices = await response.json();
                },
                async calculate(){
                    let glass = document.getElementById('price').value;
                    let width = document.getElementById('width').value;
                    let height = document.getElementById('height').value;
                    let square = width*height/1000000;
                    console.log(square);
                    total = glass*square;
                    if(total<2050 && total!=0){
                        total=2050;
                    } else if(total===0){
                        total=0;
                    }
                    document.getElementById('total').innerHTML = 'Итого: '+total.toFixed(2) + ' рублей';
                },

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
                this.getGlasses();
                this.getPriceGlasses();
            },
        }
        Vue.createApp(app).mount('#Calculator');
    </script>
    <style>
        .container{
            flex: 1 1 auto;
            margin-top: 3rem;
            margin-bottom: 100px
        }
        .btn-auth{
            font-weight:500;
            text-decoration: none;
            color:white;
            text-transform:uppercase;
            background: #4563B0;
            padding:10px 15px;
            border:none
        }
        .inp-calc{
            border: 1px solid black;
            border-radius:0;
            width:400px
        }

        /* Адаптивная верстка */
        @media (min-width: 480px){

        }
        @media (max-width: 380px){
            .container{
                margin-top: 5rem;
                margin-bottom: 10px;
            }
            h3{
                margin-bottom: 10px;
                font-size: 20px;
                text-decoration: none;
            }
            .col-5{
                width: 90%;
            }
            .btn-auth{
                padding: 10px
            }
            .inp-calc{
                width: 100%
            }
        }
    </style>
@endsection
