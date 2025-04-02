<?php 

use PHPUnit\Framework\TestCase;
use Cammillard\ReqResClient\Services\UserService;
use Cammillard\ReqResClient\Models\User;
use Cammillard\ReqResClient\Exceptions\ApiException;
use Cammillard\ReqResClient\Http\ApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class UserServiceTest extends TestCase
{
    private UserService $service;

    protected function setUp(): void
    {
        $client = new ApiClient();
        $this->service = new UserService($client);
    }

    public function testGetUserById(): void
    {
        $user = $this->service->getUserById(1);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user->jsonSerialize()['id']);
    }

    public function testCreateUser(): void
    {
        $response = $this->service->createUser("Mark Hammond", "Owner");
        
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals("Mark Hammond", $response['name']);
        $this->assertEquals("Owner", $response['job']);
    }

    public function testCreateUserWithInvalidData(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Invalid input: name and job are required.');

        $this->service->createUser("", "");
    }

    public function testApiExceptionHandling(): void
    {
        try {
            $this->service->getUserById(9999);  // Invalid user ID
        } catch (ApiException $e) {
            // do not need to assert Exception as we are catching it
            $this->assertStringContainsString('API request failed:', $e->getMessage());
        }
    }
}
