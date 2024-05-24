@extends('layout.app')
@section('title')
Админ.Цены
@endsection
@section('content')
    <div class="container mt-5" id="Price" style="margin-bottom: 100px">
        @if (session()->has('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
        @endif
        <div :class="message ? 'alert alert-primary':''">
            @{{ message }}
        </div>
        <div class="text-center d-flex flex-column align-items-center">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Админ.Цены</h3>
            <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
        <div class="mt-5">
            <form class="col-4" style="margin: 0 auto" id="formAdd" @submit.prevent="add">
                <div class="mb-3">
                    <label style="color: black" for="service_id" class="form-label">Услуга</label>
                    <select class="form-select" name="service_id" id="service_id" style="border: 1px solid black; border-radius:0" :class="errors.service_id ? 'is-invalid':''">
                        <option v-for="service in services" :value="service.id">@{{ service.title }}</option>
                    </select>
                    <div :class="errors.service_id ? 'invalid-feedback':''" v-for="error in errors.service_id">
                        @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                  <label for="title" style="color: black" class="form-label">Название</label>
                  <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="title" name="title" :class="errors.title ? 'is-invalid':''">
                  <div :class="errors.title ? 'invalid-feedback':''" v-for="error in errors.title">
                    @{{ error }}
                  </div>
                </div>
                <div class="mb-3">
                    <label for="price" style="color: black" class="form-label">Цена за кв/м</label>
                    <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="price" name="price" :class="errors.price ? 'is-invalid':''">
                    <div :class="errors.price ? 'invalid-feedback':''" v-for="error in errors.price">
                      @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="formula" style="color: black" class="form-label">Формула (если есть)</label>
                    <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="formula" name="formula" :class="errors.formula ? 'is-invalid':''">
                    <div :class="errors.formula ? 'invalid-feedback':''" v-for="error in errors.formula">
                      @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label style="color: black" for="glass_id" class="form-label">Стеклопакет (если есть)</label>
                    <select class="form-select" name="glass_id" id="glass_id" style="border: 1px solid black; border-radius:0" :class="errors.glass_id ? 'is-invalid':''">
                        <option selected></option>
                        <option v-for="c in categories" :value="c.id">@{{ c.title }}</option>
                    </select>
                    <div :class="errors.glass_id ? 'invalid-feedback':''" v-for="error in errors.glass_id">
                        @{{ error }}
                    </div>
                </div>
                <div class="d-flex justify-content-center"><button type="submit" style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none">Добавить</button></div>
            </form>
        </div>
        <div class="mt-4">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Цена за кв/м</th>
                    <th scope="col">Услуга</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="price in prices">
                    <th scope="row">@{{ price.id }}</th>
                    <td>@{{ price.title }}</td>
                    <td>@{{ price.price }}</td>
                    <td>@{{ price.service.title }}</td>
                    <td>
                        <div><a class="btn btn-danger" :href="`{{ route('deletePrice') }}/${price.id}`">Удалить</a></div>
                        <div>
                            <button type="button" style="background: #4563B0; color:white" class="btn" data-bs-toggle="modal" :data-bs-target="'#exampleModal'+price.id">
                                Редактировать
                            </button>
                            <div class="modal fade" :id="'exampleModal'+price.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Изменение услуги</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form :id="'formUpdate'+price.id" @submit.prevent="update(price.id)">
                                            <div class="mb-3">
                                                <label for="title" style="color: black" class="form-label">Название</label>
                                                <input :value="price.title" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="title" name="title" :class="errors.title ? 'is-invalid':''">
                                                <div :class="errors.title ? 'invalid-feedback':''" v-for="error in errors.title">
                                                  @{{ error }}
                                                </div>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="price" style="color: black" class="form-label">Минимальная цена</label>
                                                  <input :value="price.price" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="price" name="price" :class="errors.price ? 'is-invalid':''">
                                                  <div :class="errors.price ? 'invalid-feedback':''" v-for="error in errors.price">
                                                    @{{ error }}
                                                  </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="service_id" class="form-label">Услуга</label>
                                                    <select class="form-select" name="service_id" id="service_id" :class="errors.service_id ? 'is-invalid':''">
                                                        <option v-for="service in services" :value="service.id">@{{ service.title }}</option>
                                                    </select>
                                                    <div :class="errors.service_id ? 'invalid-feedback':''" v-for="error in errors.service_id">
                                                        @{{ error }}
                                                    </div>
                                                </div>
                                            <button type="submit" style="background: #4563B0; color:white" class="btn">Сохранить</button>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
    <script>
        const app = {
            data() {
                return {
                    errors:[],
                    message:'',
                    services:[],
                    prices:[],
                    categories:[],
                }
            },
            methods: {
                async getServices(){
                    const response = await fetch('{{ route('getServices') }}');
                    this.services = await response.json();
                },
                async getGlasses(){
                    const response = await fetch('{{ route('getGlasses') }}');
                    this.categories = await response.json();
                },
                async getPrices(){
                    const response = await fetch('{{ route('getPrices') }}');
                    this.prices = await response.json();
                },
                async add(){
                    let form = await document.getElementById('formAdd');
                    let formData = new FormData(form);

                    const response = await fetch('{{ route('addPrice') }}',{
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
                        this.getPrices();
                        setTimeout(() => {
                            this.message = '';
                        }, 3000);
                    }
                },
                async update(id){
                    let form = await document.getElementById('formUpdate'+id);
                    let formData = new FormData(form);
                    formData.append('id', id);

                    const response = await fetch('{{ route('updatePrice') }}',{
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
                        this.getPrices();
                        setTimeout(() => {
                            this.message='';
                        }, 3000);
                    }
                },
            },
            mounted() {
                this.getServices();
                this.getPrices();
                this.getGlasses();
            },
        }
        Vue.createApp(app).mount('#Price');
    </script>
    <style>
        .container{
            flex: 1 1 auto;
        }
    </style>
@endsection
