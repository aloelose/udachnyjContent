<x-mail::message>
# Здравствуйте, {{ $fullName }}!

Ваш новый пароль для входа на сайт:

**{{ $newPassword }}**

Пожалуйста, сохраните его в безопасном месте.


<x-mail::button :url="'http://localhost:5173/login'">
Войти
</x-mail::button>

Спасибо, что вы с нами!<br>
</x-mail::message>
