<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <title>:: GEEBIN ::</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->

    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('/assets/css/al.style.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/assets/css/dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/select2.min.css') }}">

    <!-- project layout css file -->
    <link rel="stylesheet" href="{{ asset('/assets/css/layout.p.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
</head>

<body>

    <div id="layout-p" class="theme-red">

        <!-- Navigation -->
        <div class="header fixed-top">
            <div class="container-fluid">
                <nav class="navbar navbar-light px-md-2">

                    <!-- Search -->
                    <div class="h-left d-flex flex-grow-1 me-md-4 me-0">
                        <ul class="nav nav-tabs inbox-tab tab-card border-bottom-0 me-sm-2" role="tablist">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Supar Admin</a>
                            </li>
                        </ul>
                        <div class="main-search flex-fill d-none d-sm-block">
                            <input class="form-control" type="text" placeholder="Enter your search key word">
                            <div class="card border-0 shadow rounded-3 search-result slidedown">
                                <div class="card-body text-start">

                                    <small class="dropdown-header">Recent searches</small>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- header rightbar icon -->
                    <div class="h-right justify-content-end d-flex align-items-center">
                        <div class="dropdown notifications me-2 d-none d-sm-block">
                            <a class="nav-link dropdown-toggle pulse p-1" href="#" role="button" data-bs-toggle="dropdown"><i class="fa fa-bell text-primary"></i></a>
                            <div id="NotificationsDiv" class="dropdown-menu rounded-lg shadow border-0 dropdown-menu-end p-0 m-0">
                                <div class="card border-0 w380">
                                    <div class="card-header bg-primary border-0 p-3">
                                        <h5 class="mb-0 d-flex justify-content-between">
                                            <span>Notifications Center</span>
                                            <span>0</span>
                                        </h5>

                                    </div>
                                    <a class="card-footer text-center border-top-0" href="#"> View all notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown user-profile ms-2">
                            <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown">
                                <img class="avatar rounded-circle p-1" src="{{ asset('/assets/images/profile_av.png') }}" alt="">
                            </a>
                            <div class="dropdown-menu rounded-lg shadow border-0 dropdown-menu-end">
                                <div class="card border-0 w240">
                                    <div class="card-body border-bottom">
                                        <div class="d-flex py-1">
                                            <img class="avatar rounded-circle" src="{{ asset('/assets/images/profile_av.png') }}" alt="">
                                            <div class="flex-fill ms-3">
                                                <p class="mb-0 text-muted"><span class="fw-bold">{{ Auth::user()->name }}</span></p>
                                                <small class="text-muted">{{ Auth::user()->email }}</small>
                                                <div>
                                                    <a href="{{ route('logout') }}" class="card-link">Sign out</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group m-2">
                                        <a href="#" class="list-group-item list-group-item-action border-0">Branch:<span class="text-primary"> {{ Session::get('bname') }}</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary d-none menu-toggle ms-3" type="button"><i class="fa fa-bars"></i></button>
                    </div>

                </nav>
            </div>
        </div>

        @include("nav")

        <!-- main body area -->
        <div class="main">

            <!-- Body: Header -->
            <div class="body-header border-0 rounded-0 px-xl-4 px-md-2 mb-5">
                <div class="container-fluid">

                    <!--<div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <ol class="breadcrumb rounded-0 mb-0 ps-0 bg-transparent flex-grow-1">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>

            @yield("content")

            <!-- Body: Footer -->
            <div class="body-footer px-xl-4 px-md-2">
                <div class="container-fluid">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                    <p class="font-size-sm mb-0">© GeeBin. <span class="d-none d-sm-inline-block">
                                            <script>
                                                document.write(/\d{4}/.exec(Date())[0])
                                            </script>.
                                        </span></p>
                                </div>
                                <div class="col-auto">
                                    <ul class="list-inline d-flex justify-content-end mb-0">
                                        <li class="list-inline-item"><a class="list-separator-link" href="https://www.liexa.in" target="_blank">Developed and Maintained by Liexa Creations</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('/assets/bundles/libscripts.bundle.js') }}"></script>

    <!-- Plugin Js -->
    <!--<script src="{{ asset('/assets/bundles/apexcharts.bundle.js') }}"></script>-->
    <script src="{{ asset('/assets/bundles/dataTables.bundle.js') }}"></script>
    <script src="{{ asset('/assets/bundles/select2.bundle.js') }}"></script>

    <!-- Jquery Page Js -->
    <script src="{{ asset('/assets/js/template.js') }}"></script>
    <script src="{{ asset('/assets/js/script.js') }}"></script>
    @include('message')
</body>

</html>