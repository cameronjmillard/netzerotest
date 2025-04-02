<?php 

namespace Cammillard\ReqResClient\Models;

use JsonSerializable;

class User implements JsonSerializable
{
    public function __construct(
        private int $id,
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $avatar
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'avatar' => $this->avatar,
        ];
    }
}