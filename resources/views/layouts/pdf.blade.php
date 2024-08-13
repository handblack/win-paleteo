<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DocumentNo</title>
    
    <style type="text/css">
        body {
            font-family: system-ui, system-ui, sans-serif;
        }

        table {
            border-spacing: 0;
        }

        table td,
        table th,
        p {
            font-size: 13px !important;
        }

        img {
            /*
            border: 3px solid #F1F5F9;
            padding: 6px;
            background-color: #F1F5F9;
            */
        }

        .table-no-border {
            width: 100%;
        }

        .table-no-border .width-50 {
            width: 50%;
        }

        .table-no-border .width-70 {
            width: 70%;
            text-align: left;
        }

        .table-no-border .width-30 {
            width: 30%;
        }

        .margin-top {
            margin-top: 40px;
        }

        .product-table {
            margin-top: 20px;
            width: 100%;
            border-width: 0px;
        }

        .product-table thead th {
            background-color: #60A5FA;
            color: white;
            padding: 5px;
            text-align: left;
            padding: 5px 15px;
        }

        .width-20 {
            width: 20%;
        }

        .width-50 {
            width: 50%;
        }

        .width-25 {
            width: 25%;
        }

        .width-70 {
            width: 70%;
            text-align: right;
        }

        .product-table tbody td {
            background-color: #FFF;
            color: black;
            padding: 3px 10px;
            vertical-align: top;
        }

        .product-table td:last-child,
        .product-table th:last-child {
            text-align: right;
        }

        .product-table tfoot td {
            color: black;
            padding: 3px 10px;
        }

        .footer-div {
            background-color: #F1F5F9;
            margin-top: 100px;
            padding: 3px 10px;
        }


        .border-title {
            border: 1px solid black;
        }

        .border-sign {
            border: 1px solid rgba(0, 0, 0, 0.719);
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        hr {
            height: 1px;
            background-color: #dcdcdc;
            border: 0px;
        }
    </style>
    @stack('style')
</head>

<body>
    @yield('content')
</body>

</html>
