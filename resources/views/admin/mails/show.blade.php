@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>{{$mailing->name}}</h2>
            @if($mailing->status == 'PENDING')
                <a href="{{route('mailing.stop', $mailing->id)}}" class="btn btn-danger">Остонавить</a>
            @endif
        </div>

        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Телефон номер</th>
                    <th scope="col">Статус</th>
                </tr>
                </thead>
                <tbody>
                @foreach($mailing->customerMails as $mail)
                    <tr>
                        <td>{{$mail->id}}</td>
                        <td>{{$mail->customer->full_name}}</td>
                        <td>{{$mail->customer->email}}</td>
                        <td>{{$mail->customer->phone_number}}</td>
                        <td>{{$mail->status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
