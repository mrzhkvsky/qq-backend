<?php
declare(strict_types=1);

namespace App\Application\Method;

use App\Application\Data\InvalidParam;
use App\Domain\User\Entity\User;
use App\Infrastructure\Rpc\RpcResult;
use Psr\Container\ContainerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractMethod
{
    protected ContainerInterface $container;

    abstract public function exec(array $data): RpcResult;

    /**
     * @internal
     * @required
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @param mixed $data
     * @param Constraint|Constraint[] $constraints
     *
     * @return \App\Application\Data\InvalidParam[]
     */
    protected function validate($data, $constraints): array
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

    protected function isGranted($attribute, $subject = null): bool
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

    protected function serialize(RpcResult $result, array $includedAttributes = null, array $ignoredAttributes = null): string
    {

        return $this->container->get('serializer')->serialize($result->getResult(), 'json', [
            AbstractNormalizer::ATTRIBUTES => $includedAttributes,
            AbstractNormalizer::IGNORED_ATTRIBUTES => $ignoredAttributes
        ]);
    }
}
