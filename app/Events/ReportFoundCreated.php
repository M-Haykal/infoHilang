<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportFoundCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report;

    /**
     * Create a new event instance.
     */
    public function __construct($report)
    {
        $this->report = $report;
    }

    public function broadcastOn()
    {
        return new Channel('report-found.' . $this->report->foundable_id);
    }

    public function broadcastAs()
    {
        return 'report.created';
    }
}
