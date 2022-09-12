@extends('client.layout.app')


@section('content')
    <div class="area-chart-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="area-chart" id="chartContainer">

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="area-chart-wp sm-res-mg-t-30">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <script src="/client/js/charts/canvasjs.min.js"></script>
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Desktop Search Engine Market Share - 2016",
                    fontSize: 20,
                },
                data: [{
                    type: "column",
                    startAngle: 240,
                    yValueFormatString: "##0.00\"%\"",
                    indexLabel: "{label} {y}",
                    dataPoints: [{
                            y: 79.45,
                            label: "Google"
                        },
                        {
                            y: 7.31,
                            label: "Bing"
                        },
                        {
                            y: 7.06,
                            label: "Baidu"
                        },
                        {
                            y: 4.91,
                            label: "Yahoo"
                        },
                        {
                            y: 1.26,
                            label: "Others"
                        }
                    ]
                }]
            });
            chart.render();

        }
    </script>
@endsection
