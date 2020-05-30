@component('mail::message')

Hello,

New post has been uploaded, please take a look.
<br>
{{ $title }}


@component('mail::button', ['url' => $url])
View Post
@endcomponent

Thanks,<br>
BlogApp
@endcomponent