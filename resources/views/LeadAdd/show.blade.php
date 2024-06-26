@extends('layout.main')

@section('main-container')
    {{-- <div class="col-md-6"> --}}
        <div class="card mt-5">        
        {{-- <h2 class="card-header">
            <i class="fa-regular fa-credit-card"></i> Manage Lead            
        </h2> --}}
        <div class="row card-header col-md-12">
            {{-- <a href="#" class="btn btn-success font-weight-bold btn-pill">Success</a> --}}
            

            <div class="col-md-6 ">

                <h2 class="">
                    <i class="fa-regular fa-credit-card"></i> Manage Lead
                </h2>
            </div>
            <div class="col-md-5" style="display: flex; justify-content: flex-end;">
                <a href="{{ route('leadadd.create')}}" class="btn btn-success font-weight-bold btn-pill">Create Lead</a>
            </div>
            {{-- <div class="col-md-6 text-right">
                <h3><a href="{{ route('leadadd.create')}}" style="text-decoration: none;
        color: black;">Create Lead</a></h3>
            
            </div> --}}
        </div>

        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="60px">No</th>
                        <th>Last Update</th>
                        <th>Meeting Date</th>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <form id="submitPop">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close">x</i>
                        </button>
                </div>
                <div class="modal-body form" id="kt_form_2">
                    <div class="mb-3">
                        <div class="mb-2">
                            <div class="form-group row">
                                <div class="col-lg-5">
                                    <input type="hidden" id="dataIdInput" name="lead_id" value="">
                                    <label>Remarks:</label>
                                    <input type="text" class="form-control" name="remark" placeholder=""
                                        value="" />
                                    <span id="remark_error" class="error text-danger" style="display:none"></span>
                                </div>
                                <div class="col-lg-4">
                                    <label>Select Status:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select status</option>
                                        @foreach ($status as $key => $value)
                                            <option value="{{ $value }}"
                                                {{ old('status') == $key ? 'selected' : '' }}>{{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span id="status_error" class="error text-danger" style="display:none"></span>
                                </div>
                                <div class="col-lg-3">
                                    <label>Select Meeting date:</label>
                                    <input type="date" class="form-control" name="date" placeholder=""
                                        value="" />
                                    <span id="date_error" class="error text-danger" style="display:none"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold"
                        data-dismiss="modal" id="closepop">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                    {{-- <button type="submit" class="btn btn-success mt-2" id="saveBtn" value="create"><i
                            class="fa fa-save"></i> Submit
                    </button> --}}
                    </form>
                </div>
                <table class="table table-bordered data-table-pop">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Lead Update Date</th>
                            <th>Remark</th>
                            <th>status</th>
                            <th>Update By</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
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
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'la_last_update', // Access the available size through the nested relationship
                        name: 'la_last_update', // Use dot notation to access nested relationship
                    },
                    {
                        data: 'la_meeting_date', // Access the available size through the nested relationship
                        name: 'la_meeting_date', // Use dot notation to access nested relationship
                    },
                    {
                        data: 'la_customerNname',
                        name: 'la_customerNname'
                    },
                    {
                        data: 'la_mobile',
                        name: 'la_mobile'
                    },
                    {
                        data: 'la_address',
                        name: 'la_address'
                    },
                    {
                        data: 'la_city',
                        name: 'la_city'
                    },
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
                    {
                        data: 'la_status',
                        name: 'la_status'
                    },
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
                    data: {
                        id: id,
                        status: status
                    },
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
    <script>
        // alert("hel1lo");
        // openModalz();

        // function openModalz() {
        //     var urlParams = new URLSearchParams(window.location.search); // Get URL parameters
        //     var dataId1 = urlParams.get('la_id'); // Get the value of 'la_id' parameter from the URL

        //     // Check if 'la_id' parameter is present
        //     // alert("hello1");
        //     if (dataId1) {
        //         // alert(dataId1); // This alert should work now
        //         $('#exampleModal').modal('show');
        //         alert("hello");
        //         $('#dataIdInput').val(dataId1);

        //         popdatadisplay(dataId1);
        //         // alert(dataId1); // This alert should work now
        //     }
        // }

        $(document).ready(function() {
            // alert("hh");
            var table = $('.data-table').DataTable();
            $('#closepop').click(function() {
                // Hide the modal
                $('#exampleModal').modal('hide');
                table.ajax.reload();
            });

            console.log("Document is ready.");
            openModalz(); // Call the function after the document is ready

            function openModalz() {
                // console.log("Inside openModalz function.");
                var urlParams = new URLSearchParams(window.location.search);
                var dataId1 = urlParams.get('la_id');

                if (dataId1) {
                    // console.log("la_id parameter found:", dataId1);
                    // alert("hello");
                    $('#exampleModal').modal('show');
                    $('#dataIdInput').val(dataId1);
                    popdatadisplay(dataId1);
                    // popdatadisplay(dataId1); // You might need to define this function if it's not defined elsewhere
                } else {
                    console.log("la_id parameter not found.");
                }
            }
        });


        var table;

        function openModal(button) {
            var dataId = button.getAttribute('data-id');
            $('#dataIdInput').val(dataId);
            popdatadisplay(dataId);
        }
        function openModal(id) {
            // Assuming you're using jQuery to trigger the modal
            $('#exampleModal').modal('show');
            $('#dataIdInput').val(id);
            popdatadisplay(id);

            // You can use id to do further processing if needed
        }


        function popdatadisplay(dataId) {
            // alert("hello");
            $.ajax({
                url: "{{ route('leadpopdata.index') }}",
                method: "GET",
                data: {
                    dataId: dataId
                },
                success: function(response) {
                    if ($.fn.DataTable.isDataTable('.data-table-pop')) {
                        // Destroy the existing DataTable
                        $('.data-table-pop').DataTable().destroy();
                    }

                    // Initialize DataTable with the received data
                    table = $('.data-table-pop').DataTable({
                        processing: true,
                        serverSide: false,
                        data: response,
                        columns: [{
                                data: null, // Use 'null' here, as we're not directly mapping to a data property
                                name: 'serialNumber',
                                render: function(data, type, row, meta) {
                                    // 'meta' parameter contains additional information about the row
                                    return meta.row + 1; // Add 1 to start counting from 1
                                }
                            },
                            {
                                data: 'lur_update_date',
                                name: 'lur_update_date'
                            },
                            {
                                data: 'lur_remark',
                                name: 'lur_remark'
                            },
                            {
                                data: 'lur_interest',
                                name: 'lur_interest'
                            },
                            {
                                data: 'user.name', 
                                name: 'user.name', 
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row, meta) {
                                    // Check if 'user' relationship exists and has 'name' attribute
                                    if(row.user && row.user.name) {
                                        return row.user.name; // Return the name if available
                                    } else {
                                        return ''; // Return empty string if not available
                                    }
                                }
                            }
                        ]
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data from controller:", error);
                }
            });
        }

        $('#submitPop').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let leadId = formData.get('lead_id');
            $('#saveBtn').html('Sending...');
            $('.error').text('');

            $.ajax({
                type: 'POST',
                url: "{{ route('storeFormData') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('Form submitted successfully');
                    $('#saveBtn').html('Submit');
                    $('#submitPop').trigger("reset");

                    // Update the table after successful form submission
                    popdatadisplay(leadId);

                    // Optionally, you can close the modal here
                    // $('#exampleModal').modal('hide');
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
