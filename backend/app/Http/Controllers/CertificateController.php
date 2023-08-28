<?php

namespace App\Http\Controllers;

use App\Http\Requests\Certificate\AddCertificate;
use App\Models\Certificate;
use Illuminate\Http\Request;


class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Certificate::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCertificate $request)
    {
        $data = $request->all();
        $request->validated();
        $certificate = new Certificate();

        $certificate->fill($data);

        $certificate->save();
        return response()->json(['User' => $certificate]);


    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();
        return response('Certificate deleted successfully');
    }
}