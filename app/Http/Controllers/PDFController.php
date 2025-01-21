<?php

namespace App\Http\Controllers;


use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PDFController extends Controller
{
    public function genPDF(Request $request)
    {
        $data = $request->all();
        $pdf = PDF::loadView('pdf.template', $data);
        $filePath = 'generated_pdf_' . time() . '.pdf';
        $pdf->save(public_path('temporaryPDFs/' . $filePath));
        return response()->json([
            'status' => 'success',
            'message' => 'PDF generated successfully',
            'pdf_url' => url('temporaryPDFs/' . $filePath),
            'delete_url' => url('delete-pdf/' . $filePath)        
        ]);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'PDF generated successfully',
        //     'pdf_url' => url('public/temporaryPDFs/' . $filePath),
        //     'delete_url' => url('delete-pdf/' . $filePath)        
        // ]);
    }


    public function delPDF($filepath){
        $file = public_path('temporaryPDFs/' . $filepath);
        if(file_exists($file)){
            unlink($file);
            return response()->json([
                'status' => 'success',
                'message' => 'PDF deleted successfully'
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'PDF not found'
            ], 404);
        }
    }


    public function sendPDF(Request $request){
        $data = $request->all();
        $pdf = PDF::loadView('pdf.template', $data);
        $filePath = 'generated_pdf_' . time() . '.pdf';
        $pdf->save(public_path('temporaryPDFs/' . $filePath));
        $mail = Mail::to($request->input('data.sendingemail'))->send(new ReportMail(public_path('temporaryPDFs/' . $filePath)));
        unlink(public_path('temporaryPDFs/' . $filePath));

        if ($mail) {
            return response()->json([
                'status' => 'success',
                'message' => 'Email sent successfully with PDF attachment.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email with PDF attachment.'
            ], 500);
        }
    }
}
