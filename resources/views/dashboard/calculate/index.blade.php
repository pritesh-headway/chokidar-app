@extends('layouts.page')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<style>
    .modal-full {
        max-width: 100%;
        height: 96%;
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
    <h1>Calculate Data</h1>

    <div class="mb-3 text-center">
        <?php if ($products) {
            foreach ($products as $key => $value) { ?>
        <a href="{{ route('calculate.show', $value->id) }}" class="mt-6" data-id='<?php echo $value->id; ?>'
            data-title='<?php echo $value->product_name; ?>'><button class="btn btn-primary mt-6" style="width: 20%; ">
                <?php echo $value->product_name; ?>
            </button>&nbsp;&nbsp;
        </a>
        <?php    }
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
<!-- Calculate Form Modal -->
<div class="modal fade" id="calFormModal" tabindex="-1" aria-labelledby="calFormModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title catFormModalLabel" id="catFormModalLabel">Products</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="alert-container">
                </div>
                <form id="calForm">
                    @csrf
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Select Category</label>
                        <select id="category_cal" name="category_id" class="form-controls form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categorys as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="subcategorycal-containercal">
                    </div>
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Frame Size</label>
                        <div class="col-sm-9">
                            <input type="text" class="frameOriginal numericInput form-control" readonly name="frame"
                                value="">
                        </div>
                    </div>
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="text" class="priceOriginal form-control" readonly name="price" value="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" checked name="typeOption_cal[]"
                                id="inlineRadio1" value="Foot">
                            <label class="form-check-label" for="inlineRadio1">Foot</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" name="typeOption_cal[]"
                                id="inlineRadio2" value="Flange">
                            <label class="form-check-label" for="inlineRadio2">Flange</label>
                        </div>
                    </div>
                    <div class="flangePerShow flangeShow">
                        @if ($taxs->isNotEmpty())
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Flange ( <span id="bracketFlangeVal"></span> )</label>
                            <div class=" col-sm-9">
                                <span class="calFlangePrice"></span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="">
                        <div class="mb-3 d-flex justify-content-between">
                            @if ($taxs->isNotEmpty())
                            <label for="name" class="form-label">Additional Tax</label>
                            <div class="col-sm-9">
                                @foreach ($taxs as $key => $value)
                                @if ($value->tax != '' || $value->tax != null)
                                <?php            $no = $key + 1; ?>

                                <input type="radio" class="btn-check form-control flangePerc" placeholder="Price"
                                    name="flange_cal" id="flanges{{ $value->tax }}" autocomplete="off"
                                    value="{{ $value->tax }}">
                                <label class="btn btn-outline-success" for="flanges{{ $value->tax }}">{{ $value->tax
                                    }}</label>&nbsp;&nbsp;
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">GST</label>
                        <div class="col-sm-9">
                            @if ($taxs->isNotEmpty())
                            @foreach ($taxs as $key => $value)
                            <?php        $gstVal = $value->gst; ?>
                            @endforeach
                            @endif
                            <input type="text" class="taxOriginal numericInput form-control" readonly name="tax"
                                value="{{ $gstVal }}">
                        </div>
                    </div>
                    <div class="mb-33 finalDiscount" style="display: none !important">
                        <label for="name" class="form-label">Discount %</label>
                        <input type="text" class="form-controls numericInput" id="finaldiscount" name="finaldiscount"
                            required>
                    </div>
                    <div class="mb-3">
                        <div id="calculateData"></div>
                        <div id="calculateDataWithoutTax"></div>
                        <div id="calculateDataFlange"></div>
                        <div id="calculateDataFlangeWithoutTax"></div>
                        <div id="calculateDataFoot"></div>
                        <div id="calculateDataFootWithouTax"></div>
                    </div>
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal" aria-label="Close">Back</button>
                    <button type="button" id="calculateButton" class="btn btn-secondary">Calculate</button>
                    <button type="button" class="btn btn-primary">Download</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Calculate Form Model END -->

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
        $('.alert-container').html(alertHTML); // Insert alert into container
    }
    $(".flangeShow").css('display', 'none');
    $(".flangePerShow").css('display', 'none');
    $(".FlangevalDiv").css('display', 'none');
    $("#calculateButton").click(function () {
        $(".frameOriginal").val();
        let originalPrice = parseFloat($(".priceOriginal").val());
        let taxOriginal = parseFloat($(".taxOriginal").val());
        let selectedValues = $('input[name="typeOption_cal[]"]:checked').map(function () {
            return $(this).val(); // Return the value of each checked checkbox
        }).get();
        let price;
        let flangeprice;
        if (selectedValues.length === 1 && selectedValues[0] === 'Flange') {
            flangeprice = parseFloat($(".calFlangePrice").html());
            price = flangeprice;
        } else if (selectedValues.length === 1 && selectedValues[0] === 'Foot') {
            price = originalPrice;
        } else if (selectedValues.includes('Flange') && selectedValues.includes('Foot')) {
            flangeprice = parseFloat($(".calFlangePrice").html());
            footprice = originalPrice;
        } else {
            price = originalPrice;
        }
        discountRate = parseFloat($("#finaldiscount").val());
        AdditionalTaxs = parseFloat($('input[name="flange_cal"]:checked').val());

        let discountPrice = (price * (discountRate / 100));
        let AfterDiscount = (price - discountPrice);
        AdditionalTaxes = AfterDiscount * (AdditionalTaxs / 100);
        let taxAmount = AfterDiscount + AdditionalTaxes;
        taxOriginal = taxAmount * (taxOriginal / 100);
        let extraTaxAmount = taxAmount + taxOriginal;
        let FinalPrice = Math.round(parseFloat(extraTaxAmount.toFixed(2)));
        let FinalPriceWithoutTax = Math.round(parseFloat(taxAmount.toFixed(2)));

        if (selectedValues.includes('Flange') && selectedValues.includes('Foot')) {
            taxOriginal = parseFloat($(".taxOriginal").val());

            let discountPriceflange = (flangeprice * (discountRate / 100));
            let AfterDiscountFlange = (flangeprice - discountPriceflange);
            AdditionalTaxFlane = AfterDiscountFlange * (AdditionalTaxs / 100);
            let taxAmountFlange = AfterDiscountFlange + AdditionalTaxFlane;
            taxOriginalflange = taxAmountFlange * (taxOriginal / 100);
            let extraTaxAmountFlange = taxAmountFlange + taxOriginalflange;
            let FinalPriceFlange = Math.round(parseFloat(extraTaxAmountFlange.toFixed(2)));
            let FinalPriceFlangeWithoutTax = Math.round(parseFloat(taxAmountFlange.toFixed(2)));
            console.log('flangeprice', flangeprice);
            console.log('discountPriceflange', discountPriceflange);
            console.log('AdditionalTaxFlane', AdditionalTaxFlane);

            let discountPricefoot = (footprice * (discountRate / 100));
            let AfterDiscountFoot = (footprice - discountPricefoot);
            AdditionalTaxFoot = AfterDiscountFoot * (AdditionalTaxs / 100);
            let taxAmountFoot = AfterDiscountFoot + AdditionalTaxFoot;
            taxOriginalFoot = taxAmountFoot * (taxOriginal / 100);
            let extraTaxAmountFoot = taxAmountFoot + taxOriginalFoot;
            let FinalPriceFoot = Math.round(parseFloat(extraTaxAmountFoot.toFixed(2)));
            let FinalPriceFootWithoutTax = Math.round(parseFloat(taxAmountFoot.toFixed(2)));

            $("#calculateDataFlange").html('Final Amount Flange With Tax : <b>' + FinalPriceFlange.toFixed(2) + '</b>');

            $("#calculateDataFlangeWithoutTax").html('Final Amount Flange Without Tax : <b>' + FinalPriceFlangeWithoutTax.toFixed(2) + '</b>');

            $("#calculateDataFoot").html('Final Amount Foot With Tax : <b>' + FinalPriceFoot.toFixed(2) + '</b>');

            $("#calculateDataFootWithouTax").html('Final Amount Foot Without Tax : <b>' + FinalPriceFootWithoutTax.toFixed(2) + '</b>');

            $("#calculateData").hide();
            $("#calculateDataWithoutTax").hide();
        }
        $("#calculateData").html('Final Amount With Tax : <b>' + FinalPrice.toFixed(2));
        $("#calculateDataWithoutTax").html('Final Amount Without Tax : <b>' + FinalPriceWithoutTax.toFixed(2));
    });

    $('#category_cal').change(function () {
        var category_id = $(this).val();
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');
        let productId = window.product_id;
        let url = "{{ route('get.subcategory', [':categoryId', ':productId']) }}";
        url = url.replace(':categoryId', category_id).replace(':productId', productId);
        if (category_id) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $("#subcategorycal-containercal").html('');
                    if (data) {
                        $.each(data, function (id, subcategory_val) {
                            let options = '';
                            if (subcategory_val.options && Array.isArray(subcategory_val.options)) {
                                $.each(subcategory_val.options, function (index, option) {
                                    options += `<option value="${option.value}">${option.label}</option>`;
                                });
                            }

                            let newSubcategory = `
                            <div class="mb-33 d-flex justify-content-between">
                                <label for="subname" class="form-label">${subcategory_val.name}</label>
                                <div class="col-sm-9">
                                    <select name="subCat" data-idval="${subcategory_val.id}"
                                        onchange="getSabCatval(this, ${subcategory_val.cat_id});" class="form-select form-controlss subCat">
                                        ${options}
                                    </select>
                                </div>
                            </div>`;
                            $('#subcategorycal-containercal').append(newSubcategory);

                        });
                        $('.priceOriginal').val(data[0].footval);
                        if (data[0].flange_percentage) {


                            $(".flangePerShow").css('display', 'block');

                            $(".flangeShow").css('display', 'block');

                            $('input[name="flange"][value="' + data[0].flange_percentage + '"]').prop('checked', true);
                        } else {
                            $(".flangePerShow").css('display', 'none');

                            $(".flangeShow").css('display', 'none');
                        }

                        var price = parseFloat(data[0].footval); // Base price
                        var percentage = parseFloat(data[0].flange_percentage);

                        var finalPrice = price + (price * percentage / 100);
                        let typeOptionCheckBoc = data[0].typeOption.split(', ');
                        $('input[name="typeOption_cal[]"]').prop('checked', false);
                        typeOptionCheckBoc.forEach(function (optionCheckbox) {
                            $('input[name="typeOption_cal[]"][value="' + optionCheckbox + '"]').prop('checked', true);
                        });

                        $(".calFlangePrice").text(finalPrice);
                        $("#bracketFlangeVal").html(percentage + '%');
                        $(".finalDiscount").removeAttr('style');
                        $(".frameOriginal").val(data[0].size);
                    } else {
                        $('#subcategorycal-containercal').append(newSubcategory);
                    }
                }
            });
        } else {
            $("#subcategorycal-containercal").html('');
        }
    });
    $('.productClick').on('click', function (e) {
        e.preventDefault();
        $('#product-dropdown').html('<option value="">Select Product</option>');
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');
        var product_id = $(this).data('id');
        window.product_id = product_id;
        var product_title = $(this).data('title');
        $(".catFormModalLabel").html(product_title);
        $("#product_ids").val(product_id);
        if (product_id) {
            $.ajax({
                url: '{{ route("get.categorys", "") }}/' + product_id,
                type: 'GET',
                success: function (data) {
                    $('#categorys').html('<option value="">Select Category</option>');
                    $('#category_cal').html('<option value="">Select Category</option>');
                    $.each(data, function (id, category_name) {

                        $('#categorys').append('<option value="' + id + '">' + category_name + '</option>');
                        $('#category_cal').append('<option value="' + id + '">' + category_name + '</option>');
                    });
                },
                error: function (error) {
                    console.error(error);
                    showAlert('danger', 'Something went wrong. Please try again.');
                }
            });
        }
    });
</script>
</div>
@endsection