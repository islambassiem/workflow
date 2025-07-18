<?php

namespace App\Mail;

use App\Models\WorkflowRequestStep;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WorkflowRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public WorkflowRequestStep $step,
        public string $requester = ''
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Workflow Request Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $workflowName = $this->step->request->workflow->name;
        $id = $this->step->id;
        $actionUrl = config('app.front_end_url')."/approvals/requests/$id/steps";

        return new Content(
            view: 'emails.create-request',
            with: [
                'messageLine1' => "$this->requester has created a new $workflowName request.",
                'actionText' => 'View Request',
                'actionUrl' => $actionUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
