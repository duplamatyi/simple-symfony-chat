<?php

namespace ChatBundle\Entity;

use Doctrine\ORM\EntityRepository;


class MessageRepository extends EntityRepository
{
    /**
     * Returns the messages received by a given user.
     *
     * @param $recipient int
     * @return array
     */
    public function findMessagesByRecipient($recipient)
    {
        $query = $this->createQueryBuilder('m')
            ->join('m.recipient', 'u')
            ->where('u.id = :recipient')
            ->setParameter('recipient', $recipient)
            ->orderBy('m.created', 'DESC')
            ->select('m', 'u')
            ->getQuery();

        return $query->getResult();
    }
}
