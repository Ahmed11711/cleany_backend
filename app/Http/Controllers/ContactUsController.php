<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ContactusRequest;
use App\Models\Contact;
use App\Models\Contactus;

class ContactUsController extends Controller
{

    // $contactus = Contactus::get();

    // return response()->json([
    //     'success' => true,
    //     'data'    => $contactus
    // ], 200);

    public function index()
    {
        $contactus = Contactus::all()->map(function ($item) {
            return [
                'type'  => $item->key,
                'value' => $item->value,
            ];
        });

        return response()->json($contactus);
    }
}
