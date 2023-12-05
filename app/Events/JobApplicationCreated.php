<?php

namespace App\Events;

use App\Models\Jobapplication;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobApplicationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $jobapplication;
    /**
     * Create a new event instance.
     *
     * @return void
     */
   
        public function __construct(Jobapplication $jobapplication)
        {
            $this->jobapplication = $jobapplication;
        }
    

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $id1= 2;

        return new Channel('job-application-channel.' . $id1);
    }
    public function broadcastWith()
    {

        return [
            'jobapplication' => $this->jobapplication,
        ];
    }
    public function broadcastAs()
    {
        return 'JobApplicationCreated';
    }
}
