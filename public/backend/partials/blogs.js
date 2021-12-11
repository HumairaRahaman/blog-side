$(document).ready(function () {
    var table = $('#blogs').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: true,
        pageLength: 10,
        order: [0, 'asc'],
        "ajax": {
            "url": baseUrl + "/getAllBlogs",
            "type": "POST",
            "data": {
                "_token": $("meta[name='csrf_token']").attr('content')
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'image', name: 'image', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'user_id', name: 'user_id'},
            {data: 'category_id', name: 'category_id'},
            {data: 'short_description', name: 'short_description'},
            {data: 'active', name: 'active'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'action1', name: 'action1', orderable: false, searchable: false}
        ],
        "columnDefs": [
            {
              "width" : '30%' , 'targets' : 5
            },
            {
                "render": function (data, type, row, meta) {
                    return `<img src="${baseUrl}/images/blogImages/${row.image}" class="img-thumbnail rounded">`;
                },
                "targets": 1
            },
            {
                "render": function (data, type, row, meta) {
                    return `<a href="${baseUrl}/editBlog/${row.id}" class="btn btn-primary btn-sm "><i class='fas fa-pencil-alt'></i> </a>`;
                },
                "targets": 7
            },

            {
                "render": function (data, type, row, meta) {
                    return `<a href="#" class="btn btn-danger btn-sm deleteBlog" id="${row.id}"><i class='far fa-trash-alt'></i></a>`;
                },
                "targets": 8
            },
        ]
    });

    //Delete Category
    $(document).on('click', '.deleteBlog', function (e) {
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
                    url: baseUrl + '/deleteBlog/' + id,
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
    })
 });



