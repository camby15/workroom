<h2>Hello {{ $ticket->agent->name ?? 'Agent' }},</h2>

<p>You have been assigned a new ticket.</p>

<ul>
    <li><strong>Subject:</strong> {{ $ticket->subject }}</li>
    <li><strong>Message:</strong> {{ $ticket->description }}</li>
    <li><strong>Ticket ID:</strong> {{ $ticket->ticket_id }}</li>
</ul>

<p>Please log in to your dashboard to view and respond to it.</p>

<p>Thanks,<br>The Support Team</p>
