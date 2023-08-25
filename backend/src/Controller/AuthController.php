<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AcmeAssert;
use App\Entity\User;

class AuthController extends AbstractController
{
    public function login(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        ValidatorInterface $validator,
        JWTTokenManagerInterface $JWTManager
    ): JsonResponse
    {
        $groups = new Assert\GroupSequence(['Default', 'custom']);
        $constraints = new Assert\Collection([
            'email' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 180,
                    'maxMessage' => 'Your email cannot be longer than {{ limit }} characters'
                ]),
                new Assert\Email([
                    'message' => "The email '{{ value }}' is not a valid email."
                ])
            ],
            'password' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                    'maxMessage' => 'Your password name cannot be longer than {{ limit }} characters'
                ]),
            ],
        ]);

        $errors = $validator->validate($request->request->all(), $constraints, $groups);
        if (count($errors) > 0) {
            $errorsString = '';
            foreach ($errors as $string) {
                $formattedString = preg_replace(
                    ['/Array\[/', '/\]/', '/\(code.*?\)/', '/\n/'],
                    ['', '', ''],
                    $string
                );
                $errorsString .= $formattedString . ' ';
            }
            return $this->json(["message" => trim($errorsString)], 400);
        }
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $request->request->get('email')]);

        if (!$user) {
            throw new UsernameNotFoundException();
        }
        if (!$encoder->isPasswordValid($user, $request->request->get('password'))) {
            throw new AccessDeniedHttpException();
        }
        return $this->json(["token" => $JWTManager->create($user)], 200);
    }

    public function register(
        Request $request, 
        UserPasswordEncoderInterface $encoder, 
        ValidatorInterface $validator,
        JWTTokenManagerInterface $JWTManager
    ): JsonResponse
    {
        $groups = new Assert\GroupSequence(['Default', 'custom']);
        $constraints = new Assert\Collection([
            'email' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 180,
                    'maxMessage' => 'Your email cannot be longer than {{ limit }} characters'
                ]),
                new Assert\Email([
                    'message' => "The email '{{ value }}' is not a valid email."
                ]),
                new AcmeAssert\UniqueEmail()
            ],
            'name' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                    'maxMessage' => 'Your name name cannot be longer than {{ limit }} characters'
                ]),
            ],
            'surname' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                    'maxMessage' => 'Your surname name cannot be longer than {{ limit }} characters'
                ]),
            ],
            'password' =>[
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                    'maxMessage' => 'Your password name cannot be longer than {{ limit }} characters'
                ]),
            ],
        ]);

        $errors = $validator->validate($request->request->all(), $constraints, $groups);
        if (count($errors) > 0) {
            $errorsString = '';
            foreach ($errors as $string) {
                $formattedString = preg_replace(
                    ['/Array\[/', '/\]/','/\(code.*?\)/', '/\n/'], 
                    ['', '', ''], 
                    $string
                );
                $errorsString .= $formattedString.' ';
            }
            return $this->json(["message" => trim($errorsString)], 400);
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class);

        $user->setName($request->request->get('name'));
        $user->setSurname($request->request->get('surname'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword($encoder->encodePassword($user, $request->request->get('password')));

        $user->add($user);

        return $this->json(["token" => $JWTManager->create($user)], 200);
    }
}
