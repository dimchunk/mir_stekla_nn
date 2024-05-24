@extends('layout.app')
@section('title')
    Профиль
@endsection
@section('content')
    <div class="container" id="Profile">
        <div :class="message ? 'alert alert-primary':''">
            @{{ message }}
        </div>
        <div class="mb-5 text-center d-flex flex-column align-items-center">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Профиль</h3>
            <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
        <div class="btn-profie">
            <a href="{{ route('pageOrder') }}" style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none">Перейти к оформлению заказа</a>

            <button type="button" data-bs-toggle="modal" data-bs-target="#updateProfile" style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none">
                Редактировать профиль
            </button>
            <a style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none" href="{{ route('exitUser') }}">Выйти из аккаунта</a>

            <div class="modal fade" id="updateProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div style="border-radius: 0" class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Редактирование личных данных</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form" @submit.prevent="update">
                            <div class="mb-3">
                                <label for="name" style="color: black" class="form-label">Имя</label>
                                <input :value="user.name" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="name" name="name" :class="errors.name ? 'is-invalid':''">
                                <div :class="errors.name ? 'invalid-feedback':''" v-for="error in errors.name">
                                  @{{ error }}
                                </div>
                              </div>
                              <div class="mb-3">
                                  <label for="surname" style="color: black" class="form-label">Фамилия</label>
                                  <input :value="user.surname" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="surname" name="surname" :class="errors.surname ? 'is-invalid':''">
                                  <div :class="errors.surname ? 'invalid-feedback':''" v-for="error in errors.surname">
                                    @{{ error }}
                                  </div>
                              </div>
                              <div class="mb-3">
                                  <label for="email" style="color: black" class="form-label">Email</label>
                                  <input :value="user.email" type="email" class="form-control" style="border-radius: 0; border:1px solid black" id="email" name="email" :class="errors.email ? 'is-invalid':''">
                                  <div :class="errors.email ? 'invalid-feedback':''" v-for="error in errors.email">
                                    @{{ error }}
                                  </div>
                              </div>
                              <div class="mb-3">
                                  <label for="phone" style="color: black" class="form-label">Номер телефона</label>
                                  <input :value="user.phone" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="phone" name="phone" :class="errors.phone ? 'is-invalid':''">
                                  <div :class="errors.phone ? 'invalid-feedback':''" v-for="error in errors.phone">
                                    @{{ error }}
                                  </div>
                              </div>
                            <div class="d-flex justify-content-center"><button type="submit" style="color:white; text-transform:uppercase; background: #4563B0; padding:15px; border:none">Сохранить</button></div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-3 mb-4">
            <label for="status" class="form-label">Фильтровать по статусу</label>
            <select style="border: 1px solid black; border-radius:0" class="form-select" id="status" v-model="filter_parameter" aria-label="Default select example">
                <option value="0" selected>Все</option>
                <option value="Новый">Новый</option>
                <option value="Отменен">Отменен</option>
                <option value="Оформлен">Оформлен</option>
                <option value="Завершен">Завершен</option>
            </select>
            <button @click="filter" hidden>Применить</button>
        </div>
        <div>
            <h3>Ваши заказы</h3>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col"></th>
                        <th scope="col">Дата оформления - завершения</th>
                        <th scope="col">Итого (руб)</th>
                        <th scope="col">Статус</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="line-height: 40px" v-for="order in data">
                        <td>@{{ order.id }}</td>
                        <td>@{{ order.date_start }} - @{{ order.date_end }}</td>
                        <td>@{{ order.price }}</td>
                        <td>@{{ order.status }}</td>
                        <td>
                            <a :href="`{{ route('pageInfo') }}/${order.id}`" style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none">Подробнее</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    errors:[],
                    message:'',
                    user:{},
                    orders:[],
                    filter_parameter:0,
                    data:[]
                }
            },
            methods: {
                async getUser(){
                    const response = await fetch('{{ route('getUser') }}');
                    this.user = await response.json();
                },
                async getOrders(){
                    const response = await fetch('{{ route('getOrders') }}');
                    this.orders = await response.json();
                },
                async update(){
                    let form = await document.getElementById('form');
                    let formData = new FormData(form);

                    const response = await fetch('{{ route('updateUser') }}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{ csrf_token() }}'
                        },
                        body:formData,
                    });
                    if(response.status===400){
                        this.errors= await response.json();
                        setTimeout(() => {
                            this.errors=[];
                        }, 3000);
                    }
                    if(response.status===200){
                        this.message= await response.json();
                        this.getUser();
                        setTimeout(() => {
                            this.message='';
                        }, 3000);
                    }
                }
            },
            computed:{
                filter(){
                    let orders = this.orders;
                    if(this.filter_parameter!=0){
                        orders = orders.filter(e=>e.status===this.filter_parameter);
                    }
                    this.data = orders;
                },
            },
            mounted() {
                this.getUser();
                this.getOrders()
            },
        }
        Vue.createApp(app).mount('#Profile');
    </script>
    <style>
        .btn-profie{
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between
        }
        .container{
            margin-top: 3rem;
            margin-bottom: 100px;
            flex: 1 1 auto;
        }

        /* Адаптивная верстка */
        @media (min-width: 480px){

        }
        @media (max-width: 380px){
            .table-wrap{
                overflow-y:scroll; 
            }
            .btn-profie{
                margin-bottom: 1rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between
            }
            .btn-profie a, button{
                margin-bottom: 10px;
                font-size: 14px;
            }
            .col-3{
                width: 70%;
            }
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
