      
@extends('layout.main')

@section('main-container')
      
<div class="container">
    <div class="card mt-5">
        <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Laravel 11 Ajax CRUD Example - ItSolutionStuff.com</h2>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewLead"> <i class="fa fa-plus"></i> Create New Lead</a>
            </div>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="60px">No</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
</div>
     
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="product_id" id="product_id">
                   @csrf

                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Details:</label>
                        <div class="col-sm-12">
                            <textarea id="detail" name="detail" placeholder="Enter Details" class="form-control"></textarea>
                        </div>
                    </div>
        
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"><i class="fa fa-save"></i> Submit
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"><i class="fa-regular fa-eye"></i> Show Lead</h4>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span class="show-name"></span></p>
                <p><strong>Detail:</strong> <span class="show-detail"></span></p>
            </div>
        </div>
    </div>
</div>
@endsection
      
@section('scripts')
    
<script type="text/javascript">
  $(function () {

    /*------------------------------------------
     --------------------------------------------
     Pass Header Token
     --------------------------------------------
     --------------------------------------------*/ 
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
      
    /*------------------------------------------
    --------------------------------------------
    Render DataTable
    --------------------------------------------
    --------------------------------------------*/
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('lead.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'detail', name: 'detail'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/
    $('#createNewLead').click(function () {
        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("<i class='fa fa-plus'></i> Create New Lead");
        $('#ajaxModel').modal('show');
    });

    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.showLead', function () {
      var product_id = $(this).data('id');
      $.get("{{ route('lead.index') }}" +'/' + product_id, function (data) {
          $('#showModel').modal('show');
          $('.show-name').text(data.name);
          $('.show-detail').text(data.detail);
      })
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.editLead', function () {
      var product_id = $(this).data('id');
      $.get("{{ route('lead.index') }}" +'/' + product_id +'/edit', function (data) {
          $('#modelHeading').html("<i class='fa-regular fa-pen-to-square'></i> Edit Lead");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#product_id').val(data.id);
          $('#name').val(data.name);
          $('#detail').val(data.detail);
      })
    });
      
    /*------------------------------------------
    --------------------------------------------
    Create Lead Code
    --------------------------------------------
    --------------------------------------------*/
    $('#productForm').submit(function(e) {
        e.preventDefault();
 
        let formData = new FormData(this);
        $('#saveBtn').html('Sending...');
  
        $.ajax({
                type:'POST',
                url: "{{ route('lead.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                      $('#saveBtn').html('Submit');
                      $('#productForm').trigger("reset");
                      $('#ajaxModel').modal('hide');
                      table.draw();
                },
                error: function(response){
                    $('#saveBtn').html('Submit');
                    $('#productForm').find(".print-error-msg").find("ul").html('');
                    $('#productForm').find(".print-error-msg").css('display','block');
                    $.each( response.responseJSON.errors, function( key, value ) {
                        $('#productForm').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });
                }
           });
      
    });
      
    /*------------------------------------------
    --------------------------------------------
    Delete Lead Code
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.deleteLead', function () {
     
        var product_id = $(this).data("id");
        confirm("Are You sure want to delete?");
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('lead.store') }}"+'/'+product_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
       
  });
</script>
@endsection
