<?php


namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Contact;
use ApiPlatform\Core\OpenApi\Model\Info;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Response;

final class OpenApiFactory implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @param array<mixed> $context
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $components = $openApi->getComponents();
        $schemas = $components->getSchemas();

        $schemas['cookiesAuth'] = new \ArrayObject([
            'type' => 'apiKey',
            'in' => 'header',
            'name' => 'Authorization',
            'value' => 'Bearer '.'*******',
        ]);

        $schemas['Credentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'Onepeace',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => '123456',
                ]
            ],
        ]);

        $schemas['authToken'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'example' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzYyMjUyNjksImV4cCI6MTYzNjIyOD...Krco3Qi3zbfeo6Pj6uKishRyDGbwbIb8sexiQUzu3ZgRkdnrsxuK...dyKRaqrMIPzD36Qv9384EdNK70qsOFpeX51P-y733c93CGZnmOWwLeHbuQ8uTo',
                ]
            ],
        ]);

        if (null === $schemas) {
            throw new UnexpectedValueException('Failed to obtain OpenApi schemas');
        }

        $pathItem = new PathItem(
            'Auth endpoint',
            'The API endpoint',
            '',
            null,
            null,
            // Your custom post operation
            new Operation(
                'postApiLogin', // the operation route name
                ['Auth'], // your resource name
                [
                    // response specifications
                    '200' => [
                        'description' => 'Token endpoint response description',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    // 'token' => [
                                    //     'type' => 'string'
                                    // ]
                                    '$ref' => '#/components/schemas/authToken', // your resource (read) schema
                                ],
                            ],
                        ],
                    ],
                ],
                'Auth login',
                '',
                null,
                [],
                new RequestBody(
                    'A Auth payload request body',
                    new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials', // your resource (write) schema
                            ],
                        ],
                    ]),
                ),
            ),
        );
        // dd($openApi->getExtensionProperties());


        $paths = $openApi->getPaths();
        $paths->addPath('/api/auth', $pathItem);
        return $openApi;

        // return $openApi->withExtensionProperty(['type' => 'apiKey',
        // 'in' => 'header',
        // 'name' => 'Authorization',]);
    }
}