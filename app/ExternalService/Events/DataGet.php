<?php
//este evento se dispara cuando se obtienen datos del servicio externo 
//el servicio externo esta en el archivo ApiService.php es una api falsa que devuelve post de ejemplo 
//la ruta del json esta en el archivo .env en la variable API_URL
namespace App\ExternalService\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataGet
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $data; 
    /**
     * Create a new event instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
