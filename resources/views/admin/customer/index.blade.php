@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>Products</h2>
            <a href="{{route('customers.create')}}" class="btn btn-primary">Добавить</a>
        </div>

        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">День рождения</th>
                    <th scope="col">Телефон</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$customer->id}}</td>
                        <td>{{$customer->full_name}}</td>
                        <td>{{$customer->birthday}}</td>
                        <td>{{$customer->phone_number}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
