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
        <h2 class="text-center">مخزن فرع القاهره</h2>
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>الباركود</th>
                    <th>اسم المنتج</th>
                    <th>الكميه المتاحه</th>
                    <th>الجرد</th>
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
                <tr>
                    <td>003</td>
                    <td>كوب</td>
                    <td>2500</td>
                    <td class="text-success">تم الجرد</td>
                    <td>22-5-2023</td>
                </tr>
                <tr>
                    <td>003</td>
                    <td>كوب</td>
                    <td>2500</td>
                    <td class="text-danger">لم يتم الجرد</td>
                    <td>-----</td>
                </tr>
            </tbody>
        </table>
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
