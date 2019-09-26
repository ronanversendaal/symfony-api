<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    const VIEW = 'USER_VIEW';
    const EDIT = 'USER_EDIT';

        //Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface
        //Symfony\Component\Security\Core\Authorization\AccessDecisionManager

    /** @var AccessDecisionManager */
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::VIEW, self::EDIT])
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        /** @var User $userSubject */
        $userSubject = $subject;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
                $this->can(self::VIEW, $userSubject, $user);
                break;
            case self::EDIT:
                $this->can(self::EDIT, $userSubject, $user);
                break;
            default:
                $this->can($attribute, $userSubject, $user);
                break;
        }

        throw new \LogicException('Unreachable code');

    }

    private function can(string $attribute, $subject, User $user)
    {
        // Needs some more verification logic/

        return $user === $subject;
    }
}
