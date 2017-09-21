<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dream;
use App\User;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class BmiController extends Controller
{
    protected $dreamLeadMail = [
        'dani.lesmiadi@gmail.com', 'negeriparapemimpi50@gmail.com', 'husnul.hakim80@gmail.com'
    ];

    public function __construct()
    {
        $this->storeDreamLead();
    }

    public function index()
    {
        return view('bmi.index');
    }

    private function storeDreamLead()
    {
        if (Cache::has('dreamLead') == false) {
            $dreamLead = [];
            $email = $this->dreamLeadMail;
            for ($i=0; $i < count($email); $i++) {
                $user = User::where('email', $email[$i])->first();
                if (count($user) == 1) {
                    array_push($dreamLead, $user->dream->toArray());
                }
            }
            $expiresAt = Carbon::now()->addDays(1);
            Cache::put('dreamLead', $dreamLead, $expiresAt);
        }

    }
}
