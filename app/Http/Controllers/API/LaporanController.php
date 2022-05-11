<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mutation;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{

    
    public function harian(Request $request)
    {
        $newYear = Carbon::createFromFormat('d/m/Y', '01/01/'.date('Y'));
        $startDate = $request->input('start-date');
        $endDate = $request->input('end-date');

        $data = null;

        // return response()->json([
        //     'start-date'=>$startDate,
        //     'end-date'=>$endDate,
        // ]);

        $dataProduct = Product::all();

        foreach ($dataProduct as $key => $value) {
            $saldo['saldo_awal'] = Mutation::where('product_id', $value->id)
            ->whereBetween('created_at', [$newYear, $startDate])
            ->sum('debit');
            $saldo['masuk'] = Mutation::where('product_id', $value->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('debit');
            $saldo['keluar'] = Mutation::where('product_id', $value->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('kredit');
            $saldo['saldo_akhir'] = $saldo['saldo_awal'] + $saldo['masuk'] - $saldo['keluar'];

            $value['data'] = $saldo;
        }
        
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;
        $data['detail'] = $dataProduct;

        // return $data;
        // return response()->json(['data'=>$dataProduct]);
        // $data = ModelsRequest::with(['user','admin','detail.product'])->where('id',$id)->first();

        $pdf = PDF::loadView('laporan',['data'=>$data]);
        // return view('laporan',['data'=>$data]);

        return $pdf->download('laporan persediaan.pdf');
    }

  
}
