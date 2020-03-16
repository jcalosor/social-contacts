<?php
declare(strict_types=1);

namespace App\Services\Validator;

use App\Services\Validator\Interfaces\ValidatorInterface;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\PresenceVerifierInterface;
use Illuminate\Validation\Validator as IlluminateValidator;

final class Validator implements ValidatorInterface
{
    /**
     * Validation factory instance
     *
     * @var \Illuminate\Contracts\Validation\Factory
     */
    private Factory $factory;

    /**
     * Database presence verifier
     *
     * @var \Illuminate\Validation\PresenceVerifierInterface|null
     */
    private PresenceVerifierInterface $presence;

    /**
     * Validation instance
     *
     * @var \Illuminate\Validation\Validator
     */
    private IlluminateValidator $validator;

    /**
     * Create new validation instance
     *
     * @param \Illuminate\Contracts\Validation\Factory $factory Validation factory interface instance
     * @param \Illuminate\Validation\PresenceVerifierInterface|null $presence Database presence verifier
     */
    public function __construct(Factory $factory, ?PresenceVerifierInterface $presence = null)
    {
        $this->presence = $presence;
        $this->factory = $factory;
    }

    /**
     * Get messages from the last validation attempt
     *
     * @return mixed[]
     */
    public function getFailures(): array
    {
        return $this->validator === null ? [] : $this->validator->getMessageBag()->toArray();
    }

    /**
     * Validate the given data against the provided rules
     *
     * @param mixed[] $data Data to validate
     * @param mixed[] $rules Rules to validate against
     *
     * @return bool
     */
    public function validate(array $data, array $rules): bool
    {
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = $this->factory->make($data, $rules);

        if ($this->presence !== null) {
            $validator->setPresenceVerifier($this->presence);
        }

        $this->validator = $validator;

        return $this->validator->passes();
    }
}
