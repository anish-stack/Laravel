@extends('layout.main')

@section('main-container')
    {{-- <div class="col-md-6"> --}}
    <div class="card mt-5">
        <h2 class="card-header"><i class="fa-regular fa-credit-card"></i> Assign Lead</h2>
        <div class="card-body">
            <!-- Add user selection dropdown and assign button -->
<!-- Assign to User dropdown and Assign Selected Leads button -->
<div id="assignSection" style="display: none;">
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="userSelect">Assign to User:</label>
            <select class="form-control " id="userSelect">
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
         <div class="form-group col-md-2">
            <label for="userSelect"></label>
             <button id="assignBtn" class="btn btn-info form-control">Assign Leads</button>
         </div>
    </div>
</div>


<!-- Add DataTable HTML -->
<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAllLeads">#</th>
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
        </tr>
    </thead>
    <tbody></tbody>
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
                                    <input type="text" id="dataIdInput" name="lead_id" value="">
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
                                            <option value="{{ $key }}"
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
                            <th>Update By</th>
                            <th>status</th>
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


    // Modify DataTable initialization to include checkbox column
var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('leadassign.index') }}",
   columns: [
        { 
            data: null,
             render: function (data, type, row) {
                return '<input type="checkbox" class="lead-checkbox" value="' + row.la_id + '">';
            },
            orderable: false,
            searchable: false
        },
        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
        { data: 'created_at', name: 'created_at' },
        { data: 'updated_at', name: 'updated_at' },
        { data: 'la_customerNname', name: 'la_customerNname' },
        { data: 'la_mobile', name: 'la_mobile' },
        { data: 'la_address', name: 'la_address' },
        { data: 'la_city', name: 'la_city' },
        { data: 'lpn_name', name: 'lpn_name' },
        { data: 'las_name', name: 'las_name' },
        { data: 'la_remark', name: 'la_remark', orderable: false, searchable: false }
    ]
});

// Add event listener for lead assignment
$('#assignBtn').click(function() {
    var leadIds = [];

    // Get IDs of selected leads
    $('.lead-checkbox:checked').each(function() {
        leadIds.push($(this).val());
    });

    var userId = $('#userSelect').val(); // Get selected user ID

    // Send AJAX request to assign leads
    $.ajax({
        type: 'POST',
        url: '{{ route("assignLead.assignLead") }}',
        data: {
            '_token': '{{ csrf_token() }}',
            'lead_ids': leadIds,
            'user_id': userId
        },
        success: function(response) {
            // Reload DataTable after successful assignment
            table.ajax.reload();
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

// Function to toggle all displayed lead checkboxes
$('#selectAllLeads').change(function() {
    var isChecked = $(this).prop('checked');
    $('.lead-checkbox').prop('checked', isChecked);
    toggleAssignSectionVisibility();
});

// Function to check if any checkbox is checked
function anyCheckboxChecked() {
    return $('.lead-checkbox:checked').length > 0;
}

// Show/hide the "Assign to User" dropdown and the "Assign Selected Leads" button based on checkbox state
function toggleAssignSectionVisibility() {
    if (anyCheckboxChecked()) {
        $('#assignSection').show();
    } else {
        $('#assignSection').hide();
    }
}

// Show the "Assign to User" dropdown and the "Assign Selected Leads" button when any checkbox is clicked
$('.data-table').on('change', '.lead-checkbox', function() {
    toggleAssignSectionVisibility();
});

// Hide the "Assign to User" dropdown and the "Assign Selected Leads" button when all checkboxes are unchecked
$('#assignBtn').click(function() {
    $('.lead-checkbox').prop('checked', false);
    $('#selectAllLeads').prop('checked', false);
    $('#assignSection').hide();
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
            $('#closepop').click(function() {
                // Hide the modal
                $('#exampleModal').modal('hide');
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
                                data: 'lur_user_id',
                                name: 'lur_user_id',
                                orderable: false,
                                searchable: false
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
