<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function saveContact(Request $request) {
        
        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|max:255',
        ]);

        if(!$validated) {
            return response()->json([
                'message' => 'All fields are required'
            ], 400);
        } 

        $new_contact = array(
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'image' => $request->image ? $request->image : "",
            'user_id' =>  $request->user()->id
        );

        $contact = Contact::create($new_contact);

        if(!$contact) {
            return response()->json([
                'message' => 'save error'], 400
            );
        } 
        
        return response()->json([
            'contact' => $contact,
            'message' => 'Successfully created contact'], 200
        );
        
    }

    public function updateContact(Request $request) {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|max:255',
        ]);

        if(!$validated) {
            return response()->json([
                'message' => 'update error'
            ], 400);
        } 

        $contact = Contact::find($request->id);

        if($contact) {
            $contact->name = $request->name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->address = $request->address;
            $contact->save();

            return response()->json([
                'message' => 'Successfully updated contact'], 200
            );
        } else {
            return response()->json([
                'message' => 'update error'
            ], 400);
        }   
    }

    public function getContacts(Request $request) {
        return response()->json([
            'contacts' => Contact::where('user_id', $request->user()->id)->get(),
        ], 200);
    }

    public function deleteContact(Request $request) {

        $contact = Contact::where('id',$request->id)->delete();

        if(!$contact) {
            return response()->json([
                'message' => 'delete contact error'], 400
            );
        } 

        return response()->json([
            'message' => 'Successfully deleted contact'], 200
        );
    }
}