@extends('layout.app')
@section('title')
    Информация о заказе
@endsection
@section('content')
    <div class="container mt-5" id="OrderInfoAdmin" style="margin-bottom: 100px">
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
                  @if ($order->status==='Оформлен')
                    <div class="d-flex justify-content-end">
                        <button class="me-4" type="button"  style="color:white; text-transform:uppercase; background: #4563B0; padding:15px; border:none" data-bs-toggle="modal" data-bs-target="#confirmed">
                            Подтвердить заказ
                        </button>

                        <div class="modal fade" id="confirmed" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div style="border-radius: 0" class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Подтверждение заказа</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('confirmedOrder', ['order'=>$order]) }}" method="post">
                                        @method('put')
                                        @csrf
                                        <div class="mb-3">
                                            <label for="price" style="color: black" class="form-label">Итоговая сумма заказа (руб)<span style="color: #4563B0">*</span></label>
                                            <input class="form-control @error('price') is-invalid @enderror" style="border-radius:0; border: 1px solid black; padding:10px 15px" type="text" id="price" name="price" >
                                            <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                                @error('price')
                                                {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center"><button type="submit" style="color:white; text-transform:uppercase; background: #4563B0; padding:15px; border:none">Подтвердить</button></div>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>

                        <button class="me-4" type="button"  style="color:white; text-transform:uppercase; background: #4563B0; padding:15px; border:none" data-bs-toggle="modal" data-bs-target="#cancelOrder">
                            Отменить заказ
                        </button>
                        <div class="modal fade" id="cancelOrder" tabindex="-1" aria-labelledby="cancelOrder" aria-hidden="true">
                            <div class="modal-dialog">
                            <div style="border-radius: 0" class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Отмена заказа</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('canceledOrder',['order'=>$order]) }}" method="post">
                                        @method('put')
                                        @csrf
                                        <div class="mb-3">
                                            <label for="cause" style="color: black" class="form-label">Причина отмены<span style="color: #4563B0">*</span></label>
                                            <input class="form-control @error('cause') is-invalid @enderror" style="border-radius:0; border: 1px solid black; padding:10px 15px" type="text" id="cause" name="cause" >
                                            <div class="invalid-feedback" id="validationServerUsernameFeedback">
                                                @error('cause')
                                                {{$message}}
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center"><button type="submit" style="color:white; text-transform:uppercase; background: #4563B0; padding:15px; border:none">Подтвердить отмену</button></div>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                  @endif
                  @if ($order->status==='Подтвержден')
                    <form action="{{ route('finishedOrder',['order'=>$order]) }}" method="post">
                        @method('put')
                        @csrf
                        <button type="submit" style="color:white; text-transform:uppercase; background: #4563B0; padding:15px; border:none">Завершить заказ</button>
                    </form>
                  @endif
                    <div>

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
        Vue.createApp(app).mount('#OrderInfoAdmin');
    </script>
    <style>
        .container{
            flex: 1 1 auto;
        }
    </style>
@endsection
