<?php

declare(strict_types=1);

require_once 'UserPersistInterface.php';

#Реализуем интерфейс UserPersistInterface здесь и в DatabaseUserPersist
class FileUserPersist implements UserPersistInterface
{
    const FILENAME = 'users.txt';

    public function save(User $user): void
    {
        if (file_exists(self::FILENAME)) {
            #чтобы считать из файла информацию
            $fileContains = json_decode(file_get_contents(self::FILENAME), true);
        } else {
            #если файла нет, то будет пустой массив
            $fileContains = [];
        }
        #При сохранении пользователя дописываем его в массив и сохраняем файл
        $fileContains[] = $this->getUserToPersistByUser($user);

        file_put_contents(self::FILENAME, json_encode($fileContains));
    }
#Возвращает логин пользователя, чтобы можно было сопоставить логин и пароль при Входе (и для уникальности логинов)
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

    #Получаем массив с данными пользователя: логин, пароль и дата регистрации
    private function getUserToPersistByUser(User $user): array
    {
        return [
            'login' => $user->getLogin(),
            'password' => sha1($user->getPassword()),
            'createdAt' => $user->getCreatedAt()->format('d.m.Y H:i:s'),
        ];
    }
}