<?php

namespace GBProd\ICantDecide\CoreDomain\Question;

use GBProd\DomainEvent\EventProvider;
use GBProd\DomainEvent\EventProviderTrait;
use GBProd\ICantDecide\CoreDomain\Question\QuestionIdentifier;
use GBProd\ICantDecide\CoreDomain\Event\Question\QuestionAsked;

/**
 * Question
 *
 * @author gbprod <contact@gb-prod.fr>
 */
final class Question implements EventProvider
{
    use EventProviderTrait;

    /**
     * @var QuestionIdentifier
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var \DateTimeImmutable
     */
    private $endDate;

    /**
     * Ask a question
     *
     * @param string $text
     * @param array  $options
     *
     * @return Question
     */
    public static function ask(QuestionIdentifier $id, $text, \DateTimeImmutable $endDate)
    {
        if (empty($text)) {
            throw new \InvalidArgumentException("The text should not be blank.");
        }

        if ($endDate < new \DateTimeImmutable('now')) {
            throw new \InvalidArgumentException("The end date should be in the future.");
        }

        $question = new self($id, $text, $endDate);

        $question->raise(new QuestionAsked($question));

        return $question;
    }

    /**
     * @param string $text
     */
    private function __construct(QuestionIdentifier $id, $text, \DateTimeImmutable $endDate)
    {
        $this->id      = $id;
        $this->text    = $text;
        $this->endDate = $endDate;
    }

    /**
     * id
     *
     * @return QuestionIdentifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Question text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Question text
     *
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
