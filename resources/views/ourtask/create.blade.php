@extends('layout.main')

@section('main-container')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Craete Personal Task</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                     <form id="ourtaskForm" name="ourtaskForm" class="form-horizontal">
                        <input type="hidden" name="ot_id" id="ot_id">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Task Name</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" class="form-control" placeholder="Enter Task "
                                            name="ourtask" id="ourtask"/>
                                    </div>
                                    <span id="ourtask_error" class="error text-danger" style="display:none"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Remark</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <textarea class="form-control" placeholder="Enter Remark" name="ourremark" id="ourremark"></textarea>
                                    </div>
                                    <span id="ourremark_error" class="error text-danger" style="display:none"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">Select Date and time</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <div class="input-group date">
                                        <input type="datetime-local" class="form-control" name="ourdate" id="ourdate"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o glyphicon-th"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <span id="ourdate_error" class="error text-danger" style="display:none"></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-9 ml-lg-auto">                                    
                                    <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"><i
                                            class="fa fa-save"></i> Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
            @include('ourtask.show')
        </div>
    </div>
@endsection
