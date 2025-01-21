@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8 col-sm-8 col-xs-8">
        <h2> Configurations </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong> Configurations </strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-4 col-sm-4 col-xs-4 text-right">
        <a class="btn btn-danger text-white t_m_25" id="session_destory">
            <i class="fa fa-trash" aria-hidden="true"></i> Delete Session
        </a>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="manage_tbl" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($configs as $item)
                                <tr class="gradeX">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->key  }}</td>
                                    <td>{{($item->key == 'api_password' || $item->key == 'session_id') ? '**********' : $item->value}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm btn_testimonial_edit" data-id="{{$item->id}}" type="button"><i class="fa-solid fa-edit"></i> Edit</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p>Showing {{ $configs->firstItem() }} to {{ $configs->lastItem() }} of {{ $configs->total() }} entries</p>
                        </div>
                        <div class="col-md-3 text-right">
                            {{ $configs->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal show fade" id="edit_modalbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content animated flipInY" id="edit_modalbox_body">
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('#manage_tbl').dataTable({
        "paging": false,
        "searching": false,
        "bInfo": false,
        "responsive": true,
        "columnDefs": [{
                "responsivePriority": 1,
                "targets": 0
            },
            {
                "responsivePriority": 2,
                "targets": -1
            },
        ]
    });

    $(document).on("click", ".btn_testimonial_edit", function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "{{ url('admin/config/show') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function(status) {
                $("#edit_modalbox_body").html(status.response);
                $("#edit_modalbox").modal('show');
            }
        });
    });
    $(document).on("click", "#update_testimonial_button", function() {
        var btn = $(this).ladda();
        btn.ladda('start');
        var formData = new FormData($("#edit_testimonial_form")[0]);
        $.ajax({
            url: "{{ url('admin/config/update') }}",
            type: 'POST',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function(status) {
                if (status.msg == 'success') {
                    toastr.success(status.response, "Success");
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else if (status.msg == 'error') {
                    btn.ladda('stop');
                    toastr.error(status.response, "Error");
                } else if (status.msg == 'lvl_error') {
                    btn.ladda('stop');
                    var message = "";
                    $.each(status.response, function(key, value) {
                        message += value + "<br>";
                    });
                    toastr.error(message, "Error");
                }
            }
        });
    });

    $(document).on("click", "#session_destory", function() {
        // sweet alert to confirm
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this session!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, please!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ url('admin/config/destroySession') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(status) {
                            $(".confirm").prop("disabled", false);
                            if (status.msg == 'success') {
                                swal({
                                        title: "Success!",
                                        text: status.response,
                                        type: "success"
                                    },
                                    function(data) {
                                        location.reload();
                                    });
                            } else if (status.msg == 'error') {
                                swal("Error", status.response, "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });


    });
</script>
@endpush