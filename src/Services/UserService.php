<?php 

namespace Cammillard\ReqResClient\Services;

use Cammillard\ReqResClient\Http\ApiClient;
use Cammillard\ReqResClient\Models\User;
use Cammillard\ReqResClient\Exceptions\ApiException;
use Respect\Validation\Validator as v;

class UserService
{
    private ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function getUserById(int $id): User
    {
        $data = $this->client->get("users/{$id}");
        
        if (!isset($data['data']) || !is_array($data['data']) || empty($data['data'])) {
            throw new ApiException("User not found or API response is invalid.");
        }

        $userData = $data['data'];

        $requiredFields = ['id', 'first_name', 'last_name', 'email', 'avatar'];
        foreach ($requiredFields as $field) {
            if (!isset($userData[$field])) {
                throw new ApiException("Missing expected field: {$field} in API response.");
            }
        }

        return new User(
            $userData['id'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['avatar']
        );
    }

    public function getUsers(int $page = 1): array
    {
        $data = $this->client->get("users?page={$page}");

        if (!isset($data['data']) || !isset($data['total']) || !isset($data['total_pages'])) {
            throw new ApiException("Invalid or missing data from API response.");
        }

        return [
            'users' => array_map(fn($user) => new User(
                $user['id'],
                $user['first_name'],
                $user['last_name'],
                $user['email'],
                $user['avatar']
            ), $data['data']),
            'pagination' => [
                'total' => $data['total'],
                'per_page' => $data['per_page'],
                'current_page' => $data['page'],
                'total_pages' => $data['total_pages']
            ]
        ];
    }

    public function createUser(string $name, string $job): array
    {
        if (!v::stringType()->notEmpty()->validate($name) || !v::stringType()->notEmpty()->validate($job)) {
            throw new ApiException("Invalid input: name and job are required.");
        }

        return $this->client->post("users", ['name' => $name, 'job' => $job]);
    }
}

