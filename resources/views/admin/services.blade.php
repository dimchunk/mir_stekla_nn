@extends('layout.app')
@section('title')
Админ.Услуги
@endsection
@section('content')
    <div class="container mt-5"  id="Service" style="margin-bottom: 100px">
        @if (session()->has('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
        @endif
        <div :class="message ? 'alert alert-primary':''">
            @{{ message }}
        </div>
        <div class="text-center d-flex flex-column align-items-center">
            <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Админ.Услуги</h3>
            <div style="background: #4563B0; height:3px; width: 80px"></div>
        </div>
        <div class="mt-5">
            <form class="col-4" style="margin: 0 auto" id="formAdd" @submit.prevent="add">
                <div class="mb-3">
                  <label for="title" style="color: black" class="form-label">Название</label>
                  <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="title" name="title" :class="errors.title ? 'is-invalid':''">
                  <div :class="errors.title ? 'invalid-feedback':''" v-for="error in errors.title">
                    @{{ error }}
                  </div>
                </div>
                <div class="mb-3">
                    <label for="price" style="color: black" class="form-label">Минимальная цена</label>
                    <input type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="price" name="price" :class="errors.price ? 'is-invalid':''">
                    <div :class="errors.price ? 'invalid-feedback':''" v-for="error in errors.price">
                      @{{ error }}
                    </div>
                  </div>
                <div class="mb-3">
                    <label for="text" style="color: black" class="form-label">Описание</label>
                    <textarea type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="text" name="text" :class="errors.text ? 'is-invalid':''"></textarea>
                    <div :class="errors.text ? 'invalid-feedback':''" v-for="error in errors.text">
                      @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Изображение</label>
                    <input type="file" style="border-radius: 0; border:1px solid black" class="form-control" id="img" name="img" :class="errors.img ? 'is-invalid':''">
                    <div class="invalid-feedback" v-for="error in errors.img">
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
                    <th scope="col">Минимальная цена</th>
                    <th scope="col">Изображение</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="service in services">
                    <th scope="row">@{{ service.id }}</th>
                    <td>@{{ service.title }}</td>
                    <td>@{{ service.price }}</td>
                    <td><img :src="'/public/'+service.img" alt=""></td>
                    <td>
                        <div><a class="btn btn-danger" :href="`{{ route('deleteService') }}/${service.id}`">Удалить</a></div>
                        <div>
                            <button type="button" style="background: #4563B0; color:white" class="btn" data-bs-toggle="modal" :data-bs-target="'#exampleModal'+service.id">
                                Редактировать
                            </button>
                            <div class="modal fade" :id="'exampleModal'+service.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Изменение услуги</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form :id="'formUpdate'+service.id" @submit.prevent="update(service.id)">
                                            <div class="mb-3">
                                                <label for="title" style="color: black" class="form-label">Название</label>
                                                <input :value="service.title" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="title" name="title" :class="errors.title ? 'is-invalid':''">
                                                <div :class="errors.title ? 'invalid-feedback':''" v-for="error in errors.title">
                                                  @{{ error }}
                                                </div>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="price" style="color: black" class="form-label">Минимальная цена</label>
                                                  <input :value="service.price" type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="price" name="price" :class="errors.price ? 'is-invalid':''">
                                                  <div :class="errors.price ? 'invalid-feedback':''" v-for="error in errors.price">
                                                    @{{ error }}
                                                  </div>
                                                </div>
                                              <div class="mb-3">
                                                  <label for="text" style="color: black" class="form-label">Описание</label>
                                                  <textarea type="text" class="form-control" style="border-radius: 0; border:1px solid black" id="text" name="text" :class="errors.text ? 'is-invalid':''">@{{ service.text }}</textarea>
                                                  <div :class="errors.text ? 'invalid-feedback':''" v-for="error in errors.text">
                                                    @{{ error }}
                                                  </div>
                                              </div>
                                              <div class="mb-3">
                                                  <label for="img" class="form-label">Изображение</label>
                                                  <input type="file" style="border-radius: 0; border:1px solid black" class="form-control" id="img" name="img" :class="errors.img ? 'is-invalid':''">
                                                  <div class="invalid-feedback" v-for="error in errors.img">
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
                    services:[]
                }
            },
            methods: {
                async getServices(){
                    const response = await fetch('{{ route('getServices') }}');
                    this.services = await response.json();
                },
                async add(){
                    let form = await document.getElementById('formAdd');
                    let formData = new FormData(form);

                    const response = await fetch('{{ route('addService') }}',{
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
                        this.getServices();
                        setTimeout(() => {
                            this.message = '';
                        }, 3000);
                    }
                },
                async update(id){
                    let form = await document.getElementById('formUpdate'+id);
                    let formData = new FormData(form);
                    formData.append('id', id);

                    const response = await fetch('{{ route('updateService') }}',{
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
                        this.getServices();
                        setTimeout(() => {
                            this.message='';
                        }, 3000);
                    }
                },
            },
            mounted() {
                this.getServices();
            },
        }
        Vue.createApp(app).mount('#Service');
    </script>
    <style>
        .container{
            flex: 1 1 auto;
        }
    </style>
@endsection
