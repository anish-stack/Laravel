 <div class="col-md-6">
     <div class="card mt-5">
         <h2 class="card-header"><i class="fa-regular fa-credit-card"></i>Task Table</h2>
         <div class="card-body">
             <table class="table table-bordered data-table">
                 <thead>
                     <tr>
                         <th width="60px">No</th>
                         <th>Task Name</th>
                         <th>Remark</th>
                         <th>Date</th>
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
                      ajax: "{{ route('ourtask.index') }}",
                      columns: [{
                              data: 'DT_RowIndex',
                              name: 'DT_RowIndex'
                          },
                          {
                              data: 'ot_name',
                              name: 'ot_name'
                          },
                          {
                              data: 'ot_remark',
                              name: 'ot_remark'
                          },
                          {
                              data: 'ot_remind_dt',
                              name: 'ot_remind_dt'
                          },
                          {
                              data: 'ot_status',
                              name: 'ot_status'
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
                    //         url: "{{ route('ourtask.updateStatus') }}", // Replace 'updateStatus' with your actual route name
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
                            url: "{{ route('ourtask.updateStatus') }}",
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
                      var ot_id = $(this).data('id');                      
                      $.get("{{ route('ourtask.index') }}" + '/' + ot_id + '/edit', function(data) {
                          $('#modelHeading').html(
                          "<i class='fa-regular fa-pen-to-square'></i> Edit Lead");
                        //   $('#saveBtn').val("edit-user"); 
                          $('#saveBtn').html('Update');                      
                          $('#ot_id').val(data.ot_id);
                          $('#ourtask').val(data.ot_name);
                          $('#ourremark').val(data.ot_remark);
                          $('#ourdate').val(data.ot_remind_dt);

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
                //   $('#ourtaskForm').submit(function(e) {
                //       e.preventDefault();

                //       let formData = new FormData(this);
                //       $('#saveBtn').html('Sending...');

                //       $.ajax({
                //           type: 'POST',
                //           url: "{{ route('ourtask.store') }}",
                //           data: formData,
                //           contentType: false,
                //           processData: false,
                //           success: (response) => {
                //               $('#saveBtn').html('Submit');
                //               $('#ourtaskForm').trigger("reset");
                //               $('#ajaxModel').modal('hide');
                //               table.draw();
                //           },
                //           error: function(response) {
                //               $('#saveBtn').html('Submit');
                //               $('#ourtaskForm').find(".print-error-msg").find("ul").html('');
                //               $('#ourtaskForm').find(".print-error-msg").css('display', 'block');
                //               $.each(response.responseJSON.errors, function(key, value) {
                //                   $('#ourtaskForm').find(".print-error-msg").find("ul")
                //                       .append('<li>' + value + '</li>');
                //               });
                //           }
                //       });
                //   });

                  $('#ourtaskForm').submit(function(e) {
                      e.preventDefault();

                      let formData = new FormData(this);
                      $('#saveBtn').html('Sending...');
                      $('.error').text('');

                      $.ajax({
                          type: 'POST',
                          url: "{{ route('ourtask.store') }}",
                          data: formData,
                          contentType: false,
                          processData: false,
                          success: (response) => {
                              $('#saveBtn').html('Submit');
                              $('#ot_id').val('');
                              $('#ourtaskForm').trigger("reset");
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

                      var ot_id = $(this).data("id");
                      confirm("Are You sure want to delete?");

                      $.ajax({
                          type: "DELETE",
                          url: "{{ route('ourtask.store') }}" + '/' + ot_id,
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