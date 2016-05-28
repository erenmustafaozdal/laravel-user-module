<?php

namespace ErenMustafaOzdal\LaravelUserModule\Events\User;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StoreFail extends Event
{
    use SerializesModels;

    public $datas;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($datas)
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
