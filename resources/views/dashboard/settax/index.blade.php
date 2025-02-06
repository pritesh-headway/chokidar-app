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
            <h1>Set Tax Data</h1>
            @php
                $products = \App\Models\Product::where('status', '1')->get();
                $categorys = \App\Models\Category::where('status', '1')->get();
                $taxs = \App\Models\Tax::where('status', '1')->get();
            @endphp
            <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="taxesForm">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">GST</label>
                        <input type="text" class="form-control" value="<?php echo isset($taxs[0]->gst) ? $taxs[0]->gst : ''; ?>" id="gst" name="gst"
                            required>
                    </div>
                    @if ($taxs->isNotEmpty())
                        @foreach ($taxs as $key => $value)
                            <div class="mb-3">
                                @if ($loop->first)
                                    <label for="name" class="form-label">Additional Tax</label>
                                @endif
                                @if ($value->tax != '' || $value->tax != null)
                                    <div id="tax-container">
                                        <div class="mb-3 d-flex align-items-center">
                                            <input type="text" class="form-control" value="<?php echo $value->tax; ?>"
                                                name="tax[]" required>

                                            @if ($loop->first)
                                                <button type="button" class="btn btn-success add-tax ms-2">Add</button>
                                            @else
                                                <button type="button"
                                                    class="btn btn-danger remove-tax ms-2">Remove</button>
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
                                    <button type="button" class="btn btn-success add-tax ms-2">Add</button>
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
                                @if ($value->flange != '' || $value->flange != null)
                                    <div id="flange-container">
                                        <div class="mb-3 d-flex align-items-center">
                                            <input type="text" class="form-control" value="<?php echo $value->flange; ?>"
                                                name="flange[]" required>

                                            @if ($loop->first)
                                                <button type="button" class="btn btn-success add-flange ms-2">Add</button>
                                            @else
                                                <button type="button"
                                                    class="btn btn-danger remove-flange ms-2">Remove</button>
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
                                    <button type="button" class="btn btn-success add-flange ms-2">Add</button>
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

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <script>
        $('#taxesForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('settings.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    showAlert('success', 'Taxes added successfully!');

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
            <button type="button" class="btn btn-danger remove-tax ms-2">Delete</button>
        </div>
        `;
            $('#additional-taxes').append(newTaxField);
        });
        $(document).on('click', '.remove-tax', function() {
            $(this).closest('.mb-3').remove();
        });

        $(document).on('click', '.add-flange', function() {
            const newTaxField = `<div class="mb-3 d-flex align-items-center">
        <input type="text" class="form-control" name="flange[]" required>
        <button type="button" class="btn btn-danger remove-flange ms-2">Delete</button>
    </div>`;
            $('#additional-flange').append(newTaxField);
        });
        $(document).on('click', '.remove-flange', function() {
            $(this).closest('.mb-3').remove();
        });

        function showAlert(type, message) {
            const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
            $('.alert-container').html(alertHTML);
        }
    </script>
    </div>
@endsection
