@extends('layout.app')
@section('title')
    Авторизация
@endsection
@section('content')
    <div class="container" id="Reg">
        <div :class="message ? 'alert alert-primary':''">
            @{{ message }}
        </div>
        <div class="text-center d-flex flex-column align-items-center">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Регистрация</h3>
            <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
        <div class="mt-5">
            <form class="col-4" style="margin: 0 auto" id="formReg" @submit.prevent="reg">
                <div class="mb-3">
                  <label for="name" style="color: black" class="form-label">Имя</label>
                  <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="name" name="name" :class="errors.name ? 'is-invalid':''">
                  <div :class="errors.name ? 'invalid-feedback':''" v-for="error in errors.name">
                    @{{ error }}
                  </div>
                </div>
                <div class="mb-3">
                    <label for="surname" style="color: black" class="form-label">Фамилия</label>
                    <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="surname" name="surname" :class="errors.surname ? 'is-invalid':''">
                    <div :class="errors.surname ? 'invalid-feedback':''" v-for="error in errors.surname">
                      @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" style="color: black" class="form-label">Email</label>
                    <input type="email" class="form-control" style="border-radius: 0; border:1px solid black" id="email" name="email" :class="errors.email ? 'is-invalid':''">
                    <div :class="errors.email ? 'invalid-feedback':''" v-for="error in errors.email">
                      @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="phone" style="color: black" class="form-label">Номер телефона</label>
                    <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="phone" name="phone" :class="errors.phone ? 'is-invalid':''">
                    <div :class="errors.phone ? 'invalid-feedback':''" v-for="error in errors.phone">
                      @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" style="border-radius: 0; border:1px solid black" class="form-control" id="password" name="password" :class="errors.password ? 'is-invalid':''">
                    <div class="invalid-feedback" v-for="error in errors.password">
                      @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Повторите пароль</label>
                    <input type="password" style="border-radius: 0; border:1px solid black" class="form-control" id="password_confirmation" name="password_confirmation" :class="errors.password ? 'is-invalid':''">
                    <div class="invalid-feedback" v-for="error in errors.password">
                      @{{ error }}
                    </div>
                </div>
                <div class="d-flex justify-content-center"><button type="submit" class="btn-auth">Зарегистрироваться</button></div>
                <div class="text-center mt-3"><p>Уже есть аккаунт? <a href="{{ route('pageAuth') }}" style="color: #4563B0; text-decoration: none;">Войти</a></p></div>
            </form>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    errors:[],
                    message:''
                }
            },
            methods: {
                async reg(){
                    let form = await document.getElementById('formReg');
                    let formData = new FormData(form);

                    const response = await fetch('{{ route('regUser') }}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                        },
                        body:formData
                    });
                    if(response.status===400){
                        this.errors = await response.json();
                        setTimeout(() => {
                            this.errors = [];
                        }, 3000);
                    }
                    if(response.status===200){
                        this.message = await response.json();
                        setTimeout(()=>{
                            this.message = '';
                        }, 3000);
                    }
                }
            },
            mounted(){
                $('#phone').inputmask("+7 (999) 999-99-99");
            }
        }
        Vue.createApp(app).mount('#Reg');
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
            .col-4{
                width: 70%;
            }
            .btn-auth{
                padding: 10px
            }
        }
    </style>
@endsection
