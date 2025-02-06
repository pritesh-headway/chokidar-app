@extends('layouts.page')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<style>
    .modal-full {
        max-width: 100%;
        height: 91%;
        margin: 0;
        margin-left: 12.8%;
        margin-top: 4%;
    }

    .modal-content {
        height: 100%;
        width: 100%;
        border-radius: 0;
    }

    a {
        text-decoration: none;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <h1>Add Product Data</h1>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="addDataTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product"
                    type="button" role="tab" aria-controls="product" aria-selected="true">
                    Add Product
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="category-tab" data-bs-toggle="tab" data-bs-target="#category" type="button"
                    role="tab" aria-controls="category" aria-selected="false">
                    Add Category
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="subcategory-tab" data-bs-toggle="tab" data-bs-target="#subcategory"
                    type="button" role="tab" aria-controls="subcategory" aria-selected="false">
                    Add Subcategory
                </button>
            </li>
        </ul>
        @php
        $products = \App\Models\Product::where('status', '1')->get();
        $categorys = \App\Models\Category::where('status', '1')->get();
        $taxs = \App\Models\Tax::where('status', '1')->get();
        @endphp
        <!-- Tabs Content -->
        <div class="tab-content" id="addDataTabsContent">
            <!-- Product Tab -->
            <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
                <form id="addProductForm" class="mt-4">
                    @csrf
                    <div class="alert-container">
                        <!-- Alerts will be dynamically inserted here -->
                    </div>
                    <form id="productForm" class="mt-4">
                        @csrf
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="product_ids" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>

                    <hr>
                    <br />
                    <h6>Existing Products</h6>
                    <table style="width: 100%;" id="productTable" class="table table-bordered table-striped">
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
                </form>
            </div>

            <!-- Category Tab -->
            <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="categoryForm" class="mt-4">
                    @csrf
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="product_ids" class="form-label">Product Name</label>
                        <select id="product_ids" name="product_id" class="form-controls form-select" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-controls" id="name" name="category_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>

                <hr>
                <br />
                <h6>Existing Categories</h6>
                <table style="width: 100%;" id="categoryTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- Subcategory Tab -->
            <div class="tab-pane fade" id="subcategory" role="tabpanel" aria-labelledby="subcategory-tab">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="SubcategoryForm" class="mt-4">
                    @csrf
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="product_ids" class="form-label">Select Product</label>
                        <select id="product_ids" name="product_id" class="form-controls form-select" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Select Category</label>
                        <select id="category_ids" name="category_id" class="form-controls form-select" required>
                            <option value="">Select Category</option>
                        </select>
                    </div>
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Sub Category Name</label>
                        <input type="text" class="form-controls" id="subcategory_name" name="subcategory_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <hr>
                <br />
                <h6>Existing Sub Categories</h6>
                <table style="width: 100%;" id="subcategoryTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category Name</th>
                            <th>Sub-Category Name</th>
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
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script>
    // Load DataTables for main table
    let table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('categories.index') }}", // Replace with your route for fetching categories
        columns: [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'category_name',
            name: 'category_name'
        },
        {
            data: 'created_at',
            name: 'created_at',
            render: function (data, type, row) {
                if (data) {
                    return moment(data).format('Y-m-d h:m A'); // Change format as needed
                }
                return '';
            }
        },
        {
            data: 'id',
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
    <button class="btn btn-danger btn-sm delete-button-cat" data-id="${row.id}">Delete</button>
    `;
            }
        }
        ]
    });
    // Handle form submission

    $('#categoryForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('categories.store') }}", // Replace with your store route
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                // alert('Category added successfully!');
                showAlert('success', 'Category added successfully!');
                $('#categoryForm')[0].reset();
                table.ajax.reload(); // Reload DataTable
            },
            error: function (error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
                // alert('Something went wrong!');
            }
        });
    });

    $('#product_ids').change(function () {
        var product_id = $(this).val();
        $('#product-dropdown').html('<option value="">Select Product</option>');
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');

        if (product_id) {
            $.ajax({
                url: '{{ route("get.categorys", "") }}/' + product_id,
                type: 'GET',
                success: function (data) {
                    $('#category_ids').html('<option value="">Select Category</option>');
                    $.each(data, function (id, category_name) {
                        $('#category_ids').append('<option value="' + id + '">' + category_name + '</option>');
                    });
                }
            });
        }
    });

    let table2 = $('#subcategoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('subcategories.index') }}", // Replace with your route for fetching subcategories
        columns: [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'category_name',
            name: 'category_name'
        },
        {
            data: 'subcategory_name',
            name: 'subcategory_name'
        },
        {
            data: 'created_at',
            name: 'created_at',
            render: function (data, type, row) {
                if (data) {
                    return moment(data).format('Y-m-d h:m A'); // Change format as needed
                }
                return '';
            }
        },
        {
            data: 'id',
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
    <button class="btn btn-danger btn-sm delete-button-subcat" data-id="${row.id}">Delete</button>
    `;
            }
        }
        ]
    });
    // Handle form submission

    $('#SubcategoryForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('subcategories.store') }}", // Replace with your store route
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                // alert('Sub-Category added successfully!');
                showAlert('success', 'Sub-Category added successfully!');
                // $('#SubcategoryForm')[0].reset();
                $('#subcategory_name').val('');
                table2.ajax.reload(); // Reload DataTable
            },
            error: function (error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    });

    let table3 = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.index') }}", // Replace with your route for fetching product
        columns: [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'created_at',
            name: 'created_at',
            render: function (data, type, row) {
                if (data) {
                    return moment(data).format('Y-m-d h:m A'); // Change format as needed
                }
                return '';
            }
        },
        {
            data: 'id',
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
    <button class="btn btn-danger btn-sm delete-button-product" data-id="${row.id}">Delete</button>
    `;
            }
        }
        ]
    });
    // Handle form submission

    $('#productForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('product.store') }}", // Replace with your store route
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                // alert('Product added successfully!');
                showAlert('success', 'Product added successfully!');
                $('#productForm')[0].reset();
                table3.ajax.reload(); // Reload DataTable
            },
            error: function (error) {
                console.error(error);
                // alert('Something went wrong!');
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    });

    $(document).on('click', '.delete-button-cat', function () {
        let id = $(this).data('id');

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: `categories/${id}`, // Update the route as needed
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function (response) {
                    showAlert('success', 'Record deleted successfully!');
                    table.ajax.reload();
                },
                error: function (xhr) {
                    showAlert('danger', 'Failed to delete the record. Please try again.');
                }
            });
        }
    });

    $(document).on('click', '.delete-button-subcat', function () {
        let id = $(this).data('id');

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: `subcategories/${id}`, // Update the route as needed
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function (response) {
                    showAlert('success', 'Record deleted successfully!');
                    table2.ajax.reload();
                },
                error: function (xhr) {
                    showAlert('danger', 'Failed to delete the record. Please try again.');
                }
            });
        }
    });

    $(document).on('click', '.delete-button-product', function () {
        let id = $(this).data('id');

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: `product/${id}`, // Update the route as needed
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function (response) {
                    showAlert('success', 'Record deleted successfully!');
                    table3.ajax.reload();
                },
                error: function (xhr) {
                    showAlert('danger', 'Failed to delete the record. Please try again.');
                }
            });
        }
    });

    function showAlert(type, message) {
        const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('.alert-container').html(alertHTML); // Insert alert into container
    }
</script>
</div>
@endsection