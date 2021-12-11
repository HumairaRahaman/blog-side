$(document).ready(function () {
    var table = $('#tags').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: true,
        pageLength: 10,
        order: [0, 'asc'],
        "ajax": {
            "url": baseUrl + "/getAllTags",
            "type": "POST",
            "data": {
                "_token": $("meta[name='csrf_token']").attr('content')
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'action1', name: 'action1', orderable: false, searchable: false}
        ],
        "columnDefs": [
            {
                "render": function (data, type, row, meta) {
                    return `<a href="#" class="btn btn-primary btn-sm editTag" id="${row.id}"><i class='fas fa-pencil-alt'></i> </a>`;
                },
                "targets": 4
            },

            {
                "render": function (data, type, row, meta) {
                    return `<a href="#" class="btn btn-danger btn-sm deleteTag" id="${row.id}"><i class='far fa-trash-alt'></i></a>`;
                },
                "targets": 5
            },
        ]
    });
    //create TAg
    $('#addTag').submit(function (event) {
        event.preventDefault();
        var form = $('#addTag')[0];
        var formData = new FormData(form);


        $.ajax({
            url: baseUrl + '/addTag',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,


            success: function (data) {
                $('#addTagModal').modal('hide');
                onSuccessRemoveErrors();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Tag created successfully',
                })
                table.ajax.reload();
            },
            error: function (reject) {
                if (reject.status === 422) {
                    removeErrors();
                    var errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function (key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + "_help").text(value[0]);
                    })
                }
            }
        });
    });
    //get Tag for edit
    $(document).on('click', '.editTag', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $.ajax({
            url: baseUrl + '/getTag/' + id,
            type: 'Get',
            processData: false,
            contentType: false,
            success: function (data) {
                $('#tag_id').val(data.id);
                $('#edit_tag').val(data.name);
                $('#editTagModal').modal('show');

            },
            error: function (data, textStatus, xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Not Found',
                    text: 'Sorry we were unable to find this record',
                })
            }
        });
    });
    //update Tag
    $('#editTag').submit(function (e) {
        e.preventDefault();
        var form = $('#editTag')[0];
        var formData = new FormData(form);
        $.ajax({
            url: baseUrl + '/updateTag',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#editTagModal').modal('hide');
                onSuccessRemoveEditErrors();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Tag updated successfully',
                })
                table.ajax.reload();
            },
            error: function (reject) {
                if (reject.status === 422) {
                    removeEditErrors();
                    var errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function (key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key + "_help").text(value[0]);
                    })
                }
            }
        })
    });
    //Delete Category
    $(document).on('click', '.deleteTag', function (e) {
        e.preventDefault();
        var id = $(this).attr('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: baseUrl + '/deleteTag/' + id,
                    type: 'GET',
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        onSuccessRemoveEditErrors();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Tag deleted successfully',
                        })
                        table.ajax.reload();
                    },
                    error: function (data, textStatus, xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Not Found',
                            text: 'Sorry we were unable to find this record',
                        })
                    }
                })
            }
        })
    });


    function onSuccessRemoveEditErrors() {
        $('#edit_tag').removeClass('is-invalid');
        $('#edit_tag').val('');
        $('#edit_tag_help').text('');
    }

    function removeEditErrors() {
        $('#edit_tag').removeClass('is-invalid');
        $('#edit_tag_help').text('');
    }

    $('#editTagModal').on('hidden.bs.modal', function () {
        onSuccessRemoveEditErrors();
    });

    function onSuccessRemoveErrors() {
        $('#tag_name').removeClass('is-invalid');
        $('#tag_name').val('');
        $('#tag_name_help').text('');
    }

    function removeErrors() {
        $('#tag_name').removeClass('is-invalid');
        $('#tag_name_help').text('');
    }

    $('#addTagModal').on('hidden.bs.modal', function () {
        onSuccessRemoveErrors();
    });

});
