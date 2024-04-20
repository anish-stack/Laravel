 <div class="col-md-6">
     <div class="card mt-5">
         <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Master Data Table</h2>
         <div class="card-body">
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
                      ajax: "{{ route('lead.index') }}",
                      columns: [{
                              data: 'DT_RowIndex',
                              name: 'DT_RowIndex'
                          },
                          {
                              data: 'name',
                              name: 'name'
                          },
                          {
                              data: 'detail',
                              name: 'detail'
                          },
                          {
                              data: 'action',
                              name: 'action',
                              orderable: false,
                              searchable: false
                          },
                      ]
                  });

                  /*------------------------------------------
                  --------------------------------------------
                  Click to Button
                  --------------------------------------------
                  --------------------------------------------*/
                  $('#createNewLead').click(function() {
                      $('#saveBtn').val("create-product");
                      $('#product_id').val('');
                      $('#productForm').trigger("reset");
                      $('#modelHeading').html("<i class='fa fa-plus'></i> Create New Lead");
                      $('#ajaxModel').modal('show');
                  });

                  /*------------------------------------------
                  --------------------------------------------
                  Click to Show Button
                  --------------------------------------------
                  --------------------------------------------*/
                  $('body').on('click', '.showLead', function() {
                      var product_id = $(this).data('id');
                      $.get("{{ route('lead.index') }}" + '/' + product_id, function(data) {
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
                  $('body').on('click', '.editLead', function() {
                      var product_id = $(this).data('id');
                      $.get("{{ route('lead.index') }}" + '/' + product_id + '/edit', function(data) {
                          $('#modelHeading').html(
                          "<i class='fa-regular fa-pen-to-square'></i> Edit Lead");
                          $('#saveBtn').val("edit-user");
                        //   $('#ajaxModel').modal('show'); 
                          $('#product_id').val(data.id);
                          $('#name').val(data.name);
                          $('#detail').val(data.detail);
                      })
                  });

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

                      $.ajax({
                          type: 'POST',
                          url: "{{ route('lead.store') }}",
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
                          error: function(response) {
                              $('#saveBtn').html('Submit');
                              $('#productForm').find(".print-error-msg").find("ul").html('');
                              $('#productForm').find(".print-error-msg").css('display', 'block');
                              $.each(response.responseJSON.errors, function(key, value) {
                                  $('#productForm').find(".print-error-msg").find("ul")
                                      .append('<li>' + value + '</li>');
                              });
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
                          url: "{{ route('lead.store') }}" + '/' + product_id,
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