$(document).ready(function (){
    var table = $('#categories').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: true,
        pageLength: 10,
        order: [0,'asc'],
        "ajax" : {
            "url" : baseUrl+"/getAllCategories",
            "type" : "POST",
            "data" : {
              "_token" : $("meta[name='csrf_token']").attr('content')
            },
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action',orderable: false, searchable: false},
            {data: 'action1', name: 'action1',orderable: false, searchable: false}
        ],
        "columnDefs" : [
            {
                "render" : function (data,type,row,meta){
                  return `<a href="#" class="btn btn-primary btn-sm editCategory" id="${row.id}"><i class='fas fa-pencil-alt'></i> </a>`;
                },
                "targets" : 4
            },

            {
                "render" : function (data,type,row,meta){
                    return `<a href="#" class="btn btn-danger btn-sm deleteCategory" id="${row.id}"><i class='far fa-trash-alt'></i></a>`;
                },
                "targets" : 5
            },
        ]
    });
        //create category
    $('#addCategory').submit(function (event){
        event.preventDefault();
        var form = $('#addCategory')[0];
        var formData = new FormData(form);


        $.ajax({
            url : baseUrl+'/addCategory',
            type : 'POST',
            data : formData,
            contentType : false,
            processData : false,


            success: function (data)
            {
                $('#addCategoryModal').modal('hide');
                onSuccessRemoveErrors();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Category created successfully',
                })
                table.ajax.reload();
            },
            error: function (reject)
            {
                if (reject.status === 422){
                    removeErrors();
                    var errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function (key,value){
                        $('#'+key).addClass('is-invalid');
                        $('#'+ key + "_help").text(value[0]);
                    })
                }
            }
        });
    });
    //get category for edit
    $(document).on('click','.editCategory', function (e){
        e.preventDefault();
        var id = $(this).attr('id');
       $.ajax({
          url : baseUrl+'/getCategory/'+id,
          type : 'Get',
          processData: false,
          contentType: false,
          success : function (data){
              $('#category_id').val(data.id);
              $('#edit_category').val(data.name);
              $('#editCategoryModal').modal('show');

          } ,
           error : function (data,textStatus, xhr)
           {
               Swal.fire({
                   icon: 'error',
                   title: 'Not Found',
                   text: 'Sorry we were unable to find this record',
               })
           }
       });
    });
    //update Category
    $('#editCategory').submit(function (e){
        e.preventDefault();
        var form = $('#editCategory')[0];
        var formData = new FormData(form);
        $.ajax({
            url : baseUrl+'/updateCategory',
            type : 'POST',
            data : formData,
            processData : false,
            contentType : false,
            success : function (data)
            {
                $('#editCategoryModal').modal('hide');
                onSuccessRemoveEditErrors();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Category updated successfully',
                })
                table.ajax.reload();
            },
            error: function (reject)
            {
                if (reject.status === 422){
                    removeEditErrors();
                    var errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function (key,value){
                        $('#'+key).addClass('is-invalid');
                        $('#'+ key + "_help").text(value[0]);
                    })
                }
            }
        })
    });
    //Delete Category
    $(document).on('click', '.deleteCategory', function (e){
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
                    url : baseUrl+'/deleteCategory/'+id,
                    type : 'GET',
                    processData : false,
                    contentType : false,
                    success : function (data){
                        onSuccessRemoveEditErrors();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Category deleted successfully',
                        })
                        table.ajax.reload();
                    },
                    error : function (data,textStatus, xhr)
                    {
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


    function onSuccessRemoveEditErrors(){
        $('#edit_category').removeClass('is-invalid');
        $('#edit_category').val('');
        $('#edit_category_help').text('');
    }

    function removeEditErrors(){
        $('#edit_category').removeClass('is-invalid');
        $('#edit_category_help').text('');
    }

    $('#editCategoryModal').on('hidden.bs.modal', function (){
        onSuccessRemoveEditErrors();
    });

    function onSuccessRemoveErrors(){
        $('#category_name').removeClass('is-invalid');
        $('#category_name').val('');
        $('#category_name_help').text('');
    }

    function removeErrors(){
        $('#category_name').removeClass('is-invalid');
        $('#category_name_help').text('');
    }

    $('#addCategoryModal').on('hidden.bs.modal', function (){
        onSuccessRemoveErrors();
    });

});
