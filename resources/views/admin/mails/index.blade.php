@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>Рассылки</h2>
        </div>

        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($mails as $mail)
                    <tr>
                        <td>{{$mail->id}}</td>
                        <td>{{$mail->name}}</td>
                        <td>{{$mail->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
