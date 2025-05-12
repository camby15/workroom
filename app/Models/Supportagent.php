<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supportagent extends Model
{
    use HasFactory;

    protected $table = 'support_agents';
    protected $fillable = [
        'ticket_id',
        'name',
        'email',
        'phone',
        'ticket_count',
    ];

    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'agent_id');
    }
}
