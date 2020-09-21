<?php namespace App\Http\Controllers;

use App\Praticien\Decision\Repo\DecisionInterface;
use App\Praticien\Decision\Worker\DecisionWorkerInterface;
use App\Praticien\Newsletter\Service\MailjetServiceInterface;
use App\Praticien\Newsletter\Repo\AnnonceInterface;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    protected $decision;
    protected $worker;
    protected $mailjet;
    protected $annonce;

    public function __construct(DecisionInterface $decision, DecisionWorkerInterface $worker, MailjetServiceInterface $mailjet, AnnonceInterface $annonce)
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $this->decision = $decision;
        $this->worker   = $worker;
        $this->mailjet  = $mailjet;
        $this->annonce  = $annonce;
    }

    public function preview($date = null)
    {
        $monday = \Carbon\Carbon::today()->isMonday() ? \Carbon\Carbon::today()->subWeek() : \Carbon\Carbon::today()->firstWeekDay();
        $date   = $date ? \Carbon\Carbon::parse($date) : $monday;

        $annonce = $this->annonce->active($date);

        $dates = weekRange($date->toDateString());
        $start = $dates->first();
        $end   = $dates->last();

        $decisions = $this->decision->getWeekPublished($dates->toArray());

        return view('emails.newsletter')->with([
            'decisions' => $decisions,
            'date'      => $date,
            'week'      => frontendDatesNewsletter($start,$end),
            'annonce'   => $annonce
        ]);
    }

    public function subscribe(Request $request)
    {
        $this->mailjet->setList(config('services.mailjet.listid'));
        $this->mailjet->subscribeEmailToList($request->input('email'));

        flash('Vous êtes bien inscrit à la newsletter "TF - Arrêts à publications"','success');

        return redirect()->back();
    }

    public function unsubscribe(Request $request)
    {
        $this->mailjet->setList(config('services.mailjet.listid'));
        $this->mailjet->removeContact($request->input('email'));

        flash('Vous êtes bien désinscrit de la newsletter "TF - Arrêts à publications"','success');

        return redirect()->back();
    }
}
