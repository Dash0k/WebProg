<?php
#Интерфес нужен, когда мы не знаем конкретную реализацию класса,
# но хотим, чтобы у некоторого набора классов был один и тот же метод (здесь это для классов Database и FileUserPersist)
interface UserPersistInterface
{
#здесь метод save будет у каждого класса с ЭТИМ интерфейсом
    public function save(User $user): void;

    public function get(string $login): ?User;
}