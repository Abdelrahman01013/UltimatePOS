@extends('layouts.app')
@section('title', __('lang_v1.inventory'))


@section('content')

    <div class="container">
        <h2 class="text-center">مخزن فرع القاهره</h2>
        <input class="form-control" id="myInput" type="text" placeholder="البحث باستخدام الأسم او الباركود">
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>الباركود</th>
                    <th>اسم المنتج</th>
                    <th>الكميه المتاحه</th>
                    <th>الفارق</th>

                    <th>تاريخ الجرد</th>
                </tr>
            </thead>
            <tbody id="myTable">
                <tr>
                    <td>002</td>
                    <td>طبق</td>
                    <td>2500</td>
                    <td class="text-danger">-20</td>

                    <td>22-5-2023</td>
                </tr>
                <tr>
                    <td>003</td>
                    <td>كوب</td>
                    <td>2500</td>
                    <td class="text-danger">-15</td>

                    <td>22-5-2023</td>
                </tr>
                <tr>
                    <td>003</td>
                    <td>كوب</td>
                    <td>2500</td>
                    <td class="text-danger">-80</td>
                    <td>22-10-2023</td>
                </tr>
            </tbody>
        </table>
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
