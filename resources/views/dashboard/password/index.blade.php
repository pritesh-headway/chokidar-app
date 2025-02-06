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
        <h1>Set Password</h1>
        @php
        $products = \App\Models\Product::where('status', '1')->get();
        $categorys = \App\Models\Category::where('status', '1')->get();
        $taxs = \App\Models\Tax::where('status', '1')->get();
        @endphp
        <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
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

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script>
    $('#passwordForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('settings.update', '2') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                showAlert('success', 'Password changed successfully!');
            },
            error: function (error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
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
