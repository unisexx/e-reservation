<?php

namespace App\Mail;

use App\Model\BookingBoss;
use App\Model\BookingResource;
use App\Model\BookingRoom;
use App\Model\BookingVehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Status extends Mailable
{
    use Queueable, SerializesModels;

    protected $bookingId;
    protected $bookingType;
    protected $bookingMethod; // create = รายละเอียดการจอง, update = อัพเดทสถานะการจอง
    public function __construct($bookingId, $bookingType, $bookingMethod)
    {
        $this->bookingId = $bookingId;
        $this->bookingType = $bookingType;
        $this->bookingMethod = $bookingMethod;
    }

    public function build()
    {
        if ($this->bookingType == 'booking-room') {
            $rs = BookingRoom::findOrFail($this->bookingId);
            $type = 'ห้องประชุม/อบรม';
        } elseif ($this->bookingType == 'booking-vehicle') {
            $rs = BookingVehicle::findOrFail($this->bookingId);
            $type = 'ยานพาหนะ';
        } elseif ($this->bookingType == 'booking-resource') {
            $rs = BookingResource::findOrFail($this->bookingId);
            $type = 'ทรัพยากร';
        } elseif ($this->bookingType == 'booking-boss') {
            $rs = BookingBoss::findOrFail($this->bookingId);
            $type = 'วาระผู้บริหาร';
        }

        if ($this->bookingMethod == 'create') {
            $method = 'รายละเอียดการจอง' . $type;
        } elseif ($this->bookingMethod == 'update') {
            $method = 'อัพเดทสถานะการจอง' . $type;
        }

        return $this->from('mso.reservation@gmail.com', 'ระบบจองทรัพยากร (msobooking)')
            ->subject(@$method)
        // ->markdown('vendor.notifications.email_status', compact('rs'))->withType($this->bookingType);
            ->view('email.booking-summary', compact('rs'))->withType($this->bookingType);
    }
}
