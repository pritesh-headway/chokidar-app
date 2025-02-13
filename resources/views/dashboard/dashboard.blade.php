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
    <div class="container-fluid d-flex justify-content-center align-items-center">
        <div class="text-center p-4 bg-light rounded shadow">
            @php
                $quote = Illuminate\Foundation\Inspiring::quote();

                // Convert Symfony console formatting to HTML
                $quote = str_replace(['<options=bold>', '</>'], ['<strong>', '</strong>'], $quote);
                $quote = str_replace(['<fg=gray>', '</>'], ['<span style="color: gray;">', '</span>'], $quote);
            @endphp

            <blockquote class="blockquote">
                {!! $quote !!}
            </blockquote>
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
