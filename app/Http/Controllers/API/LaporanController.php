<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Mutation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

    public function mutation(Request $request)
    {
        $cast = 'cast((@saldo:= @saldo) AS double) AS saldo';
        // $cast = 'cast((@saldo:= @saldo+debit-kredit) AS double) AS saldo';
        DB::statement(DB::raw('set @saldo=0'));
        $mutation = DB::table('mutations')->selectRaw('id,updated_at, product_id, debit,kredit,keterangan,created_at,'.$cast);
        $mutation = $mutation->where('product_id', $request->id)->orderBy('created_at', 'ASC')->orderBy('id', 'ASC')->get();
        $saldo = 0;
        $key = 0;

        foreach ($mutation as $key => $value) {
            $key++;

            $saldo = $saldo + $value->debit - $value->kredit;
            $value->saldo = $saldo;
            $value->key = $key;
        }

        $mutation = collect($mutation)->sortBy('key')->reverse()->toArray();


        // return $data;
        // return response()->json(['data'=>$dataProduct]);
        // $data = ModelsRequest::with(['user','admin','detail.product'])->where('id',$id)->first();

        $pdf = PDF::loadView('laporan-mutation',['data'=>$mutation, 'dataPersediaan' => Product::find($request->id)]);
        // return view('laporan-mutation',['data'=>$mutation, 'dataPersediaan' => Product::find($request->id)]);

        return $pdf->download('laporan mutasi.pdf');
    }

  
}
