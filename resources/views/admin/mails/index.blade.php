@extends('layouts.main')
@section('content')
    <style>
        #myPieChart {
            max-width: 400px; /* Максимальная ширина холста */
            max-height: 370px; /* Максимальная высота холста */
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6 d-flex flex-column">
                <div class="card flex-grow-1">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Line Chart</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 d-flex flex-column">
                <div class="card flex-grow-1">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"> Pie Charts</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
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
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($mails as $mail)
                    <tr>
                        <td>{{$mail->id}}</td>
                        <td>{{$mail->name}}</td>
                        <td>{{$mail->status}}</td>
                        <td>
                            <a href="{{route('mailing.show', $mail->id)}}" class="btn btn-primary">смотреть</a>
                            @if($mail->status == 'PENDING')
                                <a href="{{route('mailing.stop', $mail->id)}}" class="btn btn-danger">Остонавить</a>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Статические данные для графика
        var data = {
            labels: ['January', 'February', 'March', 'April', 'May'],
            datasets: [{
                label: 'My First Dataset',
                data: [10, 20, 30, 40, 90], // Пример статических данных
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        // Настройки для графика
        var options = {
            tooltips: {
                callbacks: {
                    label: function(context) {
                        var label = context.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += Math.round(context.parsed / context.dataset.data.reduce((a, b) => a + b) * 100) + '%';
                        return label;
                    }
                }
            }
        };

        // Отрисовка графика
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });
    </script>
    <script>
        // Статические данные для круговой диаграммы
        var data = {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: 'My First Dataset',
                data: [10, 20, 30, 40, 50, 60], // Пример статических данных
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)',
                    'rgb(255, 159, 64)'
                ],
                hoverOffset: 4
            }]
        };

        // Настройки для круговой диаграммы
        var options = {
            plugins: {
                afterDraw: function(chart) {
                    var ctx = chart.ctx;
                    chart.data.datasets.forEach(function(dataset, i) {
                        var meta = chart.getDatasetMeta(i);
                        if (!meta.hidden) {
                            meta.data.forEach(function(element, index) {
                                var centerX = element.getCenterPoint().x;
                                var centerY = element.getCenterPoint().y;
                                var angle = element.options.startAngle + element.options.circumference / 2;
                                var radius = element.innerRadius + (element.outerRadius - element.innerRadius) * 0.5;

                                ctx.save();
                                ctx.translate(centerX, centerY);
                                ctx.rotate(angle);
                                var fontSize = radius * 0.1;
                                ctx.font = fontSize + "px Arial";
                                ctx.fillStyle = 'black';
                                ctx.textBaseline = 'middle';
                                var text = Math.round(dataset.data[index] / dataset.data.reduce((a, b) => a + b) * 100) + "%";
                                var textWidth = ctx.measureText(text).width;
                                ctx.fillText(text, -textWidth / 2, radius * 0.1);
                                ctx.restore();
                            });
                        }
                    });
                }
            }
        };

        // Отрисовка круговой диаграммы
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: options
        });
    </script>



@endsection
