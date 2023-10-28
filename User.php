<?php

class User
{
    private ?\DateTimeImmutable $createdAt;
    public function __construct(
        private readonly string $login,
        private readonly string $password,
        private readonly string $passwordConfirmation,
        $createdAt = null,
    )
    {
        $this->createdAt = $createdAt;
        #Обязательно должно быть задано значение для createdAt
        if (null === $this->createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }
#Getters для получения логина и паролей, даты регистрации
    public function getLogin(): string
    {
        return strtolower($this->login);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
#Проверка совпадения паролей (тройное = потому что должны совпасть и по типу и по значению)
# sha1 - простейшее хэширование паролей для защиты информации :) , но с ней будут одинаковые хэши на одинаковые пароли :(
    public function isPasswordsEquals(): bool
    {
        return sha1($this->password) === sha1($this->passwordConfirmation);
    }
}