<x-mail::message>
# {{ trans('statamic-auth::strings.password_reset_email.title') }}

{{ trans('statamic-auth::strings.password_reset_email.greeting', [
    'name' => App\Models\User::hasSeparateNameFields() ? $user->first_name : $user->name
]) }}

{{ trans('statamic-auth::strings.password_reset_email.line_1') }}

{{ trans('statamic-auth::strings.password_reset_email.line_2') }}

<x-mail::button :url="$url">
    {{ trans('statamic-auth::strings.password_reset_email.button_label') }}
</x-mail::button>

{{ trans('statamic-auth::strings.password_reset_email.line_3') }}

{{ trans('statamic-auth::strings.password_reset_email.sign_off') }}<br>
{{ config('app.name') }}

<x-mail::subcopy>
    {{ trans('statamic-auth::strings.password_reset_email.link_help') }} {{ $url }}
</x-mail::subcopy>
</x-mail::message>