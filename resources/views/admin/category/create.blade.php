@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="categoryForm">
                
                <div class="card">
                    <div class="card-body">
                        <div class="">
                            <div class="mx-auto w-50 mt-3">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <p></p>
                                </div>
                            </div>

                            <div class="mx-auto w-50 mt-3">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" readonly name="slug" id="slug" class="form-control">
                                    <p></p>
                                </div>
                            </div>

                            <div class="mx-auto w-50 mt-3">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3 d-flex justify-content-center">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>

        </div>

    </section>

@section('customJs')
    <script>
        $("#categoryForm").submit(function(event) {
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('categories.store') }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', true);
                    if (response["status"] == true) {

                        window.location.href = '{{ route('categories.index') }}'

                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")

                        $("#slug").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("")

                    } else {
                        var errors = response['errors'];

                        if (errors['name']) {
                            $("#name").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['name'])
                        } else {
                            $("#name").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }

                        if (errors['slug']) {
                            $("#slug").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback').html(errors['slug'])
                        } else {
                            $("#slug").removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html("")
                        }
                    }

                },
                error: function(jqXHR, exception) {
                    console.log("Something went wrong");
                }
            });
        });


        $("#name").change(function() {
            element = $(this)
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('getSlug') }}',
                type: 'get',
                data: {
                    title: element.val()
                },
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);
                    if (response["status"] == true) {
                        $("#slug").val(response["slug"])
                    }
                }
            })
        })
    </script>
@endsection
@endsection
