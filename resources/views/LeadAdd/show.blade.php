@extends('layout.main')

@section('main-container') 
 {{-- <div class="col-md-6"> --}}
     <div class="card mt-5">
         <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Manage Lead</h2>
         <div class="card-body">
             <table class="table table-bordered data-table">
                 <thead>
                     <tr>
                         <th width="60px">No</th>
                         <th>Lead Date</th>
                         <th>Update At</th>
                         <th>Customer Name</th>
                         <th>Mobile</th>
                         <th>address</th>
                         <th>city</th>
                         <th>Project Name</th>
                         <th>Size</th>
                         <th>Remark</th>
                         <th>Status</th>
                         <th width="280px">Action</th>
                     </tr>
                 </thead>
                 <tbody>
                 </tbody>
             </table>
         </div>
     </div>
 {{-- </div> --}}
@endsection
   @section('scripts')
          <script type="text/javascript">
              $(function() {

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
                    ajax: "{{ route('leadadd.index') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { 
                            data: 'created_at', // Access the available size through the nested relationship
                            name: 'created_at', // Use dot notation to access nested relationship
                        },
                        { 
                            data: 'updated_at', // Access the available size through the nested relationship
                            name: 'updated_at', // Use dot notation to access nested relationship
                        },
                        { data: 'la_customerNname', name: 'la_customerNname' },
                        { data: 'la_mobile', name: 'la_mobile' },
                        { data: 'la_address', name: 'la_address' },
                        { data: 'la_city', name: 'la_city' },
                        // Include project name
                        { 
                            data: 'lpn_name', // Access the project name through the nested relationship
                            name: 'lpn_name', // Use dot notation to access nested relationship
                        },
                        // Include available size
                        { 
                            data: 'las_name', // Access the available size through the nested relationship
                            name: 'las_name', // Use dot notation to access nested relationship
                        },
                        { 
                            data: 'la_remark', // Access the available size through the nested relationship
                            name: 'la_remark', // Use dot notation to access nested relationship
                        },                    
                        { data: 'la_status', name: 'la_status' },
                        { 
                            data: 'action',
                            name: 'action', 
                            orderable: false,
                            searchable: false
                        },
                    ]
                });  


                    $(document).on('change', '.status-toggle', function() {
                        var id = $(this).data('id');
                        var status = $(this).is(':checked') ? 1 : 0;

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('leadadd.updateStatus') }}",
                            data: { id: id, status: status },
                            success: function(response) {
                                // Handle success response if needed
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });

                  /*------------------------------------------
                  --------------------------------------------
                  Click to Edit Button
                  --------------------------------------------
                  --------------------------------------------*/              

                // $('body').on('click', '.editLead', function() {
                //     var product_id = $(this).data('id');                      
                //     $.get("{{ route('leadadd.index') }}" + '/' + product_id + '/edit', function(data) {
                //         $('#modelHeading').html("<i class='fa-regular fa-pen-to-square'></i> Edit Lead");
                //         $('#saveBtn').val("edit-lead");
                //         $('#product_id').val(data.la_id);
                //         $('#name').val(data.la_customerNname);
                //         $('#mobile').val(data.la_mobile);
                //         $('#address').val(data.la_address);
                //         $('#city').val(data.la_city);
                //         $('#project_name').val(data.la_pn_id);
                //         $('#a_size').val(data.la_as_id);

                //         // Checkbox handling for 'detail' field (assuming it's a checkbox)
                //         if (data.la_status === '1') {
                //             $('input[name="detail"]').prop('checked', true);
                //         } else {
                //             $('input[name="detail"]').prop('checked', false);
                //         }

                //         // Display any errors if needed
                //         $('.print-error-msg').hide();
                        
                //     })
                //     .fail(function(xhr, status, error) {
                //         // Handle errors
                //         var errorMessage = xhr.status + ': ' + xhr.statusText;
                //         console.error(errorMessage);
                //     });
                // });
                // $('body').on('click', '.editLead', function() {
                //     var product_id = $(this).data('id');                      
                   
                // });

                  // Assume you have an edit button with class "editBtn"
                   

                  /*------------------------------------------
                  --------------------------------------------
                  Create Lead Code
                  --------------------------------------------
                  --------------------------------------------*/

                  $('#productForm').submit(function(e) {
                      e.preventDefault();

                      let formData = new FormData(this);
                      $('#saveBtn').html('Sending...');
                      $('.error').text('');

                      $.ajax({
                          type: 'POST',
                          url: "{{ route('leadadd.store') }}",
                          data: formData,
                          contentType: false,
                          processData: false,
                          success: (response) => {
                              $('#saveBtn').html('Submit');
                              $('#product_id').val('');
                              $('#productForm').trigger("reset");
                              $('#ajaxModel').modal('hide');
                              table.draw();
                          },                       
                        error: function(xhr, status, error) {
                            $('#saveBtn').html('Submit');
                            console.error(xhr.responseText);
                            var response = JSON.parse(xhr.responseText);
                            if (response.errors) {
                                $.each(response.errors, function(key, value) {
                                    $("#" + key + "_error").text(value[0]).show();
                                });
                            }
                          }
                      });
                  });

                  /*------------------------------------------
                  --------------------------------------------
                  Delete Lead Code
                  --------------------------------------------
                  --------------------------------------------*/
                  $('body').on('click', '.deleteLead', function() {

                      var product_id = $(this).data("id");
                      confirm("Are You sure want to delete?");

                      $.ajax({
                          type: "DELETE",
                          url: "{{ route('leadadd.store') }}" + '/' + product_id,
                          success: function(data) {
                              table.draw();
                          },
                          error: function(data) {
                              console.log('Error:', data);
                          }
                      });                   
                  });

              });
          </script>
      @endsection