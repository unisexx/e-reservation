<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\EmailForQueuing;
use Mail;

use App\Model\BookingRoom;
use App\Model\BookingVehicle;
use App\Model\BookingResource;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $tries = 5;
    // public $timeout = 20;

    protected $bookingId;
    protected $bookingType;
    public function __construct($bookingId, $bookingType)
    {
        $this->bookingId = $bookingId;
        $this->bookingType = $bookingType;
    }

    public function handle()
    {
        if($this->bookingType == 'booking-room'){
            $rs = BookingRoom::findOrFail($this->bookingId);
        }elseif($this->bookingType == 'booking-vehicle'){
            $rs = BookingVehicle::findOrFail($this->bookingId);
        }elseif($this->bookingType == 'booking-resource'){
            $rs = BookingResource::findOrFail($this->bookingId);
        }

        $email = new EmailForQueuing($this->bookingId, $this->bookingType);
        Mail::to($rs->request_email)->send($email);
    }
}
