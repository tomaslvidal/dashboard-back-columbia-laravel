<?php

namespace Columbia\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SurveyMade extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $survey;

    public function __construct($survey_made)
    {
        $this->survey = $survey_made;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->survey['user']['email'];

        $name_survey = $this->survey['survey']['name'];

        return $this->view('mail.survey_made')->subject('Se ha realizado con exito la encuesta '.$name_survey.', por '.$email);
    }
}
