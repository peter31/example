<?php declare(strict_types=1);

namespace Geo\Adapter\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class ExistsEntity extends Constraint
{
    public $field = 'id';
    public $entityClass;
    public $typeName = 'entity';
    public $message = 'The {{ type }} with this id {{ value }} not found.';
}
