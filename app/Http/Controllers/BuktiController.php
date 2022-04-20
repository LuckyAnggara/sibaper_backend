<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class BuktiController extends Controller
{
    public function generate()
    {

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('app\public\template\bukti_penerimaan.docx'));


        $nama_admin = 'Lucky';
        $nip_admin = '123123123';
        $nama_penerima = 'JOKO MARTANTO';
        $nip_penerima = '1999999999';

        $template_document->setValue('nama_admin', $nama_admin);
        $template_document->setValue('nip_admin', $nip_admin);
        $template_document->setValue('nama_penerima', $nama_penerima);
        $template_document->setValue('nip_penerima', $nip_penerima);

        $template_document->saveAs(storage_path('app\public\template\spd.docx'));
        return Storage::disk('public')->download('spd\spd.docx');

    }

}
