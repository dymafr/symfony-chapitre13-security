<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BlogVoter extends Voter
{
    public const EDIT = 'BLOG_EDIT';

    protected function supports(string $attribute, $subject): bool
    {

        return in_array($attribute, [self::EDIT])
            && $subject instanceof \App\Entity\Blog;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {

        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                if ($subject->getAuthor() === $user) {
                    return true;
                }
                break;
        }

        return false;
    }
}
