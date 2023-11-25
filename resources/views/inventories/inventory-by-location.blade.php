@extends('layouts.app')
@section('title', __( 'lang_v1.inventory' ))

@section('content')

    <div class="container">
        
        <div class="card">
            
            <div style="margin-bottom: 30px;display: flex; justify-content:space-between; align-items:center" class="card-header d-flex flex-row">
                <h2 class="">جرد المخازن</h2>
                <form method="post" action="" enctype="multipart/form-data" >
                @csrf
                    @php 
                        $active = empty(session()->get('inventory'));
                    @endphp
                    <button @if($active) disabled @endif type="button" id="remove-inventories" class="btn btn-danger mt-2" >
                        <i style="margin-left: 5px" class="glyphicon glyphicon-trash" ></i>مسح عمليات الجرد
                    </button>
                    <button @if($active) disabled @endif type="button" id="store-inventories" class="btn btn-primary mt-2" >
                        <i style="margin-left: 5px" class="fas fa-save"></i>حفظ و تسوية
                    </button>
                </form>
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
                                @php
                                    if(isset($last_inventory)) {
                                        $last_inventory = $last_inventory['date'] .' / '. $last_inventory['name'];
                                    }else
                                        $last_inventory = '';
                                @endphp
                                <span class="input-group-addon" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                <input readonly value="{{$last_inventory}}" type="text" class="form-control" placeholder=". . ."  aria-describedby="basic-addon1">
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
                        <input type="hidden" id='product-id' value="">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">إسم المنتج</label>
                                <input readonly type="text" class="form-control" id="product-name" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">الكمية الحالية ( المسجلة )</label>
                                <input readonly type="number" class="form-control" id="current-quantity" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">الكمية الموجودة ( في المخزن )</label>
                                <input type="number" class="form-control" id="finded-quantity" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>

                        <div id="is-inventory-exist" style="margin-top: 30px;visibility:hidden" class="col-md-3">
                            <span style="padding: 7px; border-radius: 5px;font-size: 12px" class="bg-success" >هذا المنتج تم جرده من قبل , سيتم تحديث الجرد</span>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">الفارق</label>
                                <input readonly type="text" class="form-control" id="different-quantity" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                        <div style="margin-top: 24px" class="col-md-6">
                            <div class="form-group">
                                <button type="button" id="save" class="btn btn-primary inventoryAction" >
                                    <i style="margin-left: 5px" class="fa fas fa-file-invoice" ></i>جرد
                                </button>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>

                    @if(!empty(session()->get('inventory')))

                        <table id="inventories-table" style="width: 80%" class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">إسم المنتج</th>
                                    <th scope="col">الكمية الحالية</th>
                                    <th scope="col">الكمية الموجودة</th>
                                    <th scope="col">الفارق</th>
                                </tr>
                            </thead>
                            <tbody id="inventories-items" >
                                
                                @foreach($session_inventories as $inventory)
                                    <tr id="inventories-item" >
                                        <th scope="row">{{$loop->iteration++}}</th>
                                        <td>{{ $inventory['product_name'] }}</td>
                                        <td>{{ $inventory['current_quantity'] }}</td>
                                        <td>{{ $inventory['finded_quantity'] }}</td>
                                        <td>{{ $inventory['difference_quantity'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif


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
                                    

                                    $("#product-id").val(data.product.id);
                                    $("#product-name").val(data.product.name);
                                    $("#current-quantity").val(data.quantity);

                                    $('.list-group').empty();
                                    $('.list-group').css('display', 'none');
                                    $('#search-product').val('');
                                    $('#finded-quantity').val('');
                                    $('#different-quantity').val('');

                                    if(data.inventory) {
                                        $('#is-inventory-exist').css('visibility', 'visible');
                                    }else {
                                        $('#is-inventory-exist').css('visibility', 'hidden');
                                    }
                                    

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

        $('.inventoryAction').on('click', function() {
            
            if($("#product-name").val() != '') {
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('inventory-make')}}",
                    data: {
                        'product_id': $("#product-id").val(),
                        'product_name': $("#product-name").val(),
                        'current_quantity': $("#current-quantity").val(),
                        'finded_quantity': $("#finded-quantity").val(),
                        'difference_quantity': $("#different-quantity").val(),
                        'request_status': $(this).attr('name'),
                    },
                    success: function(data) {
                        $('#inventories-items').empty();
                        $("#inventories-table").css('visibility', 'visible');
                        $.each(data, function( index, inventory ) {
                            index++;
                            var item = "<tr id=\"inventories-item\" ><th scope=\"row\">"+index+"</th><td>"+inventory.product_name+"</td><td>"+inventory.current_quantity+"</td><td>"+inventory.finded_quantity+"</td><td>"+inventory.difference_quantity+"</td></tr>"
                            $('#inventories-items').append(item);
                        });

                        $("#product-name").val('');
                        $("#current-quantity").val('');
                        $("#finded-quantity").val('');
                        $("#different-quantity").val('');

                        $("#remove-inventories").prop("disabled", false);
                        $("#save-inventories").prop("disabled", false);

                        // console.log() make page reload just one time

                        location.reload();


                    }, error: function(reject) {
                    }
                });
            }

        });

        $('#remove-inventories').on('click', function() {

            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('inventory-remove')}}",
                data: {
                    '': '',
                },
                success: function(data) {
                    $("#inventories-table").css('visibility', 'hidden');
                    $("#remove-inventories").prop("disabled", true);
                    $("#store-inventories").prop("disabled", true);

                }, error: function(reject) {}
            });


        });

        $('#store-inventories').on('click', function() {

            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('inventory-store')}}",
                data: {
                    '': '',
                },
                success: function(data) {
                    $("#inventories-table").css('visibility', 'hidden');
                    $("#remove-inventories").prop("disabled", true);
                    $("#store-inventories").prop("disabled", true);

                    location.reload();

                }, error: function(reject) {}
            });


        });




    </script>

@endsection
