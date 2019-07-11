<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use Partymeister\Core\Events\VisitorRegistered;
use Partymeister\Core\Models\Visitor;

class VisitorRegisteredEventListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Handle the event.
     */
    public function handle(VisitorRegistered $event)
    {
        $visitorCount = Visitor::count();
        $maxRows      = max(ceil($visitorCount / 10), 1);
        $seatNumber   = '';
        switch ($visitorCount % 10) {
            case 1:
                $seatNumber = $maxRows . 'A';
                break;
            case 2:
                $seatNumber = $maxRows . 'B';
                break;
            case 3:
                $seatNumber = $maxRows . 'C';
                break;
            case 4:
                $seatNumber = $maxRows . 'D';
                break;
            case 5:
                $seatNumber = $maxRows . 'E';
                break;
            case 6:
                $seatNumber = $maxRows . 'F';
                break;
            case 7:
                $seatNumber = $maxRows . 'G';
                break;
            case 8:
                $seatNumber = $maxRows . 'H';
                break;
            case 9:
                $seatNumber = $maxRows . 'J';
                break;
            case 0:
                $seatNumber = $maxRows . 'K';
                break;
        }
        $event->visitor->additional_data = [ 'seat' => $seatNumber, 'boardingpass' => Str::upper(Str::random(5)) ];
        $event->visitor->save();
    }
}