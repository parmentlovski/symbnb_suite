<?php

// namespace App\Service;

// use App\Repository\UserRepository;

// class AuthenticityAccountService
// {

//     public function __construct(UserRepository $userRepo)
//     {
//         $this->userRepo = $userRepo;
//     }

//     /**
//      * Permet de vérifier si l'adresse mail donnée correspond à celle d'un compte existant
//      *
//      * @param string $email
//      * @return boolean
//      */
//     public function checkEmail(string $email)
//     {
//         foreach ($this->userRepo->findAll() as $user) {
//             if ($user->getEmail() == $email) {
//                 return true;
//             } else {
//                 return false;
//             }
//         }
//     }
// } 
