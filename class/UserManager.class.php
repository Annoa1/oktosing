<?php

include 'User.class.php';

class UserManager {

  // Instance de PDO
  private $_db;

  // Constructeur
  public function __construct($db) {
    $this->setDb($db);
  }

  // Setteur de _db
  public function setDb (PDO $db) {
    $this->_db = $db;
  }

  // Ajoute un utilisateur à la BDD
  public function add(User $user) {
    $rq = $this->_db->prepare(
        'INSERT INTO T_USER_USR (USR_LOGIN, USR_MAIL, USR_PWD, USR_COLOR)
        VALUES (:login, :mail, :pwd, :color);'
      );
    $rq->bindvalue(':login', $user->login());
    $rq->bindvalue(':mail', $user->mail());
    $rq->bindvalue(':pwd', $user->pwd());
    $rq->bindvalue(':color', $user->color());

    $rq->execute();
  }

  // Supprime un utilisateur à la BDD
  public function delete(User $user) {
    $this->_db->exec(
        'DELETE FROM T_USER_USR
        WHERE id='.$user->id()
      );
  }

  // Retourne un utilisateur
  public function get($id) {
    $id = (int) $id;

    $rq = $this->_db->query(
      'SELECT USR_ID as id,
      USR_LOG as login,
      USR_MAIL as mail,
      USR_PWD as pwd,
      USR_COLOR as color
      FROM T_USER_USR
      WHERE USR_ID = '.$id
      );
    $donnees = $rq->fetch(PDO::FETCH_ASSOC);
    return new User($donnees);
  }

  // Retourne tous les utilisateurs
  public function getList() {
    $users = [];

    $rq = $this->_db->query(
        'SELECT USR_ID as id,
        USR_LOG as login,
        USR_MAIL as mail,
        USR_PWD as pwd,
        USR_COLOR as color
        FROM T_USER_USR
        ORDER BY login'
      );

    while ($donnees = $rq->fetch(PDO::FETCH_ASSOC)) {
      $users[] = new User($donnees);
    }

    return $users;
  }

  // Modifie un user dans la BDD
  public function update(User $user) {
    $rq = $this->_db->prepare(
        'UPDATE T_USER_USR
        SET USR_LOG = :login,
        USR_MAIL = :mail,
        USR_PWD = :pwd,
        USR_COLOR = :color
        WHERE USR_ID = :id'
      );

    $rq->bindvalue(':id', $user->id());
    $rq->bindvalue(':login', $user->login());
    $rq->bindvalue(':mail', $user->mail());
    $rq->bindvalue(':pwd', $user->pwd());
    $rq->bindvalue(':color', $user->color());

    $rq->execute();
  }

}


?>