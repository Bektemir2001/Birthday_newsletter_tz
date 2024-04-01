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
                            <h4 class="card-title">Количества отправленных сообщений за 7 дней</h4>
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
                            <h4 class="card-title">Все сообщения</h4>
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
            <a href="{{route('customers.index')}}" class="btn btn-success">Создать Рассылку</a>
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
        function drawChart()
        {
            let url = "{{route('mailing.chart')}}";
            fetch(url, {
                headers: {

                }
            })
                .then(response => response.json())
                .then(data => {
                    data = data.data;
                    data = {
                        labels: data.dates,
                        datasets: [{
                            label: 'Количества отправленных сообщений за 7 дней',
                            data: data.counts,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    };

                    // Настройки для графика
                    let options = {
                        tooltips: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += Math.round(context.parsed / context.dataset.data.reduce((a, b) => a + b) * 100) + '%';
                                    return label;
                                }
                            }
                        }
                    };

                    let ctx = document.getElementById('myChart').getContext('2d');
                    let myChart = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: options
                    });
                });
        }
        drawChart();
    </script>
    <script>
        function drawPie()
        {
            let url = "{{route('mailing.pie')}}";
            fetch(url, {
                headers: {

                }
            })
                .then(response => response.json())
                .then(data => {
                    data = data.data;
                    let colors = ['rgb(54, 162, 235)','rgb(75, 192, 192)', 'rgb(255, 99, 132)', 'rgb(255, 205, 86)'];
                    let dataColors = [];
                    for(let i = 0; i < data.counts.length; i++)
                    {
                        dataColors.push(colors[i]);
                    }
                    data = {
                        labels: data.statuses,
                        datasets: [{
                            label: '',
                            data: data.counts, // Пример статических данных
                            backgroundColor: dataColors,
                            hoverOffset: 4
                        }]
                    };

                    // Настройки для круговой диаграммы
                    let options = {
                        plugins: {
                            afterDraw: function(chart) {
                                let ctx = chart.ctx;
                                chart.data.datasets.forEach(function(dataset, i) {
                                    let meta = chart.getDatasetMeta(i);
                                    if (!meta.hidden) {
                                        meta.data.forEach(function(element, index) {
                                            let centerX = element.getCenterPoint().x;
                                            let centerY = element.getCenterPoint().y;
                                            let angle = element.options.startAngle + element.options.circumference / 2;
                                            let radius = element.innerRadius + (element.outerRadius - element.innerRadius) * 0.5;

                                            ctx.save();
                                            ctx.translate(centerX, centerY);
                                            ctx.rotate(angle);
                                            let fontSize = radius * 0.1;
                                            ctx.font = fontSize + "px Arial";
                                            ctx.fillStyle = 'black';
                                            ctx.textBaseline = 'middle';
                                            let text = Math.round(dataset.data[index] / dataset.data.reduce((a, b) => a + b) * 100) + "%";
                                            let textWidth = ctx.measureText(text).width;
                                            ctx.fillText(text, -textWidth / 2, radius * 0.1);
                                            ctx.restore();
                                        });
                                    }
                                });
                            }
                        }
                    };

                    // Отрисовка круговой диаграммы
                    let ctx = document.getElementById('myPieChart').getContext('2d');
                    let myPieChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: options
                    });
                });
        }
        drawPie();

    </script>



@endsection
