<?php

namespace M6\Bundle\SixBoardBundle\Mailer;

use Symfony\Component\Templating\EngineInterface;

/**
 * Class mailer
 */
class Mailer
{
    protected $mailer;
    protected $templating;
    protected $from;

    /**
     * Constructor
     *
     * @param \Swift_Mailer   $mailer     The mailer
     * @param EngineInterface $templating The templating
     * @param array           $options    An array of options
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, $from)
    {
        $this->mailer     = $mailer;
        $this->templating = $templating;
        $this->from       = $from;
    }

    /**
     * Sends the message using swift mailer
     *
     * @param string $title      The email title
     * @param string $template   The path to the template
     * @param string $parameters The parameters passed to template
     * @param string $from       The sender
     * @param string $to         The reciever
     */
    public function sendMessage($title, $template, $parameters, $from, $to)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($title)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($this->templating->render($template, $parameters))
            ->setContentType('text/html');

        $this->mailer->send($message);
    }

    /**
     * Sends the email when a new story
     *
     * @param Story $story The story
     * @param array $user  An array of user's mail
     */
    public function sendNewStory($story, $users)
    {
        $template = 'M6SixBoardBundle:Mail:newStory.html.twig';

        $from  = $this->from;
        $title = 'A new story has been created';

        foreach ($users as $user) {
            $to = array($user['emailCanonical'] => $user['emailCanonical']);

            $parameters = array(
                'story' => $story
            );

            $this->sendMessage($title, $template, $parameters, $from, $to);
        }
    }

    /**
     * Sends the email when a new note
     *
     * @param Note  $note The note
     * @param array $user An array of user's mail
     */
    public function sendNewNote($story, $users)
    {
        $template = 'M6SixBoardBundle:Mail:newNote.html.twig';

        $from  = $this->from;
        $title = 'A new note has been created';

        foreach ($users as $user) {
            $to = array($user['emailCanonical'] => $user['emailCanonical']);

            $parameters = array(
                'note' => $note
            );

            $this->sendMessage($title, $template, $parameters, $from, $to);
        }
    }
}
