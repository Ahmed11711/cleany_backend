<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ContactusRequest;
use App\Models\Contact;
use App\Models\Contactus;

class ContactUsController extends Controller
{
    public function index()
    {
        // 1. Fetch the data
        return  $contactus = Contactus::all();

        return response()->json([
            'success' => true,
            'data'    => $contactus
        ], 200);
    }
}
