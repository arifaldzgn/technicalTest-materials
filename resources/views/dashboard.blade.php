@extends('layouts.main')
@extends('layouts.partials.dashboard_modals')

@section('container')
    @if (session('success'))
    <script>
        Swal.fire('Success', '{{ session('success') }}', 'success');
    </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire('Error', '{{ session('error') }}', 'error');
        </script>
    @endif

  <!-- Main Content -->
  <main class="p-4 min-vh-200">
    
        @if( auth()->user()->role === 'Production' )
        <section class="row">
            <div class="col-md-6 col-lg-4">
                <article class="p-4 rounded shadow-sm border-left-card mb-4">
                    <a href="#" class="d-flex align-items-center">
                        <span class="bi bi-box h4 text-success"></span>
                        <h5 class="ml-3 text-success" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Create Request</h5>
                        </a>
                    </article>
                </div>
            </section>
        @endif
        @if(request()->route()->named('dashboard'))    
        <div class="jumbotron jumbotron-fluid rounded bg-white border-0 shadow-sm border-left px-4">
            <div class="container">
                <h1 class="display-4 mb-2 text-primary">Welcome</h1>
                <p class="lead text-muted">{{ auth()->user()->name }} | {{ auth()->user()->role }} | Badge No. {{ auth()->user()->badge_number }}</p>
            </div>
        </div>
        @endif

    <div class="jumbotron jumbotron-fluid rounded bg-white shadow-sm border-left px-4">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Request Name</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="t-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr>
                    <td>{{ $d->request_name }}</td>
                    <td>
                        <h5>
                        @if ($d->status == 'Pending')
                            @if ($d->revised == 'Revised')
                                <span class="badge badge-pill badge-warning">{{ $d->revised }}</span>
                                <span class="badge badge-pill badge-secondary">{{ $d->status }}</span>
                            @else
                                <span class="badge badge-pill badge-secondary">{{ $d->status }}</span>
                            @endif
                        @elseif ($d->status == 'Rejected')
                        <span class="badge badge-pill badge-danger">{{ $d->status }}</span>
                        @else
                        <span class="badge badge-pill badge-success">{{ $d->status }}</span>
                        @endif
                        </h5>

                        </td>
                        <td>{{ $d->created_at }}</td>
                        <td>
                            <!-- <a href="/request/update/{{$d->id}}" class="btn btn-warning">Update</a> -->
                            @if ($d->status == 'Rejected')
                            <button class="updateBtn btn btn-primary" data-request-id="{{ $d->id }}">Update</button>
                            <button class="btn btn-danger delete-btn" data-item-id="{{ $d->id }}">Delete</button>
                            @elseif ($d->status == 'Approved')
                            -
                            @elseif ($d->status == 'Pending')
                            <button class="updateBtn btn btn-primary" data-request-id="{{ $d->id }}">Update</button>
                            <button class="btn btn-danger delete-btn" data-item-id="{{ $d->id }}">Delete</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>       
    </main>

  

    
<script>
    // Multiply New Material 
   $(document).ready(function() {
      var arrayCount = 1;
      var itemCount = 2;
        $("#addItem").click(function() {
            var newItem = `
                <div class="mb-3">
                      <label for="materialName" class="form-label">Requested Material Name ${itemCount}</label>
                     <input type="text" class="form-control" name="materials[${arrayCount}][material_name]" placeholder="example: Additional Cables">
                </div>
                <div class="mb-3">
                      <label for="requestedQuantity" class="form-label">Quantity</label>
                     <input type="number" class="form-control" name="materials[${arrayCount}][quantity]" placeholder="example: 8">
                </div>
                <div class="mb-3">
                    <label for="usageDescription" class="form-label">Description of Usage</label>
                    <textarea class="form-control" name="materials[${arrayCount}][usage]"></textarea>
                </div>
            `;
            $("#materialItems").append(newItem);
            arrayCount++;
            itemCount++;
        });
    });

    // Show Details Material Button 
    $('.updateBtn').click(function() {
        var requestId = $(this).data('request-id');
        $('#approveButton').data('request-id', requestId);
        $('#rejectButton').data('request-id', requestId);
            $.ajax({
                url: '/materials/' + requestId,
                method: 'GET',
                success: function(response) {
                    $('#materialDataForm').empty();
                    var itemCount = 1;  
                    var materialCount = 0;  
                    var userRole = "{{ auth()->user()->role }}";
                    console.log(userRole);
                    $.each(response, function(index, material) {
                        var row = 
                        '<div class="card mb-3">' +
                        '<div class="card-header">' +
                        'Material No. '+ itemCount + '' +
                        '</div>' +
                        '<div class="card-body">' +
                            '<div class="mb-3">' +
                                '<label for="materialName" class="form-label">Requested Material Name </label>' +
                                '<input type="text" class="form-control" id="materialName" name="materials['+materialCount+'][material_name]" value="'+material.material_name+'" '+ (userRole == 'Warehouse' ? 'readonly' : '') +' >' +
                            '</div>' +
                            '<div class="mb-3">' +
                                '<label for="materialQuantity" class="form-label">Quantity</label>' +
                                '     <input type="number" class="form-control" id="requestedQuantity" name="materials['+materialCount+'][quantity]" value="'+material.quantity+'">' +
                            '</div>' +
                            '<div class="mb-3">' +
                                '<label for="materialUsage" class="form-label">Usage</label>' +
                                '<textarea class="form-control" id="usageDescription" name="materials['+materialCount+'][usage]">'+material.usage+'</textarea>' +
                                '<input type="hidden" value="'+material.id+'" name="materials['+materialCount+'][id]">' +
                                '<input type="hidden" value="'+material.request_ticket_id+'" name="materials['+materialCount+'][request_ticket_id]">' ;
                                if (userRole === 'Warehouse') {
                                row += '<small id="passwordHelpBlock" class="form-text text-muted">' +
                                        'You can enter reasons of revisions or rejected regarding the material in this Usage Form'+
                                        '</small>';
                                }
                            '</div>' +
                        '</div>' +
                        '</div>' 
                        $('#materialDataForm').append(row);
                        itemCount++;
                        materialCount ++;
                    });

                    $('#materialModal').modal('show');
                },
                error: function(xhr, status, error) {
                }
            });
    });

    // Save Changes / Update Button
    $('#saveMaterialChanges').click(function() {
        // console.log('saveMaterial');
        var formData = $('#materialDataForm').serialize();

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        });

        $.ajax({
            url: '/update-materials', 
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Material data updated successfully'
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update material data'
                });
            }
            });
    });

    // Approve Status Button
    $('#approveButton').click(function() {
        var requestId = $(this).data('request-id');

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        });

        $.ajax({
            url: '/requests/' + requestId + '/approve',
            method: 'PUT',
            success: function(response) {
                Swal.fire("Success", response.message, "success");
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
                Swal.fire("Error", "Failed to approve request", "error");
            }
        });
    });

    // Reject Status Button
    $('#rejectButton').click(function() {
        var requestId = $(this).data('request-id');

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        });

        $.ajax({
            url: '/requests/' + requestId + '/reject',
            method: 'PUT',
            success: function(response) {
                Swal.fire("Success", response.message, "success");
            },
            error: function(xhr, status, error) {
                console.error(error);
                Swal.fire("Error", "Failed to reject request", "error");
            }
        });
    });

    // Delete Confirmation Modal & Button
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('deleteModal');

        var deleteButtons = document.querySelectorAll('.delete-btn');

        var itemId;

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                itemId = button.getAttribute('data-item-id');
                modal.style.display = 'block';
            });
        });

        // Delete
        var confirmDeleteBtn = document.getElementById('confirmDelete');

        confirmDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            deleteItem(itemId);
        });

        // Cancel
        var cancelDeleteBtn = document.getElementById('cancelDelete');

        cancelDeleteBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        function deleteItem(itemId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
            });
            $.ajax({
                url: '/items/' + itemId,
                method: 'DELETE',
                success: function(response) {
                    Swal.fire('Success', 'Item deleted successfully', 'success');
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error', 'Failed to delete item', 'error');
                }
            });
        }
    });

    $(document).ready(function() {
        $('#password_confirmation').on('keyup', function() {
            var password = $('#password').val();
            var confirmPassword = $('#password_confirmation').val();

            if (password !== confirmPassword) {
                $('#password_confirmation').addClass('is-invalid');
                $('#password_confirmation_feedback').text('Passwords do not match.');
            } else {
                $('#password_confirmation').removeClass('is-invalid');
                $('#password_confirmation_feedback').text('');
            }
        });
    });

    $('#profileForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("profile.update") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire('Success', 'Password successfully changed', 'success');
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Invalid, Password change failed', 'error');
            }
        });
    });

</script>


<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@endsection