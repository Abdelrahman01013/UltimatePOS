@extends('layouts.app')
@section('title', __( 'lang_v1.inventory' ))

@section('content')

    <div class="container">
        
        <div class="card">
            
            <div style="margin-bottom: 30px" class="card-header">
                <h2 class="">جرد المخازن</h2>
            </div>

            <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data" >
                @csrf
                <div class="row" >
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">بحث عن منتج : </label>
                        <div class="" >
                                <input name="search_word" id="search-product" type="text" class="form-control" placeholder=". . ."  aria-describedby="basic-addon1">
                                <ul class="list-group">
                                    </ul>
                                    <div id="localeSearchSimple" ></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputEmail1">آخر منتج تم جرده</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                <input type="text" class="form-control" placeholder=". . ."  aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <br>
                <form method="post" action="" enctype="multipart/form-data" >
                    @csrf
                    <div class="row" >
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">إسم المنتج</label>
                                <input  type="text" class="form-control" id="product-name" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">الكمية الحالية</label>
                                <input type="number" class="form-control" id="current-quantity" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">الكمية الموجودة ( في المخزن )</label>
                                <input type="number" class="form-control" id="finded-quantity" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>

                        <div style="margin-top: 30px" class="col-md-3">
                            <span style="padding: 7px; border-radius: 5px" class="bg-success" >هذا المنتج تم جرده من قبل</span>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">الفارق</label>
                                <input disabled type="text" class="form-control" id="different-quantity" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                        <div style="margin-top: 24px" class="col-md-3">
                            <div class="form-group">
                                <input type="button" value="جرد" class="btn btn-primary" id="save" aria-describedby="emailHelp" placeholder=". . .">
                                <input type="button" value="حفظ و تسوية" class="btn btn-primary" id="save" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>

                    <table style="width: 80%" class="table text-center">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">إسم المنتج</th>
                            <th scope="col">الكمية الحالية</th>
                            <th scope="col">الكمية الموجودة</th>
                            <th scope="col">الفارق</th>
                            <th scope="col">حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>
                                <button class="btn btn-danger" >Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>@fat</td>
                            <td>
                                <button class="btn btn-danger" >Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>@fat</td>
                            <td>
                                <button class="btn btn-danger" >Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                            <td>
                                <button class="btn btn-danger" >Delete</button>
                            </td>
                            </tr>
                        </tbody>
                    </table>


                </form>

            </div>
        </div>







    </div>




@stop

@section('javascript')

    <script>

        $("#search-product").on("keyup", function() {
                
            var searchText = $(this).val();
            
            if(searchText != '') {
                
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('inventory-search-for-products')}}",
                    data: {
                        'search_word': searchText,
                    },
                    success: function(data) {
                        $('.list-group').empty();
                        $.each(data, function( index, value ) {
                            var item = "<a name="+value.id+" class=\"list-group-item list-group-item-action\">"+value.name+"</a>";
                            $('.list-group').append(item);
                        });
                        $('.list-group-item').on('click', function() {
                        
                            $.ajax({
                                type: 'post',
                                enctype: 'multipart/form-data',
                                url: "{{route('inventory-get-products')}}",
                                data: {
                                    'id': $(this).attr('name'),
                                },
                                success: function(data) {
                                    $("#product-name").val(data.name);
                                    $("#current-quantity").val(data.alert_quantity);

                                    $('.list-group').empty();
                                    $('.list-group').css('display', 'none');
                                    $('#search-product').val('');
                                    $('#finded-quantity').val('');
                                    $('#different-quantity').val('');


                                }, error: function(reject) {
                                }
                            });
                        });

                        $("#finded-quantity").on("keyup", function() {
                            if($(this).val() != '') {
                                $('#different-quantity').val($('#finded-quantity').val() - $('#current-quantity').val());
                            } else {
                                $('#different-quantity').val('');
                            }
                        });

                    }, error: function(reject) {}
                });
            }

            if($(this).val() == 0) {
                $('.list-group').css('display', 'none');
            } else {
                $('.list-group').css('display', 'block');
            }

            
            
        });


    </script>

@endsection
