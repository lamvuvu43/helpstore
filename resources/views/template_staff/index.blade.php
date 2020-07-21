<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title> @yield('pageTitle')</title>
    <link href="{{asset('/css/styles_admin.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/styles_customer.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" crossorigin="anonymous" />
    <script src="{{ asset('js/font-awesome.5.1.min.js') }}" crossorigin="anonymous"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap4.min.css" rel="stylesheet" />

    <link href="{{ asset('/css/loading.css')}}" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- thêm vào để dùng được phương thức post --}}

    <!-- jQuery library -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- jQuery UI library -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/checkbox.css') }}">
</head>

<body class="sb-nav-fixed">
    <div class="loading">
        <div class="showloading"></div>
    </div>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html">Help Store</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!--Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <!-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" /> -->
                <!-- <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div> -->
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i>{{Auth::user()->username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <!-- <a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity Log</a> -->
                    <!-- <div class="dropdown-divider"></div> -->
                    <!-- <a class="dropdown-item" >Đăng xuất</a> -->
                    <a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">
                        Đăng xuất
                    </a>
                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        {{-- <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a> --}}
                        <div class="sb-sidenav-menu-heading">Thông tin</div>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#KindOfFood" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Đơn hàng
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="KindOfFood" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('order.create') }}">Tạo đơn hành</a>
                                <a class="nav-link" href="{{ route('staff.order_show',Auth::id()) }}">Quản lý đơn hàng</a>

                            </nav>
                        </div>


                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="login.html">Login</a><a class="nav-link" href="register.html">Register</a><a class="nav-link" href="password.html">Forgot Password</a></nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="401.html">401 Page</a><a class="nav-link" href="404.html">404 Page</a><a class="nav-link" href="500.html">500 Page</a></nav>
                                </div>
                            </nav>
                        </div>
                        {{-- <div class="sb-sidenav-menu-heading">Doanh Thu</div>
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Biểu đồ
                        </a><a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Hoá Đơn
                        </a> --}}
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Đăng nhập với tư cách: </div>
                    Nhân Viên
                </div>
            </nav>
        </div>
        {{-- ------ trang thể hiện----- --}}
        <div id="layoutSidenav_content" style="padding-left:100px;overflow:auto;">
            <main>
                <div class="container-fluid" style="padding-left:120px">

                    @yield('staff_create_order')
                    @yield('staff_list_order')

                    {{-- @yield('list_order') --}}

                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        {{-- <div class="text-muted">Copyright &copy; Your Website 2019</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div> --}}
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- -------------------------------------------------------- --}}
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js') }}" crossorigin="anonymous"></script>
    <!-- <script src="assets/demo/chart-area-demo.js"></script> -->
    <!-- <script src="assets/demo/chart-bar-demo.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <!-- <script src="assets/demo/datatables-demo.js"></script> -->
    <script src="{{ asset('/js/loading.js') }}"></script>
    <script>
        // $('.alert-success').hide(1000);
        // $('.alert-danger').hide(1000);

    </script>
</body>


</html>
