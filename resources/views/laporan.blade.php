<!DOCTYPE html>
<html>
<head>
    <title>SIAP BAPER</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .mb-40{
        margin-bottom:40px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-40{
        width:40%;   
    }
    .w-10{
        width:10%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
    <h2 class="text-center m-0 p-0">Laporan Persediaan</h2>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Tanggal : <span class="gray-color">{{$data['startDate']}}</span> s.d <span class="gray-color">{{$data['endDate']}}</span></p>
    </div>   
    <div style="clear: both;"></div>
</div>


<div class="table-section bill-tbl w-100 mt-10">
    <p class="m-0 pt-5 text-bold w-100">Data Persediaan</p>

    <table class="table w-100 mt-10">
        <tr>
            <th class="w-10">No</th>
            <th class="w-40">Nama</th>
            <th class="w-10">Saldo Awal</th>
            <th class="w-10">Masuk</th>
            <th class="w-10">Keluar</th>
            <th class="w-10">Saldo Akhir</th>
         
        </tr>
        @foreach ($data['detail'] as $item)
        <tr align="center">
            <td>{{$loop->index+1}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->data['saldo_awal']}}</td>
            <td>{{$item->data['masuk']}}</td>
            <td>{{$item->data['keluar']}}</td>
            <td>{{$item->data['saldo_akhir']}}</td>

        </tr>
        @endforeach

    </table>
</div>
</html>