<?php

namespace ErenMustafaOzdal\LaravelUserModule\Events\Auth;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivateFail extends Event
{
    use SerializesModels;

    public $id;
    public $code;

    /**
     * Create a new event instance.
     *
     * @param integer $id
     * @param string $code
     * @param string $type
     */
    public function __construct($id, $code, $type)
    {
        $this->id = $id;
        $this->code = $code;
        $this->type = $type;
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
