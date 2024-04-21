@extends('layout.main')

@section('main-container')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>New Lead Add</h4>
                <div class="modal-body" id="ajaxModel">
                    <form id="productForm" name="productForm" class="form-horizontal">
                        <input type="hidden" name="product_id" id="product_id">
                        @csrf

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>                        
                        <div class="form-group row">
                            <label class="col-3 col-form-label">Status</label>
                            <div class="col-3">
                                <span class="switch">
                                    <label>
                                        <input type="checkbox" checked="checked" name="detail"/>                                        
                                       
                                        <span></span>
                                    </label>
                                </span>
                            </div>		
                        </div>		                        
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50">
                                <span id="name_error" class="error text-danger" style="display:none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Mobile:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                    placeholder="Enter Mobile" value="" maxlength="50">
                                <span id="name_error" class="error text-danger" style="display:none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Address:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address" value="" maxlength="50">
                                <span id="name_error" class="error text-danger" style="display:none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">City:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="city" name="city"
                                    placeholder="Enter Name" value="" maxlength="50">
                                <span id="name_error" class="error text-danger" style="display:none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Project Name:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="project_name" name="project_name"
                                    placeholder="Enter Project Name" value="" maxlength="50">
                                <span id="name_error" class="error text-danger" style="display:none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Available Size:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="a_size" name="a_size"
                                    placeholder="Enter Available Size" value="" maxlength="50">
                                <span id="name_error" class="error text-danger" style="display:none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Remarks:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="remark" name="remark"
                                    placeholder="Enter Remarks" value="" maxlength="50">
                                <span id="name_error" class="error text-danger" style="display:none"></span>
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label class="col-sm-2 control-label">Details:</label>
                            <div class="col-sm-12">
                                <textarea id="detail" name="detail" placeholder="Enter Details" class="form-control"></textarea>
                                <span id="detail_error" class="error text-danger" style="display:none"></span>
                            </div>
                        </div> --}}

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"><i
                                    class="fa fa-save"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @include('LeadAdd.show')
        </div>
    </div>
@endsection

        
        