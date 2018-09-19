<?php
namespace ApiSecurityBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityManagerInterface;

class ApiAuthenticator extends AbstractGuardAuthenticator
{
    private $encoder;
    private $entityManager;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $entityManager)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
    }
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request)
    {
        return $request->headers->has('login');
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     */
    public function getCredentials(Request $request)
    {
        return array(
            'login' => $request->headers->get('login'),
            'role' => $request->headers->get('X-SCOPE'),
            'password' => $request->headers->get('password'),
            'xCustomerRef' => $request->headers->get('X-CUSTOMER-REF')
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $ref = $credentials['xCustomerRef'];
        $scopes = unserialize($this->getRoleAndRef($ref)['scopes']);
        if(!$scopes){
            throw new AccessDeniedHttpException('Access Denied');
        }

        $login = $credentials['login'];
        $role = $credentials['role'];

        if (null === $login) {
            return;
        }

        if(in_array($role, $scopes)){
            $userProvider->loadUserByUsername($login)->setRoles([$role]);
        }else{
            throw new AccessDeniedHttpException('Access Denied');
        }

        // if a User object, checkCredentials() is called
        return $userProvider->loadUserByUsername($login);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $plainPassword = $credentials['password'];
        if (!$this->encoder->isPasswordValid($user, $plainPassword)){
            throw new BadCredentialsException();
        }else{
            return true;
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            // you might translate this message
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }


    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->entityManager->getConnection();
    }

    /**
     * @param $reference
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getRoleAndRef($reference)
    {
        $statement = $this->getConnection()->prepare("SELECT scopes FROM customer_client WHERE x_customer_ref= :reference");
        $statement->bindParam(':reference', $reference);
        $statement->execute();

        return $statement->fetch();
    }
}