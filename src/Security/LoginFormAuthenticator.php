<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    /**
     * Constructeur.
     *
     * @param UrlGeneratorInterface $urlGenerator le service de génération d'URL
     */
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    /**
     * Authentifie l'utilisateur en fonction du formulaire de connexion soumis.
     *
     * @param Request $request la requête actuelle
     *
     * @return Passport le passeport d'authentification
     */
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    /**
     * Gère le succès de l'authentification.
     *
     * @param Request        $request      la requête actuelle
     * @param TokenInterface $token        le jeton d'authentification
     * @param string         $firewallName le nom du pare-feu
     *
     * @return Response|null la réponse après une authentification réussie
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {

        if ($redirect = $request->get('redirect')){
            return new RedirectResponse($redirect);
        }
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        throw new \Exception('erreur de redirection');
    }

    /**
     * Obtient l'URL de connexion.
     *
     * @param Request $request la requête actuelle
     *
     * @return string L'URL de connexion
     */
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        $route = $request->get('_route');
        if (str_starts_with($route,'_api_')) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED);
        }
        $url = $this->getLoginUrl($request);
        return new RedirectResponse($url);
    }
}
