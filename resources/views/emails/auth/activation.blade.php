@component('mail::message')
# Please activate your account

Hi {{ $user->name }}

Your user account with the e-mail address {{ $user->email }} has been created.

Please follow the link below to activate your account. The link will remain valid for 30 minutes.
Click here

@component('mail::button', ['url' => route('activate', $token)])
Activation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

