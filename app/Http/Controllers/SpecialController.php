<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\Models\Lead;

class SpecialController extends Controller
{
    //
    public function index()
    {
        $clubId = "";
        $withClub = false;
        if (isset($_GET['club'])) {
            $foundClub = DB::table('ua_mst_clubs')->whereRaw('id = ' . $_GET['club'])->whereRaw('org_id = 13')->whereRaw('deletedAt is null')->first();
            if (isset($foundClub)) {
                $club = DB::table('ua_mst_clubs')->whereRaw('id = ' . $_GET['club'])->whereRaw('org_id = 13')->whereRaw('deletedAt is null and is_deleted = 0')->get();
                $withClub = true;
            } else {
                $club = DB::table('ua_mst_clubs')->whereRaw('org_id = 13')->whereRaw('deletedAt is null and is_deleted = 0')->get();
            }
        } else {
            $club = DB::table('ua_mst_clubs')->whereRaw('org_id = 13')->whereRaw('deletedAt is null and is_deleted = 0')->get();
        }

        return view('special-deal', compact('club', 'withClub'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:255|unique:ua_mst_leads,phone',
            'email' => 'required|max:255|unique:ua_mst_leads,email',
            'club_id' => 'required',
            'checkbox' => 'accepted',
            'time_call' => 'required'
        ], [
            'time_call.required' => 'Waktu dihubungi harus dipilih.'
        ]);

        $validateData['org_id'] = env('ORG_ID');
        if (isset($_GET['source'])) {
            $validateData['source'] = $_GET['source'];
            $validateData['source_sub'] = isset($_GET['sub']) ? $_GET['sub'] : null;
        } else {
            $validateData['source'] = 'website';
        }
        if (isset($_GET['type'])) {
            $validateData['type_promo'] = $_GET['type'];
        } else {
            $validateData['type_promo'] = 'special deal';
        }
        $validateData['createdAt'] = date('Y-m-d H:i:s');
        $validateData['updatedAt'] = date('Y-m-d H:i:s');

        $modelLead = Lead::create($validateData);

        return back()->with('success', 'Register Successfully.');
    }
}
