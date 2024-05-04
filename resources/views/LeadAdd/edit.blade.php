@extends('layout.main')

@section('main-container')
    <div class="container">
        <div class="modal-body" id="ajaxModel">
            <h4>Edit Lead</h4>
            <form id="productForm" name="productForm" class="form-horizontal">
                <input type="hidden" name="product_id" id="product_id" value="{{ $lead->la_id ? $lead->la_id : '' }}">                   
                        @csrf
                       
                        <div class="form-group row">
                            <label class="col-3 col-form-label">Status</label>
                            <div class="col-3">
                                <span class="switch">
                                    <label>
                                       <input type="checkbox" {{ $lead->la_status ? 'checked' : '' }} name="detail" />                                                                              
                                        <span></span>
                                    </label>
                                </span>
                            </div>		
                        </div>	
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="source" class=" control-label">Lead Source:</label>
                            <select class="form-control" id="source" name="source">
                                    <option value="" selected disabled>Select Source</option>
                                    @foreach($sources as $sourceId => $sourceName)                                        
                                         <option value="{{ $sourceId }}" {{ $lead->la_source == $sourceId ? 'selected' : '' }}>{{ $sourceName }}</option>
                                    @endforeach
                                </select>
                            <span id="source_error" class="error text-danger" style="display:none"></span>
                        </div>
                        <div class="col-lg-6">
                            <label for="name" class=" control-label">Name:</label>
                           <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="{{ $lead->la_customerNname }}" maxlength="50" >
                            <span id="name_error" class="error text-danger" style="display:none"></span>
                        </div>
                    </div>

                    <div class="form-group row">                        
                        <div class="col-lg-6">
                            
                            @php
                                $mobileNumbers = explode(',', $lead->la_mobile);
                                @endphp
                            @foreach($mobileNumbers as $mobileNumber)
                            <div class="add-mobile">
                                <label for="name" class="control-label">Mobile:</label>
                                    <input type="number" class="form-control mobile" id="mobile[]" name="mobile[]"
                                        placeholder="Enter Mobile" value="{{ $mobileNumber }}" maxlength="50"><br>
                                    <span id="mobile_error" class="error text-danger" style="display:none"></span>
                                    <button type="button" class="remove-item-btn" style="display: block;"><i class="fas fa-times"></i></button>
                            </div>
                            @endforeach
                            
                            <button type="button" class="btn btn-primary add_mobile">Add Mobile</button>
                        </div>

                        <div class="col-lg-6">
                            <label for="name" class=" control-label">Address:</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Enter Address" value="{{ $lead->la_address }}" maxlength="50">
                            <span id="address_error" class="error text-danger" style="display:none"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="name" class=" control-label">City:</label>
                            <input type="text" class="form-control" id="city" name="city"
                                placeholder="Enter Name" value="{{ $lead->la_city }}" maxlength="50">
                            <span id="city_error" class="error text-danger" style="display:none"></span>
                        </div>
                        <div class="col-lg-6">
                            <label for="project_name" class=" control-label">Project Name:</label>

                           <select class="form-control" id="project_name" name="project_name" value="{{ $lead->la_pn_id }}">
                                    <option value="" selected disabled>Select Project Name</option>
                                    @foreach($projects as $projectId => $projectName)
                                        <option value="{{ $projectId }}" {{ $lead->la_source == $projectId ? 'selected' : '' }}>{{ $projectName }}</option>
                                    @endforeach
                                </select>
                                <span id="project_name_error" class="error text-danger" style="display:none"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="a_size" class=" control-label">Available Size:</label>

                            <select class="form-control" id="a_size" name="a_size" value="{{ $lead->la_as_id }}">
                                    <option value="" selected disabled>Select Available Size</option>
                                    @foreach($sizes as $sizeId => $size)
                                        <option value="{{ $sizeId }}" {{ $lead->la_source == $sizeId ? 'selected' : '' }}>{{ $size }}</option>
                                    @endforeach
                                </select>
                                <span id="a_size_error" class="error text-danger" style="display:none"></span>

                        </div>
                        <div class="col-lg-6">
                            <label for="remark-name" class=" control-label">Remarks:</label>

                             <input type="text" class="form-control" id="remark" name="remark"
                                    placeholder="Enter Remarks" value="{{ $lead->la_remark }}" maxlength="50">
                            <span id="remark_error" class="error text-danger" style="display:none"></span>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"><i
                                    class="fa fa-save"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                        {{-- <div class="col-lg-6 text-lg-right">
                    <button type="reset" class="btn btn-danger">Delete</button>
                </div> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
    
   
@endsection

@section('scripts')
<script>
        $(document).ready(function() {
            // Add Mobile Number
            $('.add_mobile').click(function() {
                var clonedInput = $('.add-mobile').eq(0).clone(true); // Cloning the first .add-mobile element (index starts from 0)
                clonedInput.find('.mobile').val(''); // Clear the input value
                clonedInput.find('.mobile_error').hide(); // Hide any error message
                clonedInput.find('.remove-item-btn').show(); // Show remove button
                // $(this).before(clonedInput);
                // $(this).closest('.form-group').find('.col-lg-6').append(clonedInput);
                $(this).closest('.form-group').find('.col-lg-6:first').append(clonedInput);
            });

            // Remove Mobile Number
            $(document).on('click', '.remove-item-btn', function() {
                $(this).closest('.add-mobile').remove();
                updateRemoveButtons();
            });
 
            function updateRemoveButtons() {
                var mobileRows = $('.add-mobile').length;
                $('.remove-item-btn').toggle(mobileRows > 1); // Hide remove button if only one row is left
            }
        });

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
                            //   table.draw();
                            //   window.location.href="{{ route('leadadd.index') }}";
                            window.location.href = "{{ route('leadadd.index') }}";
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

</script>
@endsection
        
        