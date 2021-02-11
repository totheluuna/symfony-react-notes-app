<?php

namespace App\Serializer;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserContextBuilder implements SerializerContextBuilderInterface {
    /**
     * @var SerializerContextBuilderInterface
     */
    private $decorated;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    public function __construct(
        SerializerContextBuilderInterface $decorated,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }


    /**
     * Creates a serialization context from a Request.
     *
     * @throws RuntimeException
     */
    public function createFromRequest(
        Request $request, 
        bool $normalization, 
        array $extractedAttributes = null
    ): array {
        $context = $this->decorated->createFromRequest(
            $request, $normalization, $extractedAttributes
        );

        // Class being serialized/deserialized
        $resourceClass = $context['resource_class'] ?? null; // Default to null if not set

        if (
            User::class === $resourceClass &&
            isset($context['groups']) &&
            $normalization === true &&
            $this->authorizationChecker->isGranted(User::ROLE_ADMIN)
        ) {
            $context['groups'][] = 'get-admin';
        }

        return $context;
    }
}