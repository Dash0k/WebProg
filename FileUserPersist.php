<?php

declare(strict_types=1);

require_once 'UserPersistInterface.php';

class FileUserPersist implements UserPersistInterface
{
    const FILENAME = 'users.txt';

    public function save(User $user): void
    {
        if (file_exists(self::FILENAME)) {
            $fileContains = json_decode(file_get_contents(self::FILENAME), true);
        } else {
            $fileContains = [];
        }

        $fileContains[] = $this->getUserToPersistByUser($user);


        file_put_contents(self::FILENAME, json_encode($fileContains));
    }

    public function get(string $login): ?User
    {
        if (!file_exists(self::FILENAME)) {
            return null;
        }

        $rawUsers = json_decode(file_get_contents(self::FILENAME), true);

        foreach ($rawUsers as $item) {
            if ($item['login'] === $login) {
                return new User(strtolower($item['login']), $item['password'], $item['password'], DateTimeImmutable::createFromFormat('d.m.Y H:i:s', $item['createdAt']));
            }
        }

        return null;
    }

    private function getUserToPersistByUser(User $user): array
    {
        return [
            'login' => $user->getLogin(),
            'password' => sha1($user->getPassword()),
            'createdAt' => $user->getCreatedAt()->format('d.m.Y H:i:s'),
        ];
    }
}