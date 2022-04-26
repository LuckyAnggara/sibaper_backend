<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Facades\Storage;
use App\Models\Request as ModelsRequest;
use PhpOffice\PhpWord\TemplateProcessor;
use Barryvdh\DomPDF\Facade\Pdf;

class BuktiController extends Controller
{
    public function generate(Request $request)
    {
        $id = $request->input('id');
        $data = ModelsRequest::with(['user','admin'])->where('id',$id)->first();

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app\public\template\bukti_penerimaan.docx'));
        $tanggal = Carbon::now()->format('d F Y');

        foreach ($data->detail as $key => $detail) 
        {
            $c[] = array('dd'=> $key+ 1,'product_name' =>$detail->product->name, 'jumlah' => $detail->acc_quantity);
        }
        $data->detail = $c;

        $template_document->setValue('tanggal', $tanggal);
        $template_document->setValue('no_ticket', $data->no_ticket);
        $template_document->setValue('nama_admin', $data->admin->name);
        $template_document->setValue('nip_admin', $data->admin->nip);
        $template_document->setValue('nama_penerima', $data->user->name);
        $template_document->setValue('nip_penerima',$data->user->nip);
        $template_document->cloneRowAndSetValues('dd',$data->detail);

        $template_document->saveAs(storage_path('app\public\template\tanda_terima.docx'));
        return Storage::download('public\template\tanda_terima.docx');

    }

    public function buktiPDF(Request $request)
    {
        $id = $request->input('id');
        
        $data = ModelsRequest::with(['user','admin','detail.product'])->where('id',$id)->first();

        $pdf = PDF::loadView('bukti', compact('data'));
        // return view('bukti');

        return $pdf->download('Bukti '.$data->no_ticket.'.pdf');
    }

}
