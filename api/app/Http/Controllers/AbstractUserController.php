<?php
declare(strict_types=1);

namespace App\Http\Controllers;

abstract class AbstractUserController extends AbstractController
{
    /**
     * @inheritDoc
     */
    protected function getValidationRules(): array
    {
        return [
            'avatar' => 'string|required',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'password' => 'string|required|min:6',
            'address' => 'string|required',
            'city' => 'string|required',
            'zip' => 'numeric|required|digits_between:4,6',
            'country' => 'string|required',
            'email' => 'string|required|unique:users,email',
            'phone' => 'string|required'
        ];
    }
}
