<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Model\BookingRoom;
use App\Model\BookingVehicle;
use App\Model\BookingResource;


class EmailForQueuing extends Mailable
{
    use Queueable, SerializesModels;

    protected $bookingId;
    protected $bookingType;
    public function __construct($bookingId, $bookingType)
    {
        $this->bookingId = $bookingId;
        $this->bookingType = $bookingType;
    }

    public function build()
    {
        if($this->bookingType == 'booking-room'){
            $rs = BookingRoom::findOrFail($this->bookingId);
            $type = 'ห้องประชุม/อบรม';
        }elseif($this->bookingType == 'booking-vehicle'){
            $rs = BookingVehicle::findOrFail($this->bookingId);
            $type = 'ยานพาหนะ';
        }elseif($this->bookingType == 'booking-resource'){
            $rs = BookingResource::findOrFail($this->bookingId);
            $type = 'ทรัพยากร';
        }

        return $this->from('mso.reservation@gmail.com', 'ระบบจองทรัพยากร (msobooking)')
                    ->subject('รายละเอียดการจอง'.$type)
                    ->view('email.booking-summary', compact('rs'))->withType($this->bookingType);
    }
}
