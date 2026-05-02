<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::query()
            ->latest()
            ->paginate($request->integer('per_page', 10));

        return ContactResource::collection($contacts);
    }

    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string'],
        ]);

        $contact = Contact::create($data);

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['sometimes', 'required', 'string'],
        ]);

        $contact->update($data);

        return new ContactResource($contact);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'data' => [
                'message' => 'Contact deleted.',
            ],
        ]);
    }
}
