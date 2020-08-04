<!DOCTYPE html>
<html>

<head>
    <title>พิมพ์ใบจอง</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            font-size: 16px;
            line-height: 30px;
            background: rgb(204, 204, 204);
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            padding: 60px;
        }

        page[size="A4"] {
            width: 21cm;
            height: 27cm;
        }

        page[size="A4"][layout="landscape"] {
            width: 29.7cm;
            height: 21cm;
        }

        page[size="A3"] {
            width: 29.7cm;
            height: 42cm;
        }

        page[size="A3"][layout="landscape"] {
            width: 42cm;
            height: 29.7cm;
        }

        page[size="A5"] {
            width: 14.8cm;
            height: 21cm;
        }

        page[size="A5"][layout="landscape"] {
            width: 21cm;
            height: 14.8cm;
        }

        table {
            table-layout: auto;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            font-weight: normal;
        }

        th {
            width: 1px;
        }

        .t22 {
            font-size: 22px !important;
        }

        .text-center {
            text-align: center;
            vertical-align: middle;
        }

        .text-right{
            text-align: right;
            vertical-align: middle;
        }

        .headline {
            border-bottom: 2px solid black;
            color: white;
            margin: 10px 0;
        }

        .h-bg {
            background-color: #5F497A;
        }

        .h-bg2 {
            background-color: #DED7C4;
            border: 2px solid #6B7278;
            padding: 5px;
        }

        .l-bg {
            background-color: #E5DFEC;
        }

        .square {
            height: 15px;
            width: 15px;
            background-color: #fff;
            border:1px solid #000;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }

        @media print {
            body,
            page {
                padding: 0;
                margin: 0;
                width: 0;
                height: 0;
                -webkit-box-shadow: none;
                -moz-box-shadow:    none;
                box-shadow:         none;
            }
        }
    </style>
</head>

<body>
    <page size="A4">
        <div style="padding:30px 60px;">
        @yield('content')
        </div>
    </page>
    @stack('js')
</body>

</html>
