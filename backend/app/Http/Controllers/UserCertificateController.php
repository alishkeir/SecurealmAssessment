<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\UserCertificates;


class UserCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        // if (!($request->id))
        //     return response()->json(['error' => 'No User ID provided'], 400);


        $certificates = UserCertificates::where('user_id', $request->id)->get();

        foreach ($certificates as $certificate) {
            $certificate->name = Certificate::find($certificate->certificate_id)->name;
        }

        return response()->json(['certificates' => $certificates]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        try {
            $data = $request->all();

            $user_certificate = new UserCertificates();

            $user_certificate->fill($data);

            $user_certificate->save();


            $certificate = Certificate::where('id', $request->certificate_id)->first();

            $certificate->number_of_users = $certificate->number_of_users + 1;

            $certificate->save();



        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);

        } finally {
            return response()->json(['certificates' => $user_certificate]);

        }


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        try {


            $user_certificate = UserCertificates::findOrFail($request->id);


            $certificate = Certificate::where('id', $user_certificate['certificate_id'])->first();


            $certificate->number_of_users = $certificate->number_of_users - 1;

            $user_certificate->delete();

            $certificate->save();

        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);

        } finally {
            return response('User certificate deleted successfully');

        }


    }
}