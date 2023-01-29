@extends('layouts.dashboard')

@section('content')
    <section class="section">
        @include('admin.dashboard._filter')

        {{-- DATA DIATAS --}}
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-folder-open"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>BUDGET CAPEX YTD <?php echo date("Y"); ?> </h4>
                        </div>
                        <div class="card-body">
                            {{-- Rp. 668,56Bn --}}
                            {{ Str::num($budget_capex) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-balance-scale "></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Realisasi CAPEX YTD <?php echo date("Y"); ?></h4>
                        </div>
                        <div class="card-body">
                            {{ Str::num($total_realisasi) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check "></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Available CAPEX YTD <?php echo date("Y"); ?></h4>
                        </div>
                        <div class="card-body">
                            {{ Str::num($available_capex) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-percent"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>% Realisasi CAPEX YTD <?php echo date("Y"); ?></h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($persen_realisasi, 2) }}%
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-hourglass"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Pengajuan CAPEX YTD <?php echo date("Y"); ?></h4>
                        </div>
                        <div class="card-body">
                            {{ Str::num($nilai_capex) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-secondary">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>EST. REVENUE YTD <?php echo date("Y"); ?></h4>
                        </div>
                        <div class="card-body">
                            {{-- 1,201 --}}
                            {{ Str::num($rev) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--END DATA DIATAS--}}

        {{--AVG JIB--}}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">JIB Statistics
                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$doc_draft}}</div>
                                <div class="card-stats-item-label">Draft</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$doc_review}}</div>
                                <div class="card-stats-item-label">Review</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$doc_approval}}</div>
                                <div class="card-stats-item-label">Approval</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$doc_return}}</div>
                                <div class="card-stats-item-label">Return</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$doc_rejected}}</div>
                                <div class="card-stats-item-label">Rejected</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$doc_closed}}</div>
                                <div class="card-stats-item-label">Closed</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$doc_total}}</div>
                                <div class="card-stats-item-label">Total</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Average Completion Day /JIB</h4>
                        </div>
                        <div class="card-body">
                            {{$averageTime}} day
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--END AVG JIB--}}

        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Allocation</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart3"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Status JIB</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart4"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>IRR</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart6"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>JIB/UNIT</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart5"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>JIB ONLINE</h4>
                        <div class="card-header-action">
                            <a href="jib/pengajuan" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Inisiator</th>
                                    <th>Pembagian</th>
                                    <th>Nilai CAPEX</th>
                                    <th>Est. Revenue</th>
                                    <th>IRR</th>
                                    <th>Status</th>
                                    <th>Year</th>
                                </tr>
                                @foreach ($jib as $item)
                                <tr>
                                    <td><a href="#">{{ $item->kegiatan}}</a></td>
                                    <td class="font-weight-600">{{ $item->nama_sub_unit }}</td>
                                    <td class="font-weight-600">{{ $item->mcategories->name }}</td>
                                    <td class="font-weight-600">{{ Str::rupiah($item->nilai_capex) }}</td>
                                    <td class="font-weight-600">{{ Str::rupiah($item->est_revenue) }}</td>
                                    <td class="font-weight-600">{{ $item->irr}}</td>
                                    <td class="font-weight-600">{{ $item->mstatuses->name }}</td>
                                    <td class="font-weight-600"> {{\Carbon\Carbon::parse($item->created_at)->format('Y')}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js"></script>
        <script src="{{ asset('admin/stisla/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0"></script>
        <script>
            const counter = {
                id: 'counter',
                beforeDraw(chart, args, options) {
                    const {
                        ctx,
                        chartArea: {
                            left,
                            right,
                            top,
                            bottom,
                            width,
                            height
                        },
                    } = chart;
                    ctx.save();
                    ctx.font = 'bolder 20px Arial';
                    // ctx.font = 2 * window.innerWidth + "px Arial";
                    ctx.fillStyle = 'black';
                    ctx.textAlign = 'center';
                    ctx.fillText('Total JIB : ' + {{ $doc_total }}, width / 2, height - 100);
                    {{--ctx.fillText('Total JIB : ' + {{ $doc_total }}, 0, 0);--}}
                },
            };

            const hoverLabel = {
                id: 'hoverLabel',
                afterDraw(chart, args, options) {
                    const {
                        ctx,
                        chartArea: {left, right, top, bottom, width, height},
                    } = chart;
                    ctx.save();
                    if (chart._active.length > 0) {
                        const textLabel = chart.config.data.labels[chart._active[0].index];
                        const numberLabel =
                            chart.config.data.datasets[chart._active[0].datasetIndex].data[
                                chart._active[0].index
                                ];

                        const sum = chart._metasets[chart._active[0].datasetIndex].total;
                        const percentage = parseFloat((numberLabel / sum * 100).toFixed(1));
                        // const color = 'black';
                        const color =
                            chart.config.data.datasets[chart._active[0].datasetIndex]
                                .backgroundColor[chart._active[0].index];

                        ctx.font = 'bolder 20px Arial';
                        ctx.fillStyle = color;
                        (ctx.textAlign = 'center'),
                            ctx.fillText(`${textLabel}`,
                                width / 2,
                                height / 3 + top,);
                        ctx.fillText(`${percentage}% , ${numberLabel}`,
                            width / 2,
                            height / 2 + top,
                        );
                        ctx.fillText(`Total ${sum} JIB`,
                            width / 2,
                            height / 1.5 + top,);
                    }
                },
            };

            //Start Allocation Chart//
            var data = {
                labels: ['Bisnis', 'Support'],
                datasets: [{
                    label: 'Allocation',
                    data: [
                        {{$bisnis}},
                        {{$support}},
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                    ],
                hoverOffset: 4,
                cutout: '80%',
                }]
            };

            var config = {
                type: 'doughnut',
                data,
                options: {
                    responsive: true,
                    aspectRatio: 2,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    console.log(context)
                                    console.log(context.label)
                                    console.log(context.parsed)

                                    const datapoints = chart.data.datasets[0].data;

                                    function totalSum(total, datapoint) {
                                        return total + datapoint;
                                    }

                                    const totalValue = datapoints.reduce(totalSum, 0)
                                    const percentageValue = (context.parsed / totalValue * 100).toFixed(0);
                                    return `${context.label} : ${percentageValue}%, ${context.parsed}  `;
                                }
                            }
                        }
                    }
                },
                plugins: [counter]
            };

            // render init block
            window.chart = new Chart(
                document.getElementById('myChart3').getContext('2d'),
                config
            );
            //End Allocation Chart

            //Start Status JIB Chart//
            var data = {
                labels: ['Draft', 'Review', 'Approval', 'Return', 'Reject', 'Closed'],
                datasets: [{
                    label: 'Status JIB',
                    data: [
                        {{ $doc_draft }},
                        {{ $doc_review }},
                        {{ $doc_approval }},
                        {{ $doc_return }},
                        {{ $doc_rejected }},
                        {{ $doc_closed }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgb(153, 102, 255,1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    hoverOffset: 4,
                    cutout: '80%',

                }]
            };

            var config = {
                type: 'doughnut',
                data,
                options: {
                    responsive: true,
                    aspectRatio: 2,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    console.log(context)
                                    console.log(context.label)
                                    console.log(context.parsed)

                                    const datapoints = chart.data.datasets[0].data;

                                    function totalSum(total, datapoint) {
                                        return total + datapoint;
                                    }

                                    const totalValue = datapoints.reduce(totalSum, 0)
                                    const percentageValue = (context.parsed / totalValue * 100).toFixed(0);
                                    return `${context.label} : ${percentageValue}%, ${context.parsed}  `;
                                }
                            }
                        }
                    }
                },
                plugins: [counter]
            };

            // render init block
            window.chart = new Chart(
                document.getElementById('myChart4').getContext('2d'),
                config
            );
            //End Status JIB Chart//

            //Start IRR Chart//
            const r = 0;
            const g = 0;
            const b = 255;
            var data = {
                labels: ['<11%', '11% - 15%', '>15%'],
                datasets: [
                @foreach($irr as $unit => $irr_item)
                {
                    label:" {{ $unit }} ",
                    data: [ {{ $irr_item[0] }}, {{ $irr_item[1] }}, {{ $irr_item[2] }}],
                    backgroundColor: [
                        'rgba({{ rand(190, 200) }}, {{ rand(100, 190) }}, {{ rand(100, 190) }}, 0.7)'
                    ],
                    // backgroundColor: [
                    //     'rgba('+r+','+g+','+b+', 0.7)'
                    // ],
                    hoverOffset: 4,
                },
                @endforeach
              ]
            };

            var config = {
                type: 'bar',
                data,
                options: {
                    responsive: true,
                    aspectRatio: 2,
                },
            };

            // render init block
            window.chart = new Chart(
                document.getElementById('myChart6').getContext('2d'),
                config
            );
            //End IRR Chart

            //Start Per UNIT Chart//
            const cek_tot_data = +{{ $doc_total }};
            const backgroundcolor = [];
            for(i=0; i<cek_tot_data; i++){
                const r = Math.floor(Math.random()*255);
                const g = Math.floor(Math.random()*255);
                const b = Math.floor(Math.random()*255);
                backgroundcolor.push('rgba('+r+', '+g+', '+b+', 0.7)');
            }

            var data = {
                labels: [
                    @foreach($pengajuan_by_unit as $unit)
                    '{{ $unit->singkatan_unit }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'JIB per Unit',
                    data: [
                        @foreach($pengajuan_by_unit as $unit)
                            {{ $unit->jumlah }},
                        @endforeach
                    ],
                    backgroundColor: backgroundcolor,
                    hoverOffset: 4,
                    cutout: '80%',
                }]
            };

            var config = {
                type: 'doughnut',
                data,
                options: {
                    responsive: true,
                    aspectRatio: 2,
                },
                plugins: [counter]
            };

            // render init block
            window.chart = new Chart(
                document.getElementById('myChart5').getContext('2d'),
                config
            );
            //End Per UNIT Chart
        </script>
    </section>

@endsection
