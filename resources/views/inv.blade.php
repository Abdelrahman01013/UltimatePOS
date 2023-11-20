<!DOCTYPE html>
<html>

<head>
    <title>Bootstrap Table with Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h2 class="text-center"> جرد فرع القاهره</h2>
        <input class="form-control" id="myInput" type="text" placeholder="ادخل الاسم او الباركود">
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>الباركود</th>
                    <th>اسم المنتج</th>
                    <th>الكميه المتاحه</th>
                    {{-- <th>الكميه الفعليه</th> --}}

                    <th> حاله الجرد</th>
                    <th>تاريخ الجرد</th>
                </tr>
            </thead>
            <tbody id="myTable">
                <tr>
                    <td>002</td>
                    <td>طبق</td>
                    <td>2500</td>

                    <td class="text-success">تم الجرد</td>
                    <td>22-5-2023</td>
                </tr>


            </tbody>
        </table>
        <div class="text-center">
            <td><input type="number" placeholder="الكميه الفعليه"> </td>

            <br>
            <br>
            <td><input type="number" placeholder="الفارق" readonly> </td>

            <br>
            <br>
            <button class="btn btn-putline-primary"> الرجوع الي عدم الجرد</button>

        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <thead>
                    <tr>
                        <th>الباركود</th>
                        <th>اسم المنتج</th>
                        <th>الكميه المتاحه</th>
                        {{-- <th>الكميه الفعليه</th> --}}

                        <th> حاله الجرد</th>
                        <th>تاريخ الجرد</th>
                    </tr>
                </thead>
            <tbody id="myTable">

                <tr>
                    <td>003</td>
                    <td>طبق</td>
                    <td>300</td>

                    <td class="text-danger">لم يتم الجرد</td>
                    <td>------</td>
                </tr>

            </tbody>
        </table>
        <div class="text-center">
            <td><input type="number" placeholder="الكميه الفعليه"> </td>

            <br>
            <br>
            <td><input type="number" placeholder="الفارق" readonly value="-5"></td>

            <br>
            <br>
            <button class="btn btn-putline-primary"> لم يتم الجرد</button>

        </div>


    </div>

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

</body>

</html>
