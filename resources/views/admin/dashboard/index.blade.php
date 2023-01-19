@extends('layouts.dashboard')

@section('content')
<section class="section">
  @include('admin.dashboard._filter')
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
                    {{ $persen_realisasi }}%
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
                  <h4>Nilai CAPEX YTD <?php echo date("Y"); ?></h4>
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
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card card-statistic-2">
        <div class="card-stats">
          <div class="card-stats-title">JIB Statistics YTD -
            <div class="dropdown d-inline">
              <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">August</a>
              <ul class="dropdown-menu dropdown-menu-sm">
                <li class="dropdown-title">Select Month</li>
                <li><a href="#" class="dropdown-item">January</a></li>
                <li><a href="#" class="dropdown-item">February</a></li>
                <li><a href="#" class="dropdown-item">March</a></li>
                <li><a href="#" class="dropdown-item">April</a></li>
                <li><a href="#" class="dropdown-item">May</a></li>
                <li><a href="#" class="dropdown-item">June</a></li>
                <li><a href="#" class="dropdown-item">July</a></li>
                <li><a href="#" class="dropdown-item active">August</a></li>
                <li><a href="#" class="dropdown-item">September</a></li>
                <li><a href="#" class="dropdown-item">October</a></li>
                <li><a href="#" class="dropdown-item">November</a></li>
                <li><a href="#" class="dropdown-item">December</a></li>
              </ul>
            </div>
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
    {{-- <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card card-statistic-2">
        <div class="card-chart">
          <canvas id="balance-chart" height="80"></canvas>
        </div>
        <div class="card-icon shadow-primary bg-primary">
          <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Balance</h4>
          </div>
          <div class="card-body">
            $187,13
          </div>
        </div>
      </div>
    </div> --}}
    {{-- <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="card card-statistic-2">
        <div class="card-chart">
          <canvas id="sales-chart" height="80"></canvas>
        </div>
        <div class="card-icon shadow-primary bg-primary">
          <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Sales</h4>
          </div>
          <div class="card-body">
            4,732
          </div>
        </div>
      </div>
    </div> --}}
  </div>
  {{-- <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h4>Budget vs Sales</h4>
        </div>
        <div class="card-body">
          <canvas id="myChart" height="158"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card gradient-bottom">
        <div class="card-header">
          <h4>Top 5 Products</h4>
          <div class="card-header-action dropdown">
            <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Month</a>
            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
              <li class="dropdown-title">Select Period</li>
              <li><a href="#" class="dropdown-item">Today</a></li>
              <li><a href="#" class="dropdown-item">Week</a></li>
              <li><a href="#" class="dropdown-item active">Month</a></li>
              <li><a href="#" class="dropdown-item">This Year</a></li>
            </ul>
          </div>
        </div>
        <div class="card-body" id="top-5-scroll">
          <ul class="list-unstyled list-unstyled-border">
            <li class="media">
              <img class="mr-3 rounded" width="55" src="{{ asset('admin/stisla/assets/img/products/product-3-50.png') }}" alt="product">
              <div class="media-body">
                <div class="float-right"><div class="font-weight-600 text-muted text-small">86 Sales</div></div>
                <div class="media-title">oPhone S9 Limited</div>
                <div class="mt-1">
                  <div class="budget-price">
                    <div class="budget-price-square bg-primary" data-width="64%"></div>
                    <div class="budget-price-label">$68,714</div>
                  </div>
                  <div class="budget-price">
                    <div class="budget-price-square bg-danger" data-width="43%"></div>
                    <div class="budget-price-label">$38,700</div>
                  </div>
                </div>
              </div>
            </li>
            <li class="media">
              <img class="mr-3 rounded" width="55" src="{{ asset('admin/stisla/assets/img/products/product-4-50.png') }}" alt="product">
              <div class="media-body">
                <div class="float-right"><div class="font-weight-600 text-muted text-small">67 Sales</div></div>
                <div class="media-title">iBook Pro 2018</div>
                <div class="mt-1">
                  <div class="budget-price">
                    <div class="budget-price-square bg-primary" data-width="84%"></div>
                    <div class="budget-price-label">$107,133</div>
                  </div>
                  <div class="budget-price">
                    <div class="budget-price-square bg-danger" data-width="60%"></div>
                    <div class="budget-price-label">$91,455</div>
                  </div>
                </div>
              </div>
            </li>
            <li class="media">
              <img class="mr-3 rounded" width="55" src="{{ asset('admin/stisla/assets/img/products/product-1-50.png') }}" alt="product">
              <div class="media-body">
                <div class="float-right"><div class="font-weight-600 text-muted text-small">63 Sales</div></div>
                <div class="media-title">Headphone Blitz</div>
                <div class="mt-1">
                  <div class="budget-price">
                    <div class="budget-price-square bg-primary" data-width="34%"></div>
                    <div class="budget-price-label">$3,717</div>
                  </div>
                  <div class="budget-price">
                    <div class="budget-price-square bg-danger" data-width="28%"></div>
                    <div class="budget-price-label">$2,835</div>
                  </div>
                </div>
              </div>
            </li>
            <li class="media">
              <img class="mr-3 rounded" width="55" src="{{ asset('admin/stisla/assets/img/products/product-3-50.png') }}" alt="product">
              <div class="media-body">
                <div class="float-right"><div class="font-weight-600 text-muted text-small">28 Sales</div></div>
                <div class="media-title">oPhone X Lite</div>
                <div class="mt-1">
                  <div class="budget-price">
                    <div class="budget-price-square bg-primary" data-width="45%"></div>
                    <div class="budget-price-label">$13,972</div>
                  </div>
                  <div class="budget-price">
                    <div class="budget-price-square bg-danger" data-width="30%"></div>
                    <div class="budget-price-label">$9,660</div>
                  </div>
                </div>
              </div>
            </li>
            <li class="media">
              <img class="mr-3 rounded" width="55" src="{{ asset('admin/stisla/assets/img/products/product-5-50.png') }}" alt="product">
              <div class="media-body">
                <div class="float-right"><div class="font-weight-600 text-muted text-small">19 Sales</div></div>
                <div class="media-title">Old Camera</div>
                <div class="mt-1">
                  <div class="budget-price">
                    <div class="budget-price-square bg-primary" data-width="35%"></div>
                    <div class="budget-price-label">$7,391</div>
                  </div>
                  <div class="budget-price">
                    <div class="budget-price-square bg-danger" data-width="28%"></div>
                    <div class="budget-price-label">$5,472</div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="card-footer pt-3 d-flex justify-content-center">
          <div class="budget-price justify-content-center">
            <div class="budget-price-square bg-primary" data-width="20"></div>
            <div class="budget-price-label">Selling Price</div>
          </div>
          <div class="budget-price justify-content-center">
            <div class="budget-price-square bg-danger" data-width="20"></div>
            <div class="budget-price-label">Budget Price</div>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
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
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>JIB ONLINE</h4>
          <div class="card-header-action">
            <a href="#" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
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
                <td class="font-weight-600">{{ $item->nama_sub_unit}}</td>
                <td class="font-weight-600">{{ $item->nama_kategori}}</td>
                <td class="font-weight-600">{{ Str::rupiah($item->nilai_capex) }}</td>
                <td class="font-weight-600">{{ Str::rupiah($item->est_revenue) }}</td>
                <td class="font-weight-600">{{ $item->irr}}</td>
                <td class="font-weight-600">{{ $item->nama_status}}</td>
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

    //Start Allocation Chart//
    const bisnis = {!! json_encode($bisnis) !!};
    const support = {!! json_encode($support) !!};
    const total = {!! json_encode($doc_total) !!};



    const hoverLabel = {
      id: 'hoverLabel',
        afterDraw(chart, args, options) {
          const {
            ctx,
            chartArea: { left, right, top, bottom, width, height },
          } = chart;
          ctx.save();

          if (chart._active.length > 0) {
            const textLabel = chart.config.data.labels[chart._active[0].index];
            const numberLabel =
              chart.config.data.datasets[chart._active[0].datasetIndex].data[
                chart._active[0].index
              ];

            const sum = chart._metasets[chart._active[0].datasetIndex].total;
            const percentage = parseFloat((numberLabel/sum*100).toFixed(1));
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
            ctx.fillText(`${percentage}% , ${numberLabel}` ,
              width / 2,
              height / 2 + top,
            );
            ctx.fillText(`Total ${sum} JIB`,
              width / 2,
              height / 1.5 + top,);
          }
          // else if(chart._active.length  =! 0) {
          //   Chart.pluginService.register({
          //     beforeDraw: function (chart) {
          //         var width = chart.chart.width,
          //             height = chart.chart.height,
          //             ctx = chart.chart.ctx;
          //         ctx.restore();
          //         var fontSize = (height / 114).toFixed(2);
          //         ctx.font = fontSize + "em sans-serif";
          //         ctx.textBaseline = "middle";
          //         var text = chart.config.options.elements.center.text,
          //             textX = Math.round((width - ctx.measureText(text).width) / 2),
          //             textY = height / 2;
          //         ctx.fillText(text, textX, textY);
          //         ctx.save();
          //     }
          //   });
          // }
      },
    };

    var data = {
        labels: ['Bisnis', 'Support'],
        datasets: [{
        label: 'Status JIB',
        data: [
            {{$bisnis}},
            {{$support}},
        ],
        backgroundColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(255, 206, 86, 1)'
        ],
        hoverOffset : 4,
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
      plugins : [hoverLabel]
    };

    // render init block
    window.chart = new Chart(
      document.getElementById('myChart3').getContext('2d'),
      config
    );
    //End Allocation Chart

    //Start Status JIB Chart//
    // const review = {!! json_encode($doc_review) !!};
    // const approval = {!! json_encode($doc_approval) !!};
    // const closed = {!! json_encode($doc_closed) !!};
    // const initiator = {!! json_encode($doc_return) !!};
    // const draft = {!! json_encode($doc_draft) !!};
    // const rejected = {!! json_encode($doc_rejected) !!};

    var data = {
        labels: ['Draft', 'Review', 'Approval', 'Return', 'Reject', 'Closed'],
        datasets: [{
        label: 'Status JIB',
        data: [
            {{$doc_draft}},
            {{$doc_review}},
            {{$doc_approval}},
            {{$doc_return}},
            {{$doc_rejected}},
            {{$doc_closed}}
        ],
        backgroundColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 205, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgb(153, 102, 255,1)',
            'rgba(255, 99, 132, 1)',
            'rgba(201, 203, 207, 1)'
        ],
        hoverOffset : 4,
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
      plugins : [hoverLabel]
    };

    // render init block
    window.chart = new Chart(
      document.getElementById('myChart4').getContext('2d'),
      config
    );
    //End Status JIB Chart//

    if(jQuery().daterangepicker) {
    if($(".dtpick").length) {
      $('.dtpick').daterangepicker({
        locale: {format: 'DD-MM-YYYY'},
        singleDatePicker: true,
      });
    }
  }


</script>
</section>

@endsection

