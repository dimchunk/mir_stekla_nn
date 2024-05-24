@extends('layout.app')
@section('title')
    Оформление заказа
@endsection
@section('content')
    <div class="container" id="Order">
        <div :class="message ? 'alert alert-primary':''">
            @{{ message }}
        </div>
        @if (session()->has('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
        @endif
        <div class="text-center d-flex flex-column align-items-center mb-5">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Оформление заказа</h3>
           <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
        <div class="mb-3">
           <form id="formAdd" @submit.prevent="add">
                <div class="f-1">
                    <div class="mb-3 col-5">
                        <label for="category" class="form-label">Категория стеклопакета</label>
                        <select style="border: 1px solid black; border-radius:0" class="form-select" name="category" id="category" v-model="choise_category">
                            <option v-for="c in categories" :value="c.id">@{{ c.title }}</option>
                        </select>
                        <div><button class="btn btn-primary col-12" hidden @click='filter'>Применить</button></div>
                        <div class="invalid-feedback" v-for="error in errors.price_id">
                            @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3 col-5">
                        <label for="price_id" class="form-label">Наименование</label>
                        <select style="border: 1px solid black; border-radius:0" class="form-select" name="price_id" id="price_id" :class="errors.price_id ? 'is-invalid':''">
                            <option value="0" selected></option>
                            <option v-for="p in data" :value="p.id">@{{ p.title }} (@{{ p.formula }})</option>
                        </select>
                        <div class="invalid-feedback" v-for="error in errors.price_id">
                            @{{ error }}
                        </div>
                    </div>
                </div>
                <div class="f-2">
                    <div class="mb-3 col-3">
                        <label for="width" style="color: black" class="form-label">Ширина (мм)</label>
                        <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="width" name="width" :class="errors.width ? 'is-invalid':''">
                        <div :class="errors.width ? 'invalid-feedback':''" v-for="error in errors.width">
                        @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3 col-3">
                        <label for="height" style="color: black" class="form-label">Длина (мм)</label>
                        <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="height" name="height" :class="errors.height ? 'is-invalid':''">
                        <div :class="errors.height ? 'invalid-feedback':''" v-for="error in errors.height">
                        @{{ error }}
                        </div>
                    </div>
                    <div class="mb-3 col-3">
                        <label for="count" style="color: black" class="form-label">Количество</label>
                        <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="count" name="count" :class="errors.count ? 'is-invalid':''">
                        <div :class="errors.count ? 'invalid-feedback':''" v-for="error in errors.count">
                        @{{ error }}
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center"><button type="submit" style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none">Добавить позицию</button></div>
            </form>
        </div>

        <div>
            <h3 style="font-weight:400">Позиции</h3>
            <div>
                <div class="table-wrap mb-1">
                    <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Наименование</th>
                        <th scope="col">Размеры (мм)</th>
                        <th scope="col">Кол-во</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="line-height: 40px" v-for="item in items">
                        <td>@{{ item.price.title }} (@{{ item.price.formula }})</td>
                        <td>@{{ item.width }}X@{{ item.height }}</td>
                        <td>@{{ item.count }}</td>
                        <td class="d-flex justify-content-between align-items-center">
                            <a :href="`{{ route('deleteItem') }}/${item.id}`" class="btn-order">Удалить</a>
                            <button type="button" data-bs-toggle="modal" :data-bs-target="'#updateOrder'+item.id"  style="border: #4563B0 1px solid; padding:0px 15px; text-decoration:none; text-transform:uppercase; color:#000; background:white">
                                Редактировать
                            </button>

                            <div class="modal fade" :id="'updateOrder'+item.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div style="border-radius: 0" class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Редактирование данных</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form :id="'formUpdate'+item.id" @submit.prevent="update(item.id)">
                                                <div class="mb-3">
                                                    <label for="category" class="form-label">Категория стеклопакета</label>
                                                    <select style="border: 1px solid black; border-radius:0" class="form-select" name="category" id="category" v-model="choise_category">
                                                        <option v-for="c in categories" :value="c.id">@{{ c.title }}</option>
                                                    </select>
                                                    <div><button class="btn btn-primary col-12" hidden @click='filter'>Применить</button></div>
                                                    <div class="invalid-feedback" v-for="error in errors.price_id">
                                                        @{{ error }}
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="price_id" class="form-label">Наименование</label>
                                                    <select style="border: 1px solid black; border-radius:0" class="form-select" name="price_id" id="price_id" :class="errors.price_id ? 'is-invalid':''">
                                                        <option :value="item.price.id" selected>@{{ item.price.formula }}</option>
                                                        <option v-for="p in data" :value="p.id">@{{ p.formula }}</option>
                                                    </select>
                                                    <div class="invalid-feedback" v-for="error in errors.price_id">
                                                        @{{ error }}
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="width" style="color: black" class="form-label">Ширина (мм)</label>
                                                    <input :value="item.width" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="width" name="width" :class="errors.width ? 'is-invalid':''">
                                                    <div :class="errors.width ? 'invalid-feedback':''" v-for="error in errors.width">
                                                    @{{ error }}
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="height" style="color: black" class="form-label">Длина (мм)</label>
                                                    <input :value="item.height" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="height" name="height" :class="errors.height ? 'is-invalid':''">
                                                    <div :class="errors.height ? 'invalid-feedback':''" v-for="error in errors.height">
                                                    @{{ error }}
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="count" style="color: black" class="form-label">Количество</label>
                                                    <input :value="item.count" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="count" name="count" :class="errors.count ? 'is-invalid':''">
                                                    <div :class="errors.count ? 'invalid-feedback':''" v-for="error in errors.count">
                                                    @{{ error }}
                                                    </div>
                                                </div>

                                            <div class="d-flex justify-content-center"><button type="submit" style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none">Сохранить</button></div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </td>
                      </tr>
                    </tbody>
                </table>
                </div>
                
                  <div class="b-place">
                    <form @submit.prevent="placed" id="formPlaced">
                        <button type="submit" style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none">Оформить заказ</и>
                    </form>
                </div>
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
                async getGlasses(){
                    const response = await fetch('{{ route('getGlasses') }}');
                    this.categories = await response.json();
                },
                async getPriceGlasses(){
                    const response = await fetch('{{ route('getPriceGlasses') }}');
                    this.prices = await response.json();
                },
                async getOrder(){
                    const response = await fetch('{{ route('getOrder') }}');
                    this.items = await response.json();
                    console.log(this.items);
                },
                async placed(){
                    let form = await document.getElementById('formPlaced');
                    let formData = new FormData(form);

                    const response = await fetch('{{ route('placedOrder') }}',{
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
                        window.location = response.url;
                    }
                },
                async add(){
                    let form = await document.getElementById('formAdd');
                    let formData = new FormData(form);

                    const response = await fetch('{{ route('ItemAdd') }}',{
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
                        this.getOrder();
                        setTimeout(()=>{
                            this.message = '';
                        }, 3000);
                    }
                },
                async update(id){
                    let form = await document.getElementById('formUpdate'+id);
                    let formData = new FormData(form);
                    formData.append('id', id);

                    const response = await fetch('{{ route('updateItem') }}',{
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
                        this.getOrder();
                        setTimeout(() => {
                            this.message='';
                        }, 3000);
                    }
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
                this.getPriceGlasses();
                this.getGlasses();
                this.getOrder();
            },
        }
        Vue.createApp(app).mount('#Order');
    </script>
    <style>
        .btn-order{
            border: #4563B0 1px solid; 
            padding:1px 15px; 
            text-decoration:none; 
            text-transform:uppercase; 
            color:#000
        }
        .b-place{
            display: flex;
            justify-content: end;
        }
        .f-1{
            display: flex;
            justify-content: space-between;
        }
        .f-2{
            display: flex;
            justify-content: space-between;
        }
        .container{
            flex: 1 1 auto;
            margin-top: 3rem;
            margin-bottom: 100px;
        }
        /* Адаптивная верстка */
        @media (min-width: 480px){

        }
        @media (max-width: 380px){
            .btn-order{
                padding:0 10px;
                margin-right: 3px;
            }
            .table-wrap{
                overflow-y:scroll; 
            }
            .b-place{
                display: flex;
                justify-content: center;
            }
            .f-1{
                flex-direction: column;
                align-items: center;
            }
            .f-2{
                flex-direction: column;
                align-items: center;
            }
            .col-3{
                width: 90%;    
            }
            .col-5{
                width: 90%;
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
