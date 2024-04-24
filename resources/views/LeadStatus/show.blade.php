 <div class="col-md-6">
     <div class="card mt-5">
         <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Leaad Status</h2>
         <div class="card-body">
             <table class="table table-bordered data-table">
                 <thead>
                     <tr>
                         <th width="60px">No</th>
                         <th>Name</th>
                         <th>Status</th>
                         <th width="280px">Action</th>
                     </tr>
                 </thead>
                 <tbody>
                 </tbody>
             </table>
         </div>
     </div>
 </div>

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
                      ajax: "{{ route('leadstatus.index') }}",
                      columns: [{
                              data: 'DT_RowIndex',
                              name: 'DT_RowIndex'
                          },
                          {
                              data: 'ls_name',
                              name: 'ls_name'
                          },
                          {
                              data: 'ls_status',
                              name: 'ls_status'
                          },
                          {
                              data: 'action',
                              name: 'action',
                              orderable: false,
                              searchable: false
                          },
                      ]
                  });                                  

                  // Event delegation to handle click event on toggle buttons
                    // $(document).on('click', '.status-toggle', function() {
                    //     var id = $(this).closest('tr').find('td:first').text().trim(); // Assuming the first column is the ID
                    //     var status = $(this).data('status'); // Get current status

                    //     status = status ? 0 : 1;
                    //     $.ajax({
                    //         type: 'POST',
                    //         url: "{{ route('leadstatus.updateStatus') }}", // Replace 'updateStatus' with your actual route name
                    //         data: { id: id, status: status },
                    //         success: function(response) {
                    //             // Assuming you want to update the status button appearance based on the response from the server
                    //             // You can handle the response here if needed
                    //              var newIcon = status ? '<i class="fa-solid fa-toggle-on"></i>' : '<i class="fa-solid fa-toggle-off"></i>';
                    //             var newClass = status ? 'btn-success' : 'btn-secondary';
                    //             $(this).html(newIcon).removeClass('btn-success btn-secondary').addClass(newClass).data('status', status);
                    //         },
                    //         error: function(xhr, status, error) {
                    //             console.error(xhr.responseText);
                    //         }
                    //     });
                    // });

                    $(document).on('change', '.status-toggle', function() {
                        var id = $(this).data('id');
                        var status = $(this).is(':checked') ? 1 : 0;

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('leadstatus.updateStatus') }}",
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
                  $('body').on('click', '.editLead', function() {
                      var product_id = $(this).data('id');                      
                      $.get("{{ route('leadstatus.index') }}" + '/' + product_id + '/edit', function(data) {
                          $('#modelHeading').html(
                          "<i class='fa-regular fa-pen-to-square'></i> Edit Lead");
                          $('#saveBtn').val("edit-user");                       
                          $('#product_id').val(data.ls_id);
                          $('#name').val(data.ls_name);
                          $('#detail').val(data.ls_status);

                          if (data.lat_status === '1') {
                            $('input[name="detail"]').prop('checked', true);
                        } else {
                            $('input[name="detail"]').prop('checked', false);
                        }
                      })
                  });

                  // Assume you have an edit button with class "editBtn"
                   

                  /*------------------------------------------
                  --------------------------------------------
                  Create Lead Code
                  --------------------------------------------
                  --------------------------------------------*/
                //   $('#productForm').submit(function(e) {
                //       e.preventDefault();

                //       let formData = new FormData(this);
                //       $('#saveBtn').html('Sending...');

                //       $.ajax({
                //           type: 'POST',
                //           url: "{{ route('leadstatus.store') }}",
                //           data: formData,
                //           contentType: false,
                //           processData: false,
                //           success: (response) => {
                //               $('#saveBtn').html('Submit');
                //               $('#productForm').trigger("reset");
                //               $('#ajaxModel').modal('hide');
                //               table.draw();
                //           },
                //           error: function(response) {
                //               $('#saveBtn').html('Submit');
                //               $('#productForm').find(".print-error-msg").find("ul").html('');
                //               $('#productForm').find(".print-error-msg").css('display', 'block');
                //               $.each(response.responseJSON.errors, function(key, value) {
                //                   $('#productForm').find(".print-error-msg").find("ul")
                //                       .append('<li>' + value + '</li>');
                //               });
                //           }
                //       });
                //   });

                  $('#productForm').submit(function(e) {
                      e.preventDefault();

                      let formData = new FormData(this);
                      $('#saveBtn').html('Sending...');
                      $('.error').text('');

                      $.ajax({
                          type: 'POST',
                          url: "{{ route('leadstatus.store') }}",
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
                        //   error: function(xhr,status,error) {
                        //     console.error(xhr.responseText);
                        //     var errors = JSON.parse(xhr.responseText); 
                        //     $.each(errors,function(key,value){
                        //         $("#"+key+"_error").text(value);
                        //     });
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
                          url: "{{ route('leadstatus.store') }}" + '/' + product_id,
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