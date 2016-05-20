<?php

namespace ErenMustafaOzdal\LaravelUserModule\Events\Auth;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ForgetPasswordFail extends Event
{
    use SerializesModels;

    public $datas;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Array $datas)
    {
        $this->datas = $datas;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
