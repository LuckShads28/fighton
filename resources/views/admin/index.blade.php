@extends('admin.layout')

@section('content')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-custom-primary-2">
                    <div class="inner">
                        <h3>{{ $activeTournament->count() }}</h3>
                        <p>Total Turnamen Aktif</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-custom-primary-2">
                    <div class="inner">
                        <h3>{{ $team->count() }}</h3>
                        <p>Total Tim</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-custom-primary-2">
                    <div class="inner">
                        <h3>{{ $organizer->count() }}</h3>
                        <p>Total Organizer</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-custom-primary-2">
                    <div class="inner">
                        <h3>{{ $user->count() }}</h3>
                        <p>Total User</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card bg-custom-primary-2">
                    <div class="card-header">
                        <h3 class="card-title">Data User</h3>
                    </div>
                    <div class="card-body mb-3">
                        <canvas id="donutChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

    @push('script')
        <script src="{{ asset('/') }}assets/vendor/adminlte/plugins/chart.js/Chart.min.js"></script>
        <script>
            $(function() {
                $.get('http://127.0.0.1:8000/admin/dashboard/getUser/', function(data) {
                    //-------------
                    //- DONUT CHART -
                    //-------------
                    // Get context with jQuery - using jQuery's .get() method.
                    console.log(data.controller)
                    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
                    var donutData = {
                        labels: [
                            'Sentinel',
                            'Controller',
                            'Duelist',
                            'Initiator',
                            'No Role'
                        ],
                        datasets: [{
                            data: [data.sentinel, data.controller, data.duelist, data.initiator,
                                data.noRole
                            ],
                            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef',
                                '#3c8dbc'
                            ],
                        }]
                    }
                    var donutOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                    }
                    //Create pie or douhnut chart
                    // You can switch between pie and douhnut using the method below.
                    new Chart(donutChartCanvas, {
                        type: 'doughnut',
                        data: donutData,
                        options: donutOptions
                    })
                })
            })
        </script>
    @endpush
@endsection
