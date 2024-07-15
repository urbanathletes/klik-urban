<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Lead;
use App\Models\LeadAnswer;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\PackageMembership;
use Illuminate\Support\Facades\Redirect;

class RefferalController extends Controller
{

    public function index()
    {
        $response = Http::get($this->getUrl('select/club?orgId=' . env('ORG_ID')));
        $clubData = $response->json();
        $clubList = [];

        if (count($clubData['data']) > 0) {
            foreach ($clubData['data'] as $row => $club) {
                array_push($clubList, $club);
            }
        }

        $refferalCode = (isset($_GET['refferal_code']) ? $_GET['refferal_code'] : NULL);

        return view('refferal.guest', compact('clubList', 'refferalCode'));
    }

    public function saveGuest(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255', 'age' => 'required|max:255', 'phone' => 'required|max:255', 'email' => 'required|max:255',
            'instagram' => 'max:255', 'work' => 'max:255', 'company_name' => 'max:255', 'club_id' => 'required', 'refferal_code' => 'required'
        ], [
            'club_id.required' => 'The club is required.', 'refferal_code.required' => 'Refferal code is required.'
        ]);
        $validateData['org_id'] = env('ORG_ID');
        $validateData['source'] = 'website/google';
        $validateData['createdAt'] = date('Y-m-d H:i:s');
        $validateData['updatedAt'] = date('Y-m-d H:i:s');

        $modelCurrentLead = Lead::where('email', $validateData['email'])->first();
        if (!isset($modelCurrentLead)) {
            $modelLead = Lead::create($validateData);
        } else {
            $modelLead = $modelCurrentLead;
            if ($modelLead) {
                $modelLead->refferal_code = $validateData['refferal_code'];
                $modelLead->save();
            }
        }

        if ($modelLead) {
            $leadId = $modelLead->id;
            $clubId = $modelLead->club_id;
            $_SESSION['lead_id'] = $leadId;

            if ($request->guest_profile == 1) {
                return $this->question($leadId);
                //return Redirect::to('question/'.$leadId);
            } else {
                return $this->unlockMembership($leadId);
            }
        }
    }

    public function question($leadId = NULL)
    {
        if (strlen($leadId) == 0) {
            return view('refferal.guest');
        } else {
            $response = Http::get($this->getUrl('presales/question'));
            $jsonData = $response->json();
            $question = isset($jsonData['data']['rows']) ? $jsonData['data']['rows'] : [];
            $questionList = [];
            if (count($question) > 0) {
                foreach ($question as $row => $value) {
                    $questionList[$value['page']][] = $value;
                }
            }

            //print("<pre>" . print_r($questionList, true) . "</pre>");

            return view('refferal.question', compact('leadId', 'questionList'));
        }
    }

    public function unlockMembership($leadId = NULL)
    {
        $request = array_merge($_POST);
        $totalValue = 0;
        if (isset($request['lead_id'])) {
            $leadId = $request['lead_id'];
            $existAnswerModel = LeadAnswer::where('lead_id', $leadId)->first();
            $questionAnswer = [];
            if (!isset($existAnswerModel)) {
                end($request);
                $lastQuestionKey = key($request);
                $lastQuestionArr = explode('_', $lastQuestionKey);
                if ($lastQuestionArr[0] == 'question') {
                    for ($x = 1; $x <= $lastQuestionArr[1]; $x++) {
                        if (isset($request['question_' . $x])) {
                            if (is_array($request['question_' . $x])) {
                                $ind = 0;
                                foreach ($request['question_' . $x] as $r => $v) {
                                    $questionAnswer[$x][$ind]['question_id'] = $x;
                                    $questionAnswer[$x][$ind]['answer_id'] = $v;
                                    $ind++;
                                }
                            } else {
                                $ind = 0;
                                $questionAnswer[$x][$ind]['question_id'] = $x;
                                $questionAnswer[$x][$ind]['answer_id'] = $request['question_' . $x];
                            }
                        }
                    }
                }
            }

            if (count($questionAnswer) > 0 && !isset($existAnswerModel)) {
                foreach ($questionAnswer as $row => $value) {
                    foreach ($value as $r => $v) {
                        $answerLeadModel = new LeadAnswer();
                        $answerLeadModel->lead_id = $leadId;
                        $answerLeadModel->question_id = $v['question_id'];
                        $answerLeadModel->answer_id = $v['answer_id'];
                        $answerLeadModel->createdAt = date('Y-m-d H:i:s');
                        $answerLeadModel->save();

                        $answerModel = QuestionAnswer::where('id', $v['answer_id'])->first();
                        if (isset($answerModel)) {
                            $totalValue += $answerModel->value;
                        }
                    }
                }
            }
        }

        $modelLead = Lead::where('id', $leadId)->first();
        $clubId = $modelLead->club_id;

        $allShift = DB::table('ua_mst_shifts')->get();
        $packageAll = DB::table('ua_package_memberships as a')
            ->selectRaw("a.*, c.name as shift_name, c.description as shift_start, '' as shift_end, if(" . $totalValue . " >= min_value and " . $totalValue . " <= max_value, 'yes', 'no') as recommend")
            ->join('ua_mst_membership_promos as b', 'b.id', '=', 'a.membership_promo_id')
            ->join('ua_mst_shifts as c', 'c.id', '=', 'a.shift_id')
            ->where('b.name', '=', 'Presales')
            ->whereRaw('a.club_id  = ' . $modelLead->club_id)
            ->whereRaw('a.deletedAt is null and a.is_active = 1')
            ->orderBy('a.membership_categories_id', 'desc')
            ->orderBy('a.membership_payment_id', 'desc')
            ->orderBy('a.month', 'desc')
            ->orderBy('a.price', 'asc')
            ->get();
        $packageTrainer = DB::table('ua_package_trainers as a')->whereRaw('a.club_id  = ' . $modelLead->club_id)->whereRaw('a.deletedAt is null')->get();

        //print("<pre>" . print_r($packageRecommend, true) . "</pre>");

        return view('refferal.package_recommend', compact('leadId', 'packageAll', 'allShift', 'packageTrainer', 'clubId'));
    }

    public function choosePackage(Request $request)
    {
        if (isset($_POST['lead_id']) && isset($_POST['package_membership_id']) && isset($_POST['club_id'])) {
            $leadId = $_POST['lead_id'];
            $clubId = $_POST['club_id'];
            $packageMembership = DB::table('ua_package_memberships as a')
                ->selectRaw('a.*, c.name as shift_name')
                ->join('ua_mst_shifts as c', 'c.id', '=', 'a.shift_id')
                ->where('a.id', '=', $_POST['package_membership_id'])
                ->first();
            $packageTrainer = [];
            if (isset($_POST['package_trainer_id'])) {
                $packageTrainer = DB::table('ua_package_trainers')->where('id', '=', $_POST['package_trainer_id'])->first();
            }

            $lead = DB::table('ua_mst_leads')->where('id', '=', $_POST['lead_id'])->first();
            $response = Http::withBasicAuth('keys', 'secret')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic some_base64_encrypted_key'
                ])
                ->post($this->getUrl('checkout-presale'), [
                    'orgId' => env('ORG_ID'),
                    'clubId' => $_POST['club_id'],
                    'packageMembershipId' => $_POST['package_membership_id'],
                    'packageTrainerId' => $_POST['package_trainer_id'],
                    'leadId' => $_POST['lead_id'],
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'name' => $lead->name
                ]);

            $jsonData = $response->json();
            $data = isset($jsonData['data']) ? $jsonData['data'] : [];

            //print("<pre>" . print_r($jsonData, true) . "</pre>");die();

            // get employee (sales / fitness consultant)
            $response = Http::get($this->getUrl('presales/sales-employee?orgId=' . env('ORG_ID') . '&clubId=' . $clubId));
            $salesData = $response->json();
            $salesList = [];

            if (count($salesData['data']) > 0) {
                foreach ($salesData['data'] as $row => $sales) {
                    if (strtolower($sales['department']['name']) == 'sales') {
                        array_push($salesList, $sales);
                    }
                }
            }

            return view('refferal.checkout', compact('packageMembership', 'packageTrainer', 'leadId', 'data', 'salesList', 'clubId'));
        }
    }

    public function order(Request $request)
    {
        if (isset($_POST['lead_id']) && isset($_POST['package_membership_id']) && isset($_POST['checkout_id']) && isset($_POST['club_id'])) {
            $lead = DB::table('ua_mst_leads')->where('id', '=', $_POST['lead_id'])->first();

            $response = Http::withBasicAuth('keys', 'secret')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic some_base64_encrypted_key'
                ])
                ->post($this->getUrl('presales'), [
                    'orgId' => env('ORG_ID'),
                    'clubId' => $_POST['club_id'],
                    'checkoutId' => $_POST['checkout_id'],
                    'leadId' => $_POST['lead_id'],
                    'packageMembershipId' => $_POST['package_membership_id'],
                    'packageTrainerId' => $_POST['package_trainer_id'],
                    'email' => $lead->email,
                    'phone' => $lead->phone,
                    'name' => $lead->name
                ]);

            $jsonData = $response->json();
            $data = isset($jsonData['data']) ? $jsonData['data'] : [];

            //print("<pre>" . print_r($jsonData, true) . "</pre>");die();

            if ($response->successful()) {
                $url = $data['xendit_invoice_url'];
                return view('refferal.order', compact('url'));
            } elseif ($response->failed()) {
                die('failed payment');
            }
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
