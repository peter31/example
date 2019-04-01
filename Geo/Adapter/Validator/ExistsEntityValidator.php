<?php declare(strict_types=1);

namespace Geo\Adapter\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ExistsEntityValidator extends ConstraintValidator
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ExistsEntity) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\ExistsEntity');
        }

        if (!class_exists($constraint->entityClass)) {
            throw new \InvalidArgumentException(\sprintf('Entity class %s does not exists.', $constraint->entityClass));
        }

        if (null !== $value) {
            $repository = $this->em->getRepository($constraint->entityClass);
            $entity = $repository->findOneBy([$constraint->field => $value]);

            if (null === $entity) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ type }}', $constraint->typeName)
                    ->setParameter('{{ value }}', $value)
                    ->addViolation();
            }
        }
    }
}
