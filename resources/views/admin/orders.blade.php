@extends('layout.app')
@section('title')
Админ.Заказы
@endsection
@section('content')
<div class="container mt-5" id="Orders" style="margin-bottom: 100px">
    <div class="text-center d-flex flex-column align-items-center mb-5">
        <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Управление заказами</h3>
        <div style="background: #4563B0; height:3px; width: 80px"></div>
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
        <table class="table">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col">Пользователь</th>
                <th scope="col">Дата оформления - завершения</th>
                <th scope="col">Статус</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr style="line-height: 40px" v-for="order in data">
                <td>@{{ order.id }}</td>
                <td>@{{ order.user.surname }} @{{ order.user.name }}</td>
                <td>@{{ order.date_start }} - @{{ order.date_end }}</td>
                <td>@{{ order.status }}</td>
                <td>
                    <a :href="`{{ route('pageAdminInfo') }}/${order.id}`" style="font-weight:500;text-decoration: none; color:white; text-transform:uppercase; background: #4563B0; padding:10px 15px; border:none">Подробнее</a>
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
                    orders:[],
                    filter_parameter:0,
                    data:[]
                }
            },
            methods: {
                async getOrders(){
                    const response = await fetch('{{ route('getOrdersAdmin') }}');
                    this.orders = await response.json();
                },
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
                this.getOrders();
            },
        }
        Vue.createApp(app).mount('#Orders');
    </script>
    <style>
        .container{
            flex: 1 1 auto;
        }
    </style>
@endsection
