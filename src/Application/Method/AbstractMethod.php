<?php
declare(strict_types=1);

namespace App\Application\Method;

use App\Application\Data\InvalidParam;
use App\Domain\User\Entity\User;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractMethod
{
    private ContainerInterface $container;

    #[Required]
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @param Constraint|Constraint[] $constraints
     *
     * @return \App\Application\Data\InvalidParam[]
     */
    protected function validate(mixed $data, array|Constraint $constraints): array
    {
        /** @var ConstraintViolationListInterface $list */
        $list = $this->container->get('validator')->validate($data, $constraints);

        if ($list->count() === 0) {
            return [];
        }

        $invalidParams = [];
        /** @var \Symfony\Component\Validator\ConstraintViolation $constraint */
        foreach ($list as $constraint) {
            $invalidParams[] = new InvalidParam(
                1,
                $constraint->getMessage(),
                substr($constraint->getPropertyPath(), 1, -1)
            );
        }

        return $invalidParams;
    }

    protected function isGranted(mixed $attribute, mixed $subject = null): bool
    {
        return $this->container->get('security.authorization_checker')
            ->isGranted($attribute, $subject);
    }

    protected function getUser(): User
    {
        $token = $this->container->get('security.token_storage')->getToken();

        if (is_null($token)) {
            throw new \LogicException('Token not found');
        }

        return $token->getUser();
    }
}
