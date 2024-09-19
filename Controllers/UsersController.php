<?php

namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;
use App\Models\AnnoncesModel;
use App\Models\CategoriesModel;


class UsersController extends Controller
{
    /* 
        -------------------------------------------------------- CONNEXION --------------------------------------------------------
    */

    /**
     * Connexion des utilisateurs
     * @return void
     */
    public function login()
    {
        if (isset($_POST['validateLog'])) {
            // Vérifie le formulaire (juste si les champs existent et qu'ils ne sont pas vides, à compléter plus tard)
            if (Form::validate($_POST, ['email', 'password'])) {
                // Récupère l'utilisateur par son email
                $userModel = new UsersModel;
                $userArray = $userModel->findOneByEmail(htmlspecialchars($_POST['email']));

                // Si l'utilisateur n'existe pas
                if (!$userArray) {
                    // http_response_code(404);
                    $_SESSION['erreur'] = 'L\'adresse email et/ou le mot de passe est incorrect';
                    header('Location:' . BASE_PATH . 'users/login');
                    exit;
                }

                // S'il existe hydrate l'objet
                $userModel->hydrate($userArray);

                // Vérifie le mot de passe
                if (password_verify($_POST['password'], $userModel->getPassword())) {
                    // Si bon mot de passe, création la session
                    $userModel->setSession();

                    // Si admin redirige vers admin
                    if (isset($_SESSION['user']['roles']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
                        header('Location:' . BASE_PATH . 'admin');
                        exit;
                    }

                    // Redirige vers la page profil
                    header('Location:' . BASE_PATH . 'users/profil');
                    exit;
                } else {
                    // Si mauvais mot de passe
                    $_SESSION['erreur'] = 'L\'adresse email et/ou le mot de passe est incorrect';
                    header('Location:' . BASE_PATH . 'users/login');
                    exit;
                }
            } else {
                // Message de session et rechargement de la page
                $_SESSION['erreur'] = !empty($_POST) ? 'Tous les champs doivent être remplis' : '';
                header('Location:' . BASE_PATH . 'users/login');
                exit;
            }
        }


        $form = new Form;

        // On peut changer les valeurs par défaut (method et action) et mettre d'autres attributs dans un tableau. 
        // Exemple: $form->debutForm('get', 'login.php', ['class' => 'form', 'id' => 'loginForm'])
        $form->debutForm('post', '#', ['class' => 'w-75'])
            ->ajoutLabelFor('email', 'E-mail :', ['class' => 'text-primary'])
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email', 'required' => 'true'])
            ->ajoutLabelFor('password', 'Mot de passe :', ['class' => 'text-primary'])
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'password', 'required' => 'true'])
            ->debutDiv(['class' => 'text-center mt-3'])
            ->ajoutBouton('Me connecter', ['type' => 'submit', 'name' => 'validateLog', 'class' => 'btn btn-primary my-4'])
            ->finDiv()
            ->finForm();

        // Envoi le formulaire à la vue
        $this->render('users/login', ['loginForm' => $form->create()], 'login-register');
    }

    /* 
        -------------------------------------------------------- INSCRIPTION --------------------------------------------------------
    */

    /**
     * Inscription des utilisateurs
     * @return void
     */
    public function register()
    {

        if (isset($_POST['validateReg'])) {
            // Vérifie si le formulaire est valide
            if (Form::validate($_POST, ['pseudo', 'email', 'password'])) {

                $user = new UsersModel;

                $pseudo = Form::valid_donnees($_POST['pseudo']);
                $email = Form::valid_donnees($_POST['email']);
                
                $pseudolength = strlen($pseudo);
                if ($pseudolength > 0 && $pseudolength <= 20){

                    $verif_pseudo = $user->checkIfPseudoAlreadyExists($pseudo);
                    if ($verif_pseudo) {
                        // http_response_code(404);
                        $_SESSION['erreur'] = 'Ce pseudo existe déjà';
                        header('Location:' . BASE_PATH . 'users/register');
                        exit;
                    }
                    
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                        $verif_email = $user->findOneByEmail($email);
                        if ($verif_email) {
                            // http_response_code(404);
                            $_SESSION['erreur'] = 'Cet email existe déjà';
                            header('Location:' . BASE_PATH . 'users/register');
                            exit;
                        }

                        // Hash le mot de passe (ARGON2I à partir de PHP 7.2)
                        $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

                        // Hydrate l'utilisateur
                        $user->setPseudo($pseudo)
                            ->setEmail($email)
                            ->setPassword($pass)
                            ->setRoles(json_encode('["ROLE_USER"]'));
                        // Enregistre l'utilisateur dans la bdd
                        $user->create();

                        // On redirige avec un message
                        $_SESSION['success'] = "Merci et bienvenue";
                        header('Location:' . BASE_PATH . '');
                        exit;
                    } else {
                        $_SESSION['erreur'] = "Votre adresse mail n'est pas valide";
                    }
                } else {
                    $_SESSION['erreur'] = "Votre pseudo doit contenir entre 1 et 20 caractères";
                }
            } else {
                $_SESSION['erreur'] = !empty($_POST) ? 'Tous les champs doivent être remplis' : '';
                header('Location:' . BASE_PATH . 'users/register');
                exit;
            }
        }


        $form = new Form;

        // Formulaire
        $form->debutForm('post', '#', ['class' => 'w-75'])
            ->ajoutLabelFor('pseudo', 'Pseudo :', ['class' => 'text-primary'])
            ->ajoutInput('text', 'pseudo', ['class' => 'form-control', 'id' => 'pseudo', 'minlength' => '1', 'maxlength' => '20', 'required' => 'true'])
            ->ajoutLabelFor('email', 'E-mail :', ['class' => 'text-primary'])
            ->ajoutInput('email', 'email', ['class' => 'form-control', 'id' => 'email', 'required' => 'true'])
            ->ajoutLabelFor('pass', 'Mot de passe :', ['class' => 'text-primary'])
            ->ajoutInput('password', 'password', ['class' => 'form-control', 'id' => 'pass', 'required' => 'true'])
            ->debutDiv(['class' => 'text-center mt-3'])
            ->ajoutBouton('M\'inscrire', ['type' => 'submit', 'name' => 'validateReg', 'class' => 'btn btn-primary my-4'])
            ->finDiv()
            ->finForm();

        // Envoi le formulaire à la vue
        $this->render('users/register', ['registerForm' => $form->create()], 'login-register');
    }

    /* 
        -------------------------------------------------------- DECONNEXION --------------------------------------------------------
    */

    /**
     * Déconnexion de l'utilisateur
     * @return exit
     */
    public function logout()
    {
        unset($_SESSION['user']);
        header('Location:' . BASE_PATH . 'users/login');
        exit;
    }

    /* 
        -------------------------------------------------------- PAGE PROFIL --------------------------------------------------------
    */
    public function profil()
    {
        if ($this->isUser()) {
            $categoriesModel = new CategoriesModel;
            $categories = $categoriesModel->findLeaf_tree();
            $categoriesRacine = $categoriesModel->findBy(['parent_id' => 0]);

            $this->render('users/profil', compact('categories', 'categoriesRacine'));
        }
    }

    /* 
        -------------------------------------------------------- ANNONCES DE L'UTILSATEUR --------------------------------------------------------
    */
    public function annonces()
    {
        if ($this->isUser()) {
            $annoncesModel = new AnnoncesModel;

            $annonces = $annoncesModel->findAllByUserId($_SESSION['user']['id']);

            $this->render('users/annonces', compact('annonces'));
        }
    }

    /* 
        -------------------------------------------------------- SUPPRIME UNE ANNONCE --------------------------------------------------------
    */
    public function supprimeUserAnnonce(int $id)
    {
        if ($this->isUser()) {
            $annonce = new AnnoncesModel;

            $annonce->delete($id);

            header('Location:' . BASE_PATH . 'users/annonces');
        }
    }

    /* 
        -------------------------------------------------------- VERIF USER --------------------------------------------------------
    */
    private function isUser()
    {
        // Vérifie si l'utilisateur est connecté et qu'il a un id
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) {
            return true;
        } else {
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
            header('Location:' . BASE_PATH . 'users/login');
            exit;
        }
    }
}
