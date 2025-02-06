@extends('layouts.page')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<div class="container-fluid">
    <h1>Categories</h1>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">Add Category</button>

    <table id="categoriesTable" class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="categoryForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="category_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <hr>
                <h6>Existing Categories</h6>
                <table id="categoryTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Load DataTables for main table
        var table = $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('categories.list') }}", // Replace with your route for fetching categories
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'id',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-warning btn-sm">Edit</button>
                            <button class="btn btn-danger btn-sm">Delete</button>
                        `;
                    }
                }
            ]
        });



        // Handle form submission
        $('#categoryForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('categories.store') }}", // Replace with your store route
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert('Category added successfully!');
                    $('#categoryForm')[0].reset();
                    table.ajax.reload(); // Reload DataTable
                },
                error: function(error) {
                    console.error(error);
                    alert('Something went wrong!');
                }
            });
        });
    });
</script>
</div>
@endsection