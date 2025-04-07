<?php

namespace App\Security\Voter;

use App\Entity\Event;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class EventVoter extends Voter
{
    public const SHOW   = 'EVENT_SHOW';
    public const UPDATE = 'EVENT_UPDATE';
    public const DELETE = 'EVENT_DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::SHOW, self::UPDATE, self::DELETE])
            && $subject instanceof Event;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();      //< Utilisateur connecté à l'application

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::SHOW:
                // est-ce que le createdBy de l'évènement === utilisateur connecté ?
                /** @var Event $subject */
                if($subject->getCreatedBy() === $user) { return true; }
                
                break;

            case self::UPDATE:
                /** @var Event $subject */
                if($subject->getCreatedBy() === $user) { return true; }
                
                break;

            case self::DELETE:
                /** @var Event $subject */
                if($subject->getCreatedBy() === $user) { return true; }
                
                break;
        }

        return false;
    }
}
