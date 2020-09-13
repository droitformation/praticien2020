<?php namespace App\Http\Controllers;

use App\Praticien\Decision\Repo\DecisionInterface;
use App\Praticien\Decision\Worker\DecisionWorkerInterface;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    protected $decision;
    protected $worker;

    public function __construct(DecisionInterface $decision, DecisionWorkerInterface $worker)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $this->decision = $decision;
        $this->worker = $worker;
    }

    public function preview($date = null)
    {
        $date  = $date ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::now();

        $ad = \App\Praticien\Bger\Entities\Ad::where('start_at','<=',$date->toDateString())->where('end_at','>=',$date->toDateString())->first();

        $dates = weekRange($date->toDateString());
        $start = $dates->first();
        $end   = $dates->last();

        $decisions = $this->decision->getWeekPublished($dates->toArray());

        return view('emails.newsletter')->with([
            'decisions' => $decisions,
            'date'   => $date,
            'week'   => frontendDatesNewsletter($start,$end),
            'ad'     => $ad
            // 'email'  => $email ?? '' for sending unsubscribe
        ]);
    }

    public function unsubscribe($email)
    {

    }
}
