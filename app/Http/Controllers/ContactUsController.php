<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ContactusRequest;
use App\Models\Contact;


class ContactUsController extends Controller
{
    public function store(ContactusRequest $request)
    {
        $data = $request->validated();

        // هنا تقدر تخزن الداتا
        Contact::create($data);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $data
        ]);
    }
}
