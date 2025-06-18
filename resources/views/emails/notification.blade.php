<x-mail::message>
# Notificare Echipament
Angajatul **{{ $employeeName }}**<br>
A efectuat acțiunea: **{{ $action }}**<br>
Echipament: **{{ $equipmentName }}**
<x-mail::button :url="config('app.url')">
Vezi în sistem
</x-mail::button>
Mulțumim,<br>
{{ config('app.name') }}
</x-mail::message>
