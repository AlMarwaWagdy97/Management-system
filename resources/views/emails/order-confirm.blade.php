<x-mail::message>
 
<div>
    {{$message}}
</div>

<x-mail::button :url="$url">
عرض
</x-mail::button>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>