<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Praticien\Decision\Repo\DecisionInterface;
use App\Praticien\Decision\Worker\DecisionWorkerInterface;

class NewsletterController extends Controller
{
    protected $decision;
    protected $worker;

    public function __construct(DecisionInterface $decision, DecisionWorkerInterface $worker)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $this->decision = $decision;
        $this->worker   = $worker;
    }

    public function index($date = null)
    {
        $date  = $date ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::now();

        $ad = \App\Praticien\Bger\Entities\Ad::where('start_at','<=',$date->toDateString())->where('end_at','>=',$date->toDateString())->first();

        $dates = weekRange($date->toDateString());
        $start = $dates->first();
        $end   = $dates->last();

        $decisions  = $this->decision->getWeekPublished($dates->toArray());
        $newsletter = view('emails.newsletter')->with(['decisions' => $decisions, 'date' => $date, 'week' => frontendDatesNewsletter($start,$end),'ad' => $ad])->render();

        return view('backend.newsletter.index')->with(['newsletter' => $newsletter, 'week' => frontendDatesNewsletter($start,$end)]);
    }

}
