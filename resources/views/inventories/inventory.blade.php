@extends('layouts.app')
@section('title', __('lang_v1.inventory'))



@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('الجرد')
            <small>@lang('التقارير')</small>
        </h1>
        <!-- <ol class="breadcrumb">
                                                                                                                                                                                                                                                                                                                                                                                                                    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                                                                                                                                                                                                                                                                                                                                                                                                                    <li class="active">Here</li>
                                                                                                                                                                                                                                                                                                                                                                                                                </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary', 'title' => __('')])


            @can('user.view')
                <div class="table-responsive">

                    <table class="table table-bordered table-striped" id="inventory_table">
                        <thead>
                            <tr>
                                <th>الباركود</th>
                                <th>اسم المنتج</th>

                                <th>الكميه عند الجرد</th>

                                <th>الكميه في المخز</th>

                                <th>الفارق</th>
                                <th>الكميه الان</th>
                                <th>وقت الجرد</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                        @foreach ($inventory as $inv)
                            <tr>

                                <th> {{ $inv->product->sku }}</th>
                                <th> {{ $inv->product->name }}</th>

                                <th> {{ $inv->current_quantity }}</th>

                                <th> {{ $inv->finded_quantity }}</th>

                                @if ($inv->dif > 0)
                                    <th class="text-success"> {{ $inv->dif }}</th>
                                @else
                                    <th class="text-danger"> {{ $inv->dif }}</th>
                                @endif



                                <th> {{ $inv->product->alert_quantity }}</th>

                                <th> {{ $inv->created_at }}</th>
                                <th>
                                    <a class="btn btn-primary" href="#"
                                        onclick='return confirm("هل انت متاكد من عدم جرد " + "{{ $inv->product->name }}" + "?")'>
                                        عدم الجرد
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endcan
        @endcomponent

        <div class="modal fade user_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>

    </section>
    <!-- /.content -->
@stop
@section('javascript')
    <script type="text/javascript">
        //Roles table



        $(document).on('click', 'button.delete_user_button', function() {
            swal({
                title: LANG.sure,
                text: LANG.confirm_delete_user,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    var data = $(this).serialize();
                    $.ajax({
                        method: "DELETE",
                        url: href,
                        dataType: "json",
                        data: data,
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                users_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#inventory_table').DataTable();
        });
    </script>
@endsection
