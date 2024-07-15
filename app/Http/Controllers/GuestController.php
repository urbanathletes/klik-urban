<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Log;


class GuestController extends Controller
{
    public function index()
    {
        Log::info('GuestController@index called');
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

        return view('guest.index', compact('club', 'withClub'));

    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255', 'phone' => 'required|max:255|unique:ua_mst_leads,phone',
            'email' => 'required|max:255|unique:ua_mst_leads,email', 'club_id' => 'required',
            // 'checkbox' => 'accepted', 
            // 'time_call' => 'required'
        ], [
            // 'time_call.required' => 'Waktu dihubungi harus dipilih.'
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
            $validateData['type_promo'] = 'free trial';
        }
        $validateData['createdAt'] = date('Y-m-d H:i:s');
        $validateData['updatedAt'] = date('Y-m-d H:i:s');


        $foundMember = DB::table('ua_mst_members')->whereRaw('email = "' . $validateData['email'] . '"')->whereRaw('deletedAt is null')->first();
        if (!isset($foundMember)) {
            $foundLead = DB::table('ua_mst_leads')->whereRaw('email = "' . $validateData['email'] . '"')->whereRaw('deletedAt is null')->first();
            if (!isset($foundLead)) {
                $modelLead = Lead::create($validateData);
            } else {
                $modelLead = $foundLead;
            }
            $leadsId = $modelLead->id;
        } else {
            $leadsId = $foundMember->leads_id;
            $foundMemberPackage = DB::table('ua_mst_members_packages')
                ->whereRaw('member_id = ' . $foundMember->id)
                ->whereRaw('package_membership_expired_date >= date_sub(now(), interval 6 month)')
                ->whereRaw('deletedAt is null')
                ->whereRaw('package_membership_id is not null')
                ->first();
            if (isset($foundMemberPackage)) {
                return back()->with('error', 'Maaf anda tidak memenuhi syarat & ketentuan untuk membeli promo 99k.');
            }

        $response = Http::withBasicAuth('keys', 'secret')
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic some_base64_encrypted_key'
            ])
            ->post($this->getUrl('leads'), [
                'orgId' => env('ORG_ID'),
                'clubId' => $validateData['club_id'],
                'leadId' => $leadsId,
                'email' => $validateData['email'],
                'phone' => $validateData['phone'],
                'name' => $validateData['name']
            ]);

        $jsonData = $response->json();
        $data = isset($jsonData['data']) ? $jsonData['data'] : [];

        // get employee (sales / fitness consultant)
        $response = Http::get($this->getUrl('leads/generate-qr?orgId=' . env('ORG_ID') . '&clubId=' . $validateData['club_id']));

        // return back()->with('success', 'Register Success');
        return redirect()->back()->with('message', 'IT WORKS!');
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
