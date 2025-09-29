<x-mail::message>
 
<div>
    تم توصيح الهدية
    <br>
    ( {{ $productName }} )
    <br>
    ونسعد بخدمتكم 
    <br>
    برجاء تقييم الخدمة
    {{$message}}
</div>

<x-mail::button :url="$url">
تقييم
</x-mail::button>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>