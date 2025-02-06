@extends('layouts.page')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<style>
    .modal-dialog.modal-lg {
        margin-top: 10%;
    }

    a {
        text-decoration: none;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <h1>View List</h1>

        <button id="delete-selected" style="float: inline-end;margin-bottom: 5px;width: 12%;"
            class="btn btn-danger">Delete
            Selected</button>
        <div style="margin-bottom: 10px; margin-left: 58%;">
            <select id="productFilter" class="form-control"
                style="width: 20%; display: inline-block; margin-right: 10px;">
                <option value="">Filter by Product</option>
                @if ($products)
                @foreach ($products as $pro)
                <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                @endforeach
                @endif
            </select>

            <select id="categoryFilter" class="form-control"
                style="width: 20%; display: inline-block; margin-right: 10px;">
                <option value="">Filter by Category</option>
                @if ($category)
                @foreach ($category as $cat)
                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                @endforeach
                @endif
            </select>
        </div>
        <table style="width: 100%;" id="viewTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Product Name</th>
                    <th>Category Name</th>
                    <th>Sub-Category Name</th>
                    <th>Sub Cordinates</th>
                    <th>Frame Size</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

@endsection
