<?php

namespace App\Jobs;

use App\Mail\EmailForQueuing;
use App\Model\BookingResource;
use App\Model\BookingRoom;
use App\Model\BookingVehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

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
        if ($this->bookingType == 'booking-room') {
            $rs = BookingRoom::findOrFail($this->bookingId);
        } elseif ($this->bookingType == 'booking-vehicle') {
            $rs = BookingVehicle::findOrFail($this->bookingId);
        } elseif ($this->bookingType == 'booking-resource') {
            $rs = BookingResource::findOrFail($this->bookingId);
        }

        $email = new EmailForQueuing($this->bookingId, $this->bookingType);
        $recipient = [$rs->request_email, 'puwadon.k@m-society.go.th', 'tsd.ictc@m-society.go.th'];
        Mail::to($recipient)->send($email);
    }
}
