<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\Models\Member;

class RemoveAccountController extends Controller
{

    public function index()
    {
        return view('remove-account');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|max:255,email',
            'password' => 'required'
        ]);
        // var_dump($validateData);die();
        $response = Http::withBasicAuth('keys', 'secret')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic some_base64_encrypted_key'
            ])->post($this->getUrl('request-remove-account'), [
                'email' => $validateData['email'],
                'password' => $validateData['password'],
            ]);

        if ($response->successful()) {
            $jsonData = $response->json();
            if ($jsonData['success']) {
                return back()->with('success', $jsonData['message']);
            } else {
                return back()->with('error', $jsonData['message']);
            }
        } elseif ($response->failed()) {
            return back()->with('error', 'Failed.');
        }
    }

    private function getUrl($key = NULL)
    {
        $server = env('APP_ENV');
        $url = '';
        if ($server == 'local') {
            $url = 'http://localhost:8080/api/' . $key;
        } elseif ($server == 'trial') {
            $url = 'https://dev-fwapi.fitnessworks.co.id/api/' . $key;
        } elseif ($server == 'production') {
            $url = 'https://fwapi.fitnessworks.co.id/api/' . $key;
        }

        return $url;
    }
}
