@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-danger">
                <i class="far fa-newspaper"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>BUDGET CAPEX</h4>
                </div>
                <div class="card-body">
                  Rp. 668,56Bn
                </div>
              </div>
            </div>
          </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Realisasi CAPEX</h4>
              </div>
              <div class="card-body">
                Rp. 59,80Bn
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-circle"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Available CAPEX</h4>
                </div>
                <div class="card-body">
                    Rp. 608,76Bn
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-circle"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>% Realisasi CAPEX</h4>
                </div>
                <div class="card-body">
                  8.94%
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-danger">
                <i class="fas fa-circle"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Nilai CAPEX</h4>
                </div>
                <div class="card-body">
                  {{ Str::rupiah($nilai_capex) }}
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="far fa-file"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>EST. REVENUE</h4>
              </div>
              <div class="card-body">
                {{-- 1,201 --}}
                {{ Str::rupiah($rev) }}
              </div>
            </div>
          </div>
        </div>
      </div>
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="card card-statistic-2">
        <div class="card-stats">
          <div class="card-stats-title">JIB Statistics -
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
              <div class="card-stats-item-count">{{$doc_submit}}</div>
              <div class="card-stats-item-label">Submit</div>
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
            <h4>Average Completion JIB /day</h4>
          </div>
          <div class="card-body">
            {{$doc_avg}}
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
                <td class="font-weight-600">{{ $item->kategori_id}}</td>
                <td class="font-weight-600">{{ $item->nilai_capex}}</td>
                <td class="font-weight-600">{{ $item->est_revenue}}</td>
                <td class="font-weight-600">{{ $item->irr}}</td>
                <td class="font-weight-600">{{ $item->status_id}}</td>
                <td class="font-weight-600"> {{\Carbon\Carbon::parse($item->created_at)->format('Y')}}</td>
                {{-- <td>
                  <a href="#" class="btn btn-primary">Detail</a>
                </td> --}}
                {{-- <td><div class="badge badge-warning">Unpaid</div></td> --}}
              </tr>
              {{-- <tr>
                <td><a href="#">INV-87239</a></td>
                <td class="font-weight-600">Kusnadi</td>
                <td class="font-weight-600">Kusnadi</td>
                <td class="font-weight-600">Kusnadi</td>
                <td><div class="badge badge-warning">Unpaid</div></td>
                <td>July 19, 2018</td>
                <td class="font-weight-600">Kusnadi</td>
                <td class="font-weight-600">Kusnadi</td>
                <td>
                  <a href="#" class="btn btn-primary">Detail</a>
                </td>
              </tr> --}}
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>


//     const ctx = document.getElementById('myChart3').getContext('2d');
//     const myChart = new Chart(ctx, {
//     type: 'doughnut',
//     data: {
//         labels: _labels
//         datasets: [{
//             data: _datas
//             backgroundColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(255, 206, 86, 1)'
//             ],
//             hoverOffset: 4
//         }]
//     },
//     options: {
//         responsive: true,
//     }
//   });

const d_chart = document.getElementById('myChart3').getContext('2d');
const bisnis = {!! json_encode($bisnis) !!};
const support = {!! json_encode($support) !!};
const allocation_chart = new Chart(d_chart, {
    type: 'doughnut',
    data: {
        labels: ['Bisnis', 'Support'],
        datasets: [{
            // label: [
            //     enabled: true,
            //     formatter: function(val, opt) {
            //         return parseInt(val) + '%';
            //     }
            // ],
            data: [
                {{ $bisnis }},
                {{ $support }},

            ],
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
    }
  });


    const ctx1 = document.getElementById('myChart4').getContext('2d');
    const review = {!! json_encode($doc_review) !!};
    const approval = {!! json_encode($doc_approval) !!};
    const closed = {!! json_encode($doc_closed) !!};

    const myChart1 = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Review', 'Approval', 'Closed'],
            datasets: [{
                label: '# of Votes',
                data: [
                        {{$doc_review}},
                        {{$doc_approval}},
                        {{$doc_closed}},
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
        }
  });
</script>
</section>

@endsection

