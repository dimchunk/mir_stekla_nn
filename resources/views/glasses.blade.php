@extends('layout.app')
@section('title')
Стеклопакеты
@endsection
@section('content')
    <div class="container" id="Glasses" style="margin-bottom: 100px">
        <div class=" text-center d-flex flex-column align-items-center">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Стеклопакеты</h3>
            <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
        <div class="glass-main">
            <div v-for="g in glasses" class="glass-item">
                <div class="g-text">
                    <h3>@{{ g.title }}</h3>
                    <p class="g-p">@{{ g.text }}</p>
                </div>
                <div class="g-img d-flex justify-content-center flex-column align-items-center">
                    <img :src="'/public/'+g.img" alt="">
                </div>
                <div></div>
            </div>
        </div>
    </div>
    <script>
         const app = {
            data() {
                return {
                    glasses:[]
                }
            },
            methods: {
                async getGlasses(){
                    const response = await fetch('{{ route('getGlasses') }}');
                    this.glasses = await response.json();
                }
            },
            mounted() {
                this.getGlasses();
            },
        }
        Vue.createApp(app).mount('#Glasses');
    </script>
    <style>
        .g-p{
            margin-left: 1rem;
            margin-top: 3rem;
        }
        .g-text{
            width: 60%;
        }
        .g-img{
            width: 40%;
        }
        .container{
            flex: 1 1 auto;
            margin-top: 3rem;
        }
        .glass-main{
            display: flex;
            flex-direction: column
        }
        .glass-item{
            margin-top: 100px;
            border-top:#20252C 1px solid;
            padding-top:70px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        /* Адаптивная верстка */
        @media (min-width: 480px){

        }
        @media (max-width: 380px){
            .g-p{
                margin-left: 0;
                margin-top: 1rem;
            }
            .g-text{
                width: 85%;
            }
            .g-img{
                width: 90%;
            }
            .glass-item{
                flex-direction: column;
                margin-top: 30px;
                padding-top: 30px;
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
