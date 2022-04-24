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
    <h2 class="text-center m-0 p-0">SIAP BAPER</h2>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Nomor Ticket - <span class="gray-color">{{$data->no_ticket}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Tanggal - <span class="gray-color">{{date('d-m-Y', strtotime($data->created_at)) }}</span></p>
    </div>   
    <div style="clear: both;"></div>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10 mb-40">
        <p class="m-0 pt-5 text-bold w-100">Nama - <span class="gray-color">{{$data->user->name}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">NIP - <span class="gray-color">{{$data->user->nip}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Bagian - <span class="gray-color">{{$data->user->bagian}}</span></p>
    </div>   
    <div style="clear: both;"></div>
</div>

<div class="table-section bill-tbl w-100 mt-10">
    <p class="m-0 pt-5 text-bold w-100">Daftar Permintaan Persediaan</p>

    <table class="table w-100 mt-10">
        <tr>
            <th class="w-10">No</th>
            <th class="w-50">Nama</th>
            <th class="w-40">Qty Permintaan</th>
            @if ($data->status == 'ACCEPT')
                <th class="w-40">Qty Di Setujui</th>
            @endif
        </tr>
        @foreach ($data->detail as $item)
        <tr align="center">
            <td>{{$loop->index+1}}</td>
            <td>{{$item->product->name}}</td>
            <td>{{$item->quantity}}</td>

            @if ($data->status == 'ACCEPT')
                <td>{{$item->acc_quantity}}</td>
            @endif
        </tr>
        @endforeach
        <tr>
            @if ($data->status == 'ACCEPT')
            <td colspan="4">
            @endif
            @if ($data->status == 'PENDING' || $data->status == 'REJECT')
            <td colspan="3">
            @endif
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Status</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p><b>{{$data->status}}</b></p>
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
</div>
</html>