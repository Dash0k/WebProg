<?php
declare(strict_types=1);

require_once 'UserPersistInterface.php';

class DatabaseUserPersist implements UserPersistInterface
{
    private ?\PDO $databaseConnection = null;

    public function save(User $user): void
    {
        $sth = $this->getDatabaseConnection()
            ->prepare("INSERT INTO `user` (login, password) values (:login, :password)");
        $sth->execute(['login' => $user->getLogin(), 'password' => sha1($user->getPassword())]);
    }

    public function get(string $login): ?User
    {
        $sth = $this->getDatabaseConnection()->prepare('SELECT id, login, password, created_at FROM `user` WHERE `login` = :login');
        $sth->execute(['login' => $login]);
        $userData = $sth->fetch(PDO::FETCH_ASSOC);

        if (!empty($userData)) {
            return new User($userData['login'], $userData['password'], $userData['password'], new \DateTimeImmutable($userData['created_at']));
        }

        return null;
    }

    private function getDatabaseConnection(): \PDO
    {
        if (!$this->databaseConnection) {
            try {
                $this->databaseConnection = new PDO('mysql:dbname=user;host=127.0.0.1', 'sqluser', 'mood001');
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        return $this->databaseConnection;
    }
}