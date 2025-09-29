<x-mail::message>
 
<div>
    {{$message}}
</div>
 
<x-mail::button :url="$url">
View Order
</x-mail::button>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>