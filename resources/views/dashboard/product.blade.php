@extends('layouts.page')
@section('content')
<div class="container-fluid">

    <div class="col-md-8 ">
        <h3>Add Data:</h3>
        <br />
        <form class="form-horizontal" action="/action_page.php" id="myForm">
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Product Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="product" id="product" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Select Category:</label>
                <div class="col-sm-10">
                    <select class="form-control" name="category">
                        <option value="Electronics">Electronics</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Sub-Category Name:</label>
                <div class="col-sm-10">
                    <select class="form-control" name="subcategory">
                        <option value="Mobile">Mobile</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Sub-Ordinate:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="subordinate" name="subordinate" required>
                </div>
            </div>
            {{-- <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Discount (%):</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="discount" name="discount" required>
                </div>
            </div> --}}
            <div class="form-group">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-info" onclick="resetForm()">Reset</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                    <button type="button" onclick="goBack()" class="btn btn-secondary"><i class="fa fa-arrow-left"
                            aria-hidden="true"></i>
                        Back</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection