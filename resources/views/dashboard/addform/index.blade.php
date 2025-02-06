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
    <h1>Add Data</h1>

    <div class="mb-3 text-center">
        <?php if ($products) {
            foreach ($products as $key => $value) {
        ?>
                <a href="{{ route('finaldata.add', $value->id) }}"
                    data-id='<?php echo $value->id; ?>' data-title='<?php echo $value->product_name; ?>'><button
                        class="btn btn-primary mt-6" style="width: 20%; ">
                        <?php echo $value->product_name; ?>
                    </button>&nbsp;&nbsp;
                </a>
        <?php }
        } ?>
    </div>
</div>
</div>
@php
$categorys = \App\Models\Category::select([
'categories.id',
'categories.category_name',
'categories.product_id',
'products.product_name',
'products.id as productID',
'categories.created_at'
])->leftJoin(
'products',
'products.id',
'=',
'categories.product_id'
)->where('categories.status', '1')->get();
$taxs = \App\Models\Tax::where('status', '1')->get();
@endphp
<!-- Sub Category Modal -->
<!-- <div class="modal fade" id="catFormModal" tabindex="-1" aria-labelledby="catFormModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title catFormModalLabel" id="catFormModalLabel">Products</h5>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                </div>
                <form id="catForm">
                    @csrf
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Select Category</label>
                        <select id="categorys" name="category_id" class="form-controls form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categorys as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="subcategory-container">
                    </div>
                    <input type="hidden" name="product_id" id="product_ids" value="" />
                    <div class="" id="">
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Frame Size</label>
                            <input type="text" class="form-controls numericInput Footval" id="size" name="size"
                                placeholder="Frame Size" required>
                        </div>
                    </div>
                    <div class="" id="FootvalDiv">
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Price</label>
                            <input type="text" class="form-controls numericInput Footval" id="Footval" name="Footval"
                                placeholder="Price" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" checked name="typeOption[]"
                                id="inlineRadio1" value="Foot">
                            <label class="form-check-label" for="inlineRadio1">Foot</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" name="typeOption[]"
                                id="inlineRadio2" value="Flange">
                            <label class="form-check-label" for="inlineRadio2">Flange</label>
                        </div>
                    </div>

                    <div class="mb-3 flangeShow">
                        @if ($taxs->isNotEmpty())
                        @foreach ($taxs as $key => $value)
                        @if ($value->flange != '' || $value->flange != null)
                        <input type="radio" class="btn-check form-control" placeholder="Price" name="flange"
                            id="flange{{ $value->flange }}" autocomplete="off" value="{{ $value->flange }}" checked>
                        <label class="btn btn-outline-success" for="flange{{ $value->flange }}">{{ $value->flange
                            }}</label>&nbsp;&nbsp;

                        @endif
                        @endforeach
                        @endif
                    </div>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-info">Back</button>
                    <button type="button" id="resetButton" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div> -->
<!-- Product Model END -->

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
    function showAlert(type, message) {
        const alertHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('.alert-container').html(alertHTML);
    }
    $('#catForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('addform.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Product added successfully!');
                $('#catForm')[0].reset();
            },
            error: function(error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    })
</script>
</div>
@endsection
