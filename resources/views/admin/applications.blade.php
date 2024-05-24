@extends('layout.app')
@section('title')
Админ.Заявки
@endsection
@section('content')
<div class="container mt-5" id="Applications" style="margin-bottom: 100px">
    <div class="text-center d-flex flex-column align-items-center mb-5">
        <h3 class="mb-2" style="font-family: 'Unbounded'; font-weight:400">Заявки</h3>
        <div style="background: #4563B0; height:3px; width: 80px"></div>
    </div>
    <div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Номер телефона</th>
                <th scope="col">Текст</th>
              </tr>
            </thead>
            <tbody>
              <tr style="line-height: 40px" v-for="application in applications">
                <td>@{{ application.id }}</td>
                <td>@{{ application.name }}</td>
                <td>@{{ application.phone }}</td>
                <td>@{{ application.text }}</td>
              </tr>
            </tbody>
          </table>
    </div>
</div>
    <script>
        const app = {
            data() {
                return {
                    applications:[]
                }
            },
            methods: {
                async getApplications(){
                    const response = await fetch('{{ route('getApplications') }}');
                    this.applications = await response.json();
                },
            },
            mounted() {
                this.getApplications();
            },
        }
        Vue.createApp(app).mount('#Applications');
    </script>
    <style>
        .container{
            flex: 1 1 auto;
        }
    </style>
@endsection
