@extends('Master')
@section('sidebar')
    <ul class="nav ">
        {{-- <li class="nav-item {{ Request::is('hoc-sinh/profile*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('hoc-sinh/profile') }}">
                <i class="material-icons">person</i>
                <p>Thống kê</p>
            </a>
        </li> --}}

        <li class="nav-item {{ Request::is('QuanTri/QuanTri*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('QuanTri/QuanTri') }}">
                <i class="material-icons">view_column</i>
                <p>Quản lý giáo viên</p>

            </a>

        </li>
        <li class="nav-item {{ Request::is('QuanTri/QuantriHocsinh*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('QuanTri/QuantriHocsinh/1') }}">
                <i class="material-icons">library_books</i>
                <p>Quản lý học sinh</p>
            </a>
        </li>
        <li class="nav-item {{ Request::is('QuanTri/thongbao*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('QuanTri/thongbao') }}">
                <i class="material-icons">assignment</i>
                <p>Thông báo</p>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    @if (session()->has('thanhcong'))
        <div data-notify="container" class="col-11 col-md-4 alert alert-primary alert-with-icon animated fadeInDown"
            role="alert" data-notify-position="top-right"
            style="display: inline-block; margin: 15px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1031; top: 20px; right: 20px;">
            <button onclick="xoa()" type="button" aria-hidden="true" class="close" data-notify="dismiss"
                style="position: absolute; right: 10px; top: 50%; margin-top: -9px; z-index: 1033;">
                <i class="material-icons">
                    close
                </i>
            </button>
            <i data-notify="icon" class="material-icons">add_alert</i>
            <span data-notify="title"></span>
            <span data-notify="message">
                {{ session()->get('thanhcong') }}
            </span>
            <a href="#" target="_blank" data-notify="url"></a>
        </div>
        <script>
            function xoa() {

                $("div.alert").remove();
            }
            var t = setTimeout(function() {
                $("div.alert").remove();
            }, 5000);

        </script>
    @endif
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="javascript:;">
                        Giao diện quản trị
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav">

                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">

                                <a class="dropdown-item" href="{{url('dangxuat')}}">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-header-tabs card-header-primary">
                        <h4><b>Thông báo</b></h4>
                    </div>

                    <div class="card-body">

                        <br>

                        <a class="btn btn-sm download" href="{{ url('QuanTri/themthongbao') }}">
                            <i class="material-icons">
                                notification_add
                            </i>
                            Thêm thông báo mới
                        </a>
                        @foreach ($thongbao as $item)
                            <hr>
                            <div class="container">
                                <div class="row thong-bao">
                                    <div class="col-sm-9" style="margin-left: 3%">
                                        <a href="{{ url('QuanTri/thongbao/' . $item->id) }}">
                                            <div>
                                                <div>
                                                    <h3 class="card-title"><b>{{ $item->tieu_de }}</b></h3>
                                                    <div style="">
                                                        <p class="">
                                                            @php
                                                            $dt = carbon\Carbon::create($item->ngay_dang,
                                                            'Asia/Ho_Chi_Minh');
                                                            carbon\ Carbon::setLocale('vi');
                                                            @endphp
                                                            <i class="material-icons">access_time</i>

                                                            {{ $dt->diffForHumans(carbon\Carbon::now('Asia/Ho_Chi_Minh')) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{{ url('QuanTri/suathongbao/' . $item->id) }}"
                                            class="edit btn btn-primary btn-sm">Sửa</a>
                                        <a href="{{ url('QuanTri/xoathongbao/' . $item->id) }}"
                                            class="btn btn-danger btn-sm">Xóa</a>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        <hr>


                        <div class="pagination pull-right">
                            <ul class="tab-list">
                                @if ($thongbao->currentPage() != 1)
                                    <li class="thongbao item-list"><a
                                            href="{!!  str_replace('/?', '?', $thongbao->url($thongbao->currentPage() - 1)) !!}">Trước</a>
                                    </li>
                                @endif

                                @for ($i = 1; $i <= $thongbao->lastPage(); $i++)
                                    <li class="item-list thongbao {{ $thongbao->currentPage() == $i ? ' active1' : '' }}">
                                        <a href="{{ str_replace('/?', '?', $thongbao->url($i)) }}"> {{ $i }} </a>
                                    </li>
                                @endfor
                                @if ($thongbao->currentPage() <= $thongbao->lastPage() - 1)
                                    <li class="item-list thongbao">
                                        <a href="{!!  str_replace('/?', '?', $thongbao->url($i + 1)) !!}">
                                            Sau
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
