<?php 

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class EmailDomain extends Constraint
{
    public string $message = 'Le nom de domaine de l\' "%email%" est invalide.';
    public array $domains;

    public function __construct(array $domains)
    {
        parent::__construct();
        $this->domains = $domains;
    }
}
