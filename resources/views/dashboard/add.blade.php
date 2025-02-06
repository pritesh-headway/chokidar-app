@extends('layouts.page')
@section('content')
<div class="container-fluid">
    <button type="button" onclick="goBack()" style="float: right;" class="btn btn-info">Back To Dashboard</button>
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
                            <h4 class="mb-0">Products Data</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-briefcase fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{'0'}}</h1>
                        <p class="mb-0">
                            <span class="text-dark me-8"></span>

                            <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">Add</button></span>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection