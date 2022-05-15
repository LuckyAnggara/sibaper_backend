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
    .px-5{
        padding-left: 5px;
        padding-right: 5px;
    },
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
    .w-5{
        width:5%;   
    }
    .w-15{
        width:15%;   
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
    .center {
        margin: auto;
        width: 80%;
        padding: 10px;
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
    <h2 class="text-center m-0 p-0">Laporan Mutasi</h2>
</div>
{{-- <div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Tanggal : <span class="gray-color">{{$data['startDate']}}</span> s.d <span class="gray-color">{{$data['endDate']}}</span></p>
    </div>   
    <div style="clear: both;"></div>
</div> --}}


<div class="table-section bill-tbl w-85 mt-10 center" >
    <p class="m-0 pt-5">Data Mutasi <span class=" text-bold w-85">{{$dataPersediaan->name}}</span></span>

    <table class="table w-100 mt-10 ">
        <tr>
            <th class="w-5">No</th>
            <th class="w-10">Tanggal Transaksi</th>
            <th class="w-40">No Bukti / Keterangan</th>
            <th class="w-15">Masuk</th>
            <th class="w-15">Keluar</th>
            <th class="w-15">Saldo Akhir</th>
         
        </tr>
        @foreach ($data as $item)
        <tr align="center">
            <td>{{$loop->index+1}}</td>
            <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
            <td align="left">{{$item->keterangan}}</td>
            <td>{{$item->debit}}</td>
            <td>{{$item->kredit}}</td>
            <td>{{$item->saldo}}</td>
        </tr>
        @endforeach

    </table>
</div>
</html>