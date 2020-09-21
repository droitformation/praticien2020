<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Praticien\Decision\Repo\DecisionInterface;
use App\Praticien\Decision\Worker\DecisionWorkerInterface;
use App\Praticien\Newsletter\Repo\AnnonceInterface;

class NewsletterController extends Controller
{
    protected $decision;
    protected $worker;
    protected $annonce;

    public function __construct(DecisionInterface $decision, DecisionWorkerInterface $worker, AnnonceInterface $annonce)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $this->decision = $decision;
        $this->worker   = $worker;
        $this->annonce  = $annonce;
    }

    public function index($date = null)
    {
        $monday = \Carbon\Carbon::today()->isMonday() ? \Carbon\Carbon::today()->subWeek() : \Carbon\Carbon::today()->firstWeekDay();
        $date = $date ? \Carbon\Carbon::parse($date) : $monday;

        $annonce = $this->annonce->active($date);

        $dates = weekRange($date->toDateString());

        $start = $dates->first();
        $end   = $dates->last();

        $decisions  = $this->decision->getWeekPublished($dates->toArray());
        $newsletter = view('emails.newsletter')->with(['decisions' => $decisions, 'date' => $date, 'week' => frontendDatesNewsletter($start,$end),'annonce' => $annonce])->render();

        return view('backend.newsletter.index')->with(['newsletter' => $newsletter, 'week' => frontendDatesNewsletter($start,$end), 'annonce' => $annonce]);
    }

    public function send()
    {
        $mailjet = new \App\Praticien\Newsletter\NewsletterWorker();

        return $mailjet->send();
    }
}
