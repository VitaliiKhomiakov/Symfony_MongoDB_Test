<?php
declare(strict_types=1);

namespace App\Provider;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseProvider
{
    protected DocumentManager $documentManager;
    protected ValidatorInterface $validator;

    public function __construct(DocumentManager $documentManager, ValidatorInterface $validator)
    {
        $this->documentManager = $documentManager;
        $this->validator = $validator;
    }

    protected function validate($document)
    {
        $errors = $this->validator->validate($document);
        if (count($errors)) {
            $error = $errors->get(0);
            throw new Exception(
              $error->getPropertyPath() . ' : ' .$error->getMessage(),
              Response::HTTP_BAD_REQUEST
            );
        }
    }
}
