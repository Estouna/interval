<?php

namespace App\Models;

class UsersModel extends Model
{
    protected $id;
    protected $pseudo;
    protected $email;
    protected $password;
    protected $roles;


    /* 
        -------------------------------------------------------- CONSTRUCTEUR --------------------------------------------------------
    */
    public function __construct()
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        $this->table = strtolower(str_replace('Model', '', $class));
    }

    /* 
        -------------------------------------------------------- METHODES --------------------------------------------------------
    */

    /* 
       ----------  TROUVER UN UTILISATEUR PAR SON EMAIL OU VERIFIER SI L'EMAIL EXISTE  ----------
    */
    /**
     * Récupère un utilisateur à partir de son email
     * @param string $email
     * @return mixed
     */
    public function findOneByEmail(string $email)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE email = ?", [$email])->fetch();
    }

    /* 
       ----------  VERIFIER SI LE PSEUDO EXISTE DEJA DANS LA BDD ----------
    */
    /**
     * Récupère un utilisateur à partir de son email
     * @param string $email
     * @return mixed
     */
    public function checkIfPseudoAlreadyExists(string $pseudo)
    {
        return $this->requete("SELECT pseudo FROM {$this->table} WHERE pseudo = ?", [$pseudo])->fetch();
    }

    /* 
       ----------  SESSION UTILISATEUR  ----------
       */
    /**
     * Crée la session de l'utilisateur
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'pseudo' => $this->pseudo,
            'email' => $this->email,
            'roles' => $this->roles
        ];
    }

    /* 
        -------------------------------------------------------- GETTERS/SETTERS --------------------------------------------------------
        */
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of pseudo
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }



    /**
     * Get the value of roles
     * @return array
     */
    public function getRoles(): array
    {
        // Récupère les rôles qui ont été donnés
        $roles = $this->roles;
        // push qui permet d'avoir par défaut ROLE_USER même s'il y a Null dans la bdd
        $roles[] = 'ROLE_USER';
        // pour supprimer les éventuels doublons de la bdd (2x 'ROLE_USER')
        return array_unique($roles);
    }

    /**
     * Set the value of roles
     * @return  self
     */
    public function setRoles($roles)
    {
        $this->roles = json_decode($roles);

        return $this;
    }
}
