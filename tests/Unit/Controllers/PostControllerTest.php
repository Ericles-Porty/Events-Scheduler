<?php

// use App\Controllers\PostController;
// use PHPUnit\Framework\TestCase;
// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;

// class PostControllerTest extends TestCase
// {
//     public function testIndex()
//     {
//         // Arrange
//         $postController = $this->createStub(PostController::class);
//         $postController->method('index')->willReturn('{"id":1,"title":"Post 1","content":"Content 1"}');

//         $request = $this->createStub(Request::class);
//         $response = $this->createStub(Response::class);

//         // Act
//         $result = $postController->index($request, $response, []);

//         // Assert
//         $this->assertEquals('{"id":1,"title":"Post 1","content":"Content 1"}', $result);
//     }

//     public function testStore()
//     {
//         // Arrange
//         $postController = $this->createStub(PostController::class);
//         $postController->method('store')->willReturn('{"id":1,"title":"Post 1","content":"Content 1"}');

//         $request = $this->createStub(Request::class);
//         $response = $this->createStub(Response::class);

//         // Act
//         $result = $postController->store($request, $response, []);

//         // Assert
//         $this->assertEquals('{"id":1,"title":"Post 1","content":"Content 1"}', $result);
//     }
// }
