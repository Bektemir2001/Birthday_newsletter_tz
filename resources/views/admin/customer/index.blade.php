@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2>Клиенты</h2>
            <div>
                <button class="btn btn-success" id="sendMailId" data-bs-toggle="modal" data-bs-target="#sendMailModal" onclick="countCheckedUsers()" disabled>Создать Рассылку</button>
                <a href="{{route('customers.create')}}" class="btn btn-primary">Добавить</a>
            </div>

        </div>

        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick="checkAll()">
                            <label class="form-check-label" for="flexCheckDefault">
                            </label>
                        </div>
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">День рождения</th>
                    <th scope="col">Телефон</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckClient{{$customer->id}}" onclick="check(this, '{{$customer->id}}')">
                                <label class="form-check-label" for="flexCheckClient{{$customer->id}}">
                                </label>
                            </div>
                        </th>
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
    @include('includes.SMSModal')
    <script>
        let checked_users = [];
        function checkAll()
        {
            let inputElements = document.querySelectorAll('input');
            checked_users = [];
            if(document.getElementById('flexCheckDefault').checked)
            {
                inputElements.forEach(function(input) {
                    if (input.id && input.id.includes('flexCheckClient')) {
                        let id = input.id.split('flexCheckClient')[1];
                        checked_users.push(id);
                        input.checked = true;
                    }
                });
                document.getElementById('sendMailId').disabled = false;
            }
            else{
                inputElements.forEach(function(input) {
                    if (input.id && input.id.includes('flexCheckClient')) {
                        input.checked = false;
                    }
                });
                document.getElementById('sendMailId').disabled = true;
            }
        }

        function check(input, id)
        {
            if(input.checked)
            {
                checked_users.push(id)
            }
            else{
                checked_users = checked_users.filter(function(item) {
                    return item !== id;
                });
            }

            document.getElementById('sendMailId').disabled = checked_users.length <= 0;
        }

        function countCheckedUsers()
        {
            document.getElementById('checked_users').innerText = `Выбрано: ${checked_users.length}`;
        }

        function sendMail()
        {
            let data = new FormData();
            let name = document.getElementById('name');
            let msg = document.getElementById('msg');
            if(name.value && msg.value)
            {
                data.append('name', name.value);
                data.append('msg', msg.value);
                data.append('customer_ids', checked_users);
                let url = "{{route('sms.store')}}";
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    body: data
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            }
            else{
                document.getElementById('error_msgId').innerText = 'Заполните все поля';
            }
        }
    </script>
@endsection
