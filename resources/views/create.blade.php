@extends('layout.main')

@section('main-container')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="modal-body" id="ajaxModel">
                    <form id="productForm" name="productForm" class="form-horizontal">
                        <input type="hidden" name="product_id" id="product_id">
                        @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Details:</label>
                            <div class="col-sm-12">
                                <textarea id="detail" name="detail" placeholder="Enter Details" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"><i
                                    class="fa fa-save"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @include('edit')
        </div>
    </div>
@endsection
