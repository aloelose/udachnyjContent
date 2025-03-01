<x-mail::message>
# Здравствуйте, {{ $fullName }}!

Добро пожаловать в **Удачный Контент**. Ваш пароль для входа на сайт:

**{{ $password }}**

Пожалуйста, сохраните его в безопасном месте.


<x-mail::button :url="'https://localhost:8000/login'">
Войти
</x-mail::button>

Спасибо, что вы с нами!<br>
</x-mail::message>
