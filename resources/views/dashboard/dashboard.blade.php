@extends('layouts.page')
@section('content')
    @if (session()->has('response'))
        @if (session('response')['status'] === 200)
            <p class="text-success"> {{ session('response')['message'] }}</p>
        @else
            <p class="text-danger"> {{ session('response')['message'] }}</p>
        @endif
    @endif
    <!-- Begin Page Content -->
    <style>
        a.productClick.mt-6 {
            text-decoration: none;
        }

        .col-sm-9 {
            width: 71%;
            margin-left: 4%;
        }

        @media (min-width: 576px) {
            .col-sm-9 {
                width: 71% !important;
                margin-left: 4% !important;
            }
        }
    </style>
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center
                mb-3">
                            <div>
                                <h4 class="mb-0">Calculate Data</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                                <i class="bi bi-briefcase fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold">0</h1>
                            <p class="mb-0">
                                <span class="text-dark me-2"><button class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#calculateModal">Details</button></span>
                                <span class="text-dark me-8"></span>

                                {{-- <span class="text-dark me-2"><button class="btn btn-primary">Details</button></span>
                            --}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center
                mb-3">
                            <div>
                                <h4 class="mb-0">View Data</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                                <i class="bi bi-list-task fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold">0</h1>
                            <p class="mb-0">
                                {{-- <span class="text-dark me-2"><button class="btn btn-info">Details</button></span> --}}
                                <span class="text-dark me-8"></span>

                                <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#viewModal">Details</button></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center
                mb-3">
                            <div>
                                <h4 class="mb-0">Add Data</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold">0</h1>
                            <p class="mb-0">

                                <span class="text-dark me-8"></span>

                                <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addFormModal">Add</button></span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card ">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- heading -->
                        <div class="d-flex justify-content-between align-items-center
                mb-3">
                            <div>
                                <h4 class="mb-0">Settings</h4>
                            </div>
                            <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                                <i class="bi bi-bullseye fs-4"></i>
                            </div>
                        </div>
                        <!-- project number -->
                        <div>
                            <h1 class="fw-bold">0</h1>
                            <p class="mb-0">
                                <span class="text-dark me-12"></span>

                                <span class="text-dark me-2"><a href="#"><button class="btn btn-primary">Go To Setting
                                            Screens</button>
                                    </a></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
@endsection
