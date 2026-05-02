<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Mail\ContactMessageReceived;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        // send notification email to admin
        try {
            Mail::to('cahyoashofar@gmail.com')->queue(new ContactMessageReceived($contact));
        } catch (\Exception $e) {
            // fail silently; still return created resource
        }

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(201);
    }
}
