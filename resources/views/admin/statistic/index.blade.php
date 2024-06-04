@extends('admin.layout.app')
@section('title', 'THỐNG KÊ')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container-fluid">
        <style type="text/css">
            p.title_thongke {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
            }

            .form-inline .form-group {
                margin-right: 15px;
            }

            .form-inline .form-group:last-child {
                margin-right: 0;
            }

            .dashboard-filter {
                width: auto;
            }
        </style>

        {{-- Thống kê tổng doanh số  --}}
        <div class="row mt-4">
            <div class="col-md-4 col-xs-12">
                <p class="title_thongke">Tổng số đơn hàng</p>
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Tổng đơn hàng</div>
                    <div class="card-body">
                        <h5 class="card-title" id="total_orders">{{ $totalOrders }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <p class="title_thongke">Tổng số lượng sản phẩm</p>
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">Tổng số lượng</div>
                    <div class="card-body">
                        <h5 class="card-title" id="total_quantity">{{ $totalQuantity }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <p class="title_thongke">Tổng doanh thu</p>
                <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Tổng doanh thu</div>
                    <div class="card-body">
                        <h5 class="card-title" id="total_revenue">{{ number_format($totalRevenue) }} VNĐ</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Thống kê đơn hàng doanh số --}}
        <div class="row">
            <p class="title_thongke">Thống kê đơn hàng doanh số</p>
            <form class="form-inline" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="datepicker">Từ ngày:</label>
                    <input type="text" id="datepicker" class="form-control ml-2" name="from_date">
                </div>
                <div class="form-group">
                    <label for="datepicker2">Đến ngày:</label>
                    <input type="text" id="datepicker2" class="form-control ml-2" name="to_date">
                </div>
                <div class="form-group">
                    <button type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm ml-2">Lọc kết
                        quả</button>
                </div>

                <div class="form-group">
                    <label for="dashboard-filter">Lọc theo:</label>
                    <select id="dashboard-filter" class="dashboard-filter form-control ml-2">
                        <option>---Chọn---</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">Tháng trước</option>
                        <option value="thangnay">Tháng này</option>
                        <option value="365ngayqua">365 ngày qua</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="col-md-12">
            <div id="myfirstchart" class="chart" style="height: 250px;"></div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                var chart = new Morris.Bar({
                    element: 'myfirstchart',
                    lineColors: ['#819C79', '#fc8710', '#FF6541', '#A4AD03'],
                    fillOpacity: 0.6,
                    hideHover: 'auto',
                    xkey: 'period',
                    ykeys: ['order', 'sales', 'quantity'],
                    labels: ['Đơn hàng', 'Doanh số', 'Số lượng']
                });

                function updateChartData(data) {
                    chart.setData(data.chart_data);
                    $('#total_orders').text(data.total_orders);
                    $('#total_quantity').text(data.total_quantity);
                    $('#total_revenue').text(formatCurrency(data.total_revenue));
                }

                function chart30daysorder() {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('statistic.days_order') }}",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            _token: _token
                        },
                        success: function(data) {
                            updateChartData(data);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseJSON.message);
                        }
                    });
                }

                $('.dashboard-filter').change(function() {
                    var dashboard_value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('statistic.dashboard_filter') }}",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            dashboard_value: dashboard_value,
                            _token: _token
                        },
                        success: function(data) {
                            updateChartData(data);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseJSON.message);
                        }
                    });
                });

                $('#btn-dashboard-filter').click(function() {
                    var _token = $('input[name="_token"]').val();
                    var from_date = $('#datepicker').val();
                    var to_date = $('#datepicker2').val();

                    $.ajax({
                        url: "{{ route('statistic.filter_by_date') }}",
                        method: "POST",
                        dataType: "JSON",
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            _token: _token
                        },
                        success: function(data) {
                            updateChartData(data);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseJSON.message);
                        }
                    });
                });

                chart30daysorder();
            });

            function formatCurrency(amount) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
            }
        </script>
    @endsection
