@extends('layouts.page')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<style>
    .textWidth {
        width: 94%;
        float: right;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <h1>{{ $products[0]['product_name'] }}</h1>
        @php
        $categorys = \App\Models\Category::select(['categories.id', 'categories.category_name', 'categories.product_id',
        'products.product_name', 'products.id as productID', 'categories.created_at'])->leftJoin('products', 'products.id', '=',
        'categories.product_id')->where('categories.status','1')->get();
        $taxs = \App\Models\Tax::where('status','1')->get();
        @endphp
        <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
            <div class="alert-container">
                <!-- Alerts will be dynamically inserted here -->
            </div>
            <form id="catForm">
                @csrf
                <div class="mb-33 d-flex justify-content-between">
                    <label for="name" class="form-label">Select Category</label>
                    <select id="categorys" name="category_id" class="form-controls form-select" required>
                        <!-- <option value="">Select Category</option> -->
                        {!! $options !!}
                        <!-- @foreach ($categorys as $category)
                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                        @endforeach -->
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
                <button type="button" onclick="goBack()" class="btn btn-info">Back</button>
                <button type="button" id="resetButton" class="btn btn-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
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

    $('#categorys').change(function() {
        var category_id = $(this).val();
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');

        if (category_id) {
            $.ajax({
                url: '{{ route("get.subcategorys", "") }}/' + category_id,
                type: 'GET',
                success: function(data) {
                    console.log(' - data - ', data);
                    $("#subcategory-container").html('');
                    var newSubcategory = ``;
                    if (data) {
                        $.each(data, function(id, category_name) {
                            newSubcategory = `<div class="mb-3 row">
                                <input type="hidden" class="form-control" id="subname" name="subcategory_id[]" value='` + id + `'>
                                    <label for="subname" class="col-sm-3 col-form-label "><b>` + category_name + `</b></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control textWidth" id="subname" name="subcategory_val[]" required>
                                    </div>
                                </div>`;
                            $('#subcategory-container').append(newSubcategory);
                        });
                    } else {
                        $('#subcategory-container').append(newSubcategory);
                    }
                }
            });
        }
    });

    $(".flangeShow").css('display', 'none');
    $(".flangePerShow").css('display', 'none');
    $(".FlangevalDiv").css('display', 'none');

    $('.toggleRadio').on('change', function() {

        if ($(this).is(':checked') && $(this).val() === 'Flange') {
            $(".flangeShow").css('display', 'block');
            $(".FlangevalDiv").css('display', 'block');
            $(".flangeShow").css('margin-left', '16px');
            $(".Footval").removeAttr('required');
            $(".Flangeval").attr('required', true);
        } else {
            if ($(this).val() === 'Flange') {
                $(".flangeShow").css('display', 'none');
                $(".FlangevalDiv").css('display', 'none');
                $(".Footval").attr('required', true);
                $(".Flangeval").removeAttr('required');
            }
        }
    });

    function goBack() {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = '/';
        }
    }
</script>
</div>
@endsection
