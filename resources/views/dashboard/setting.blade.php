@extends('layouts.page')
@section('content')
<style type="text/css">

</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid">
    <button type="button" onclick="goBack()" style="float: right;" class="btn btn-info">Back To Dashboard</button>
    <br /><br />
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
                            <h4 class="mb-0">Product Data</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-briefcase fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{$productCount}}</h1>
                        <p class="mb-0">
                            <span class="text-dark me-8"></span>

                            <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#productModal">Add</button></span>

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
                            <h4 class="mb-0">Category Data</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{$categoryCount}}</h1>
                        <p class="mb-0">
                            <span class="text-dark me-8"></span>

                            <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#categoryModal">Add</button></span>
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
                            <h4 class="mb-0">Sub-Category Data</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{$subcategoryCount}}</h1>
                        <p class="mb-0">

                            <span class="text-dark me-8"></span>

                            <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#subcategoryModal">Add</button></span>
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
                            <h4 class="mb-0">Set Taxes</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">&nbsp;</h1>
                        <p class="mb-0">

                            <span class="text-dark me-8"></span>

                            <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#taxesModal">Add</button></span>
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
                            <h4 class="mb-0">Set Password</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">&nbsp;</h1>
                        <p class="mb-0">

                            <span class="text-dark me-8"></span>

                            <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#passwordModal">Add</button></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@php
$products = \App\Models\Product::where('status','1')->get();
$categorys = \App\Models\Category::where('status','1')->get();
$taxs = \App\Models\Tax::where('status','1')->get();
@endphp
<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="categoryForm">
                    @csrf
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Select Product</label>
                        <select id="product" name="product_id" class="form-controls form-select" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" class="form-control" id="name" name="category_name" required> -->
                    </div>
                    <div class="mb-33">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-controls" id="name" name="category_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
        </div>
    </div>
</div>
<!-- Category Model END -->

<!-- Sub Category Modal -->
<div class="modal fade" id="subcategoryModal" tabindex="-1" aria-labelledby="subcategoryModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add Sub Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="SubcategoryForm">
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
<!-- Sub Category Model END -->

<!-- Sub Category Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="productForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="product_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
            </div>
        </div>
    </div>
</div>
<!-- Product Model END -->

<!-- Taxes Modal -->
<div class="modal fade" id="taxesModal" tabindex="-1" aria-labelledby="taxesModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taxesModalLabel">Tax Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="taxesForm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">GST</label>
                        <input type="text" class="form-control"
                            value="<?php echo isset($taxs[0]->gst) ? $taxs[0]->gst : '' ?>" id="gst" name="gst"
                            required>
                    </div>
                    @if ($taxs->isNotEmpty())
                    @foreach ($taxs as $key => $value)
                    <div class="mb-3">
                        @if ($loop->first)
                        <label for="name" class="form-label">Additional Tax</label>
                        @endif
                        @if ($value->tax != '' || $value->tax !=null)
                        <div id="tax-container">
                            <div class="mb-3 d-flex align-items-center">
                                <input type="text" class="form-control" value="<?php echo $value->tax ?>" name="tax[]"
                                    required>

                                @if ($loop->first)
                                <button type="button" class="btn btn-success add-tax ms-2">+</button>
                                @else
                                <button type="button" class="btn btn-danger remove-tax ms-2">-</button>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    @else
                    <div class="mb-3">
                        <label for="name" class="form-label">Additional Tax</label>
                        <div id="tax-container">
                            <div class="mb-3 d-flex align-items-center">
                                <input type="text" class="form-control" name="tax[]" required>
                                <button type="button" class="btn btn-success add-tax ms-2">+</button>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div id="additional-taxes"></div>
                    @if ($taxs->isNotEmpty())
                    @foreach ($taxs as $key => $value)
                    <div class="mb-3">
                        @if ($loop->first)
                        <label for="name" class="form-label">Flange</label>
                        @endif
                        @if ($value->flange != '' || $value->flange !=null)
                        <div id="flange-container">
                            <div class="mb-3 d-flex align-items-center">
                                <input type="text" class="form-control" value="<?php echo $value->flange ?>"
                                    name="flange[]" required>

                                @if ($loop->first)
                                <button type="button" class="btn btn-success add-flange ms-2">+</button>
                                @else
                                <button type="button" class="btn btn-danger remove-flange ms-2">-</button>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                    @else
                    <div class="mb-3">
                        <label for="name" class="form-label">Flange %</label>
                        <div id="flange-container">
                            <div class="mb-3 d-flex align-items-center">
                                <input type="text" class="form-control" name="flange[]" required>
                                <button type="button" class="btn btn-success add-flange ms-2">+</button>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div id="additional-flange"></div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Taxes Model END -->

<!-- Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalLabel">Tax Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="passwordForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Change Password</label>
                        <input type="text" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Password Model END -->

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
                render: function(data, type, row) {
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
                render: function(data, type, row) {
                    return `
                            <button class="btn btn-danger btn-sm delete-button-cat" data-id="${row.id}">Delete</button>
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
                // alert('Category added successfully!');
                showAlert('success', 'Category added successfully!');
                $('#categoryForm')[0].reset();
                table.ajax.reload(); // Reload DataTable
            },
            error: function(error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
                // alert('Something went wrong!');
            }
        });
    });

    $('#product_ids').change(function() {
        var product_id = $(this).val();
        $('#product-dropdown').html('<option value="">Select Product</option>');
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');

        if (product_id) {
            $.ajax({
                url: '{{ route("get.categorys", "") }}/' + product_id,
                type: 'GET',
                success: function(data) {
                    $('#category_ids').html('<option value="">Select Category</option>');
                    $.each(data, function(id, category_name) {
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
                render: function(data, type, row) {
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
                render: function(data, type, row) {
                    return `
                            <button class="btn btn-danger btn-sm delete-button-subcat" data-id="${row.id}">Delete</button>
                        `;
                }
            }
        ]
    });
    // Handle form submission

    $('#SubcategoryForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('subcategories.store') }}", // Replace with your store route
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                // alert('Sub-Category added successfully!');
                showAlert('success', 'Sub-Category added successfully!');
                // $('#SubcategoryForm')[0].reset();
                $('#subcategory_name').val('');
                table2.ajax.reload(); // Reload DataTable
            },
            error: function(error) {
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
                render: function(data, type, row) {
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
                render: function(data, type, row) {
                    return `
                            <button class="btn btn-danger btn-sm delete-button-product" data-id="${row.id}">Delete</button>
                        `;
                }
            }
        ]
    });
    // Handle form submission

    $('#productForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('product.store') }}", // Replace with your store route
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                // alert('Product added successfully!');
                showAlert('success', 'Product added successfully!');
                $('#productForm')[0].reset();
                table3.ajax.reload(); // Reload DataTable
            },
            error: function(error) {
                console.error(error);
                // alert('Something went wrong!');
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    });

    $('#taxesForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('settings.store') }}", // Replace with your store route
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Taxes added successfully!');
                // location.reload();
            },
            error: function(error) {
                console.error(error);
                // alert('Something went wrong!');
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    });

    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('settings.update', '2') }}", // Replace with your store route
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Password changed successfully!');
            },
            error: function(error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    });

    $(document).on('click', '.add-tax', function() {
        const newTaxField = `
        <div class="mb-3 d-flex align-items-center">
            <input type="text" class="form-control" name="tax[]" required>
            <button type="button" class="btn btn-danger remove-tax ms-2">-</button>
        </div>
        `;
        $('#additional-taxes').append(newTaxField);
    });

    // Handler for removing a text box
    $(document).on('click', '.remove-tax', function() {
        $(this).closest('.mb-3').remove();
    });

    $(document).on('click', '.add-flange', function() {
        const newTaxField = `<div class="mb-3 d-flex align-items-center">
            <input type="text" class="form-control" name="flange[]" required>
            <button type="button" class="btn btn-danger remove-flange ms-2">-</button>
        </div>`;
        $('#additional-flange').append(newTaxField);
    });

    // Handler for removing a text box
    $(document).on('click', '.remove-flange', function() {
        $(this).closest('.mb-3').remove();
    });

    function showAlert(type, message) {
        const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('.alert-container').html(alertHTML); // Insert alert into container
    }

    $(document).on('click', '.btn-close', function() {
        location.reload(); // Reload the page
    });

    $(document).on('click', '.delete-button-cat', function() {
        let id = $(this).data('id');

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: `categories/${id}`, // Update the route as needed
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    showAlert('success', 'Record deleted successfully!');
                    table.ajax.reload();
                },
                error: function(xhr) {
                    showAlert('danger', 'Failed to delete the record. Please try again.');
                }
            });
        }
    });

    $(document).on('click', '.delete-button-subcat', function() {
        let id = $(this).data('id');

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: `subcategories/${id}`, // Update the route as needed
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    showAlert('success', 'Record deleted successfully!');
                    table2.ajax.reload();
                },
                error: function(xhr) {
                    showAlert('danger', 'Failed to delete the record. Please try again.');
                }
            });
        }
    });

    $(document).on('click', '.delete-button-product', function() {
        let id = $(this).data('id');

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: `product/${id}`, // Update the route as needed
                type: 'DELETE',
                data: {
                 _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    showAlert('success', 'Record deleted successfully!');
                    table3.ajax.reload();
                },
                    error: function(xhr) {
                    showAlert('danger', 'Failed to delete the record. Please try again.');
                }
            });
        }
    });
</script>
@endsection