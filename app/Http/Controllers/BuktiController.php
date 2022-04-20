<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpOffice\PhpWord\Settings;
use Illuminate\Support\Facades\Storage;
use App\Models\Request as ModelsRequest;
use PhpOffice\PhpWord\TemplateProcessor;

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
            $c[] = array('dd'=> $key++,'product_name' =>$detail->product->name, 'jumlah' => $detail->quantity);
        }
        $data->detail = $c;

        $template_document->setValue('tanggal', $tanggal);
        $template_document->setValue('nama_admin', $data->admin->name);
        $template_document->setValue('nip_admin', $data->admin->nip);
        $template_document->setValue('nama_penerima', $data->user->name);
        $template_document->setValue('nip_penerima',$data->user->nip);
        $template_document->cloneRowAndSetValues('dd',$data->detail);

        $template_document->saveAs(storage_path('app\public\template\tanda_terima.docx'));
        return Storage::download('public\template\tanda_terima.docx');

    }


    public function convertWordToPDF()
    {
            /* Set the PDF Engine Renderer Path */
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
         
        //Load word file
        $Content = \PhpOffice\PhpWord\IOFactory::load(storage_path('app\public\template\spd.docx')); 
 
        //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
        $PDFWriter->save(storage_path('app\public\template\new_spd.pdf')); 
        return response()->json('File has been successfully converted') ;
    }

}
