@extends('layouts.app')
@section('title', __( 'lang_v1.inventory' ))

@section('content')

    <div class="container">
        
        <div class="card">
            
            <div style="margin-bottom: 30px" class="card-header">
                <h2 class="">جرد المخازن</h2>
            </div>

            <div class="card-body">
                <form>
                    <div class="row" >
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">بحث عن منتج : </label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" placeholder=". . ." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputEmail1">آخر منتج تم جرده</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                <input type="text" class="form-control" placeholder=". . ." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <br>
                <br>
                <form>
                    <div class="row" >
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">إسم المنتج</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">الكمية الحالية</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">الكمية الموجودة</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder=". . .">
                            </div>
                        </div>

                        <div style="margin-top: 30px" class="col-md-3">
                            <span style="padding: 7px; border-radius: 5px" class="bg-success" >هذا المنتج تم جرده من قبل</span>
                        </div>
                    </div>
                </form>

            </div>
        </div>







    </div>




@stop

@section('javascript')

    <script>
        $(document).ready(function() {
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>


@endsection
