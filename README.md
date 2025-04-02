# ReqRes Client

A framework-agnostic PHP client for interacting with the [ReqRes API](https://reqres.in/), which allows for retrieving, creating, and managing user data via a remote API.

## Features

- Retrieve a single user by ID.
- Retrieve a paginated list of users.
- Create a new user by providing a name and job.
- Handles API errors and validations gracefully.
- Works with PHP 8.3 and above.

## Requirements

- PHP >= 8.3
- Composer
- [Guzzle HTTP Client](https://docs.guzzlephp.org/en/stable/) for making HTTP requests
- [Respect Validation](https://respect-validation.readthedocs.io/en/latest/) for data validation
- PHPUnit for testing


## Usage
### Retrieve User

```bash
use Cammillard\ReqResClient\Services\UserService;

$userService = new UserService();

try {
    $user = $userService->getUserById(1); to retrieve.
    print_r($user);
} catch (ApiException $e) {
    echo 'Error: ' . $e->getMessage();
}
```
### Retrieve Paginated user list
```bash
use Cammillard\ReqResClient\Services\UserService;

$userService = new UserService();

try {
    $response = $userService->getUsers(1);
    print_r($response['users']);
    print_r($response['pagination']);
} catch (ApiException $e) {
    echo 'Error: ' . $e->getMessage();
}
```
### Create a new user
```bash
use Cammillard\ReqResClient\Services\UserService;

$userService = new UserService();

try {
    $response = $userService->createUser('Jane Doe', 'Developer');
    echo 'Created User ID: ' . $response['id'];
} catch (ApiException $e) {
    echo 'Error: ' . $e->getMessage();
}
```
## Exception Handling
Incase invalid responses or error occur, you can catch it using
```bash
try {
    // API call that may fail
} catch (ApiException $e) {
    echo 'Error: ' . $e->getMessage();
}
```