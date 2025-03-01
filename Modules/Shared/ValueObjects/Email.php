<?php

declare(strict_types=1);

namespace Modules\Shared\ValueObjects;

use InvalidArgumentException;

/**
 * Email value object for validating and handling email addresses
 */
final class Email
{
    private string $email;

    /**
     * @throws InvalidArgumentException If the email is invalid
     */
    public function __construct(string $email)
    {
        $this->validate($email);
        $this->email = $email;
    }

    private function validate(string $email): void
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address');
        }
    }

    /**
     * Get the string representation of the email
     */
    public function __toString(): string
    {
        return $this->email;
    }

    public function value(): string
    {
        return $this->email;
    }

    /**
     * Check if this email equals another email
     */
    public function equals(self $other): bool
    {
        return $this->email === $other->email;
    }
}
