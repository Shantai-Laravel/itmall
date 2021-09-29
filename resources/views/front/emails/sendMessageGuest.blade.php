<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <p>Buna ziua,{{ $user->name }} {{ $user->surname }}</p>,
        <p>Dvs. v-ati inregistrat pe site-ul {{ getContactInfo('site')->translationByLanguage()->first()->value }}</p>.
        <p>In curind va contactam pentru a procesa comanda Dvs.</p>

        <p>Cu aceeasi ocazie va informam, ca vi s-a creat cont la noi pe site. Avind cont personal, va puteti loga in cabinetul Dvs. personal si beneficia de mai multe optiuni:</p>
        <p>1. Redactarea datelor personale</p>
        <p>2. Vizualizarea istoriei de comenzi (inclusiv de a vedea la care etapa de procesare este comanda curenta)</p>
        <p>3. Vizualiazarea produselor din Wishlist</p>
        <p>4. Solicitarea returului pe produse comandate</p>

        <p>Mai jos sunt datele de acces:</p>

        <p>Login: {{ $user->email }}</p>
        <p>Parola: {{ $password }}</p>

        <p>Daca doriti sa schimbati parola, apasati pe urmatorul <a href="digitalmall.md/{{ request()->segment(1) }} /register/changePass/ {{ session('token') }}">link</a></p>

        <p>Enter coupon code {{ $promocode->name }}, when you make your next purchase of {{ $promocode->treshold }} euro or more before {{ $promocode->valid_to }} and enjoy {{ $promocode->discount }}% off.

        <p>Va multumim!</p>

        <p>{{ getContactInfo('adminname')->translationByLanguage()->first()->value }}</p>
        <p>{{ getContactInfo('emailadmin')->translationByLanguage()->first()->value }}</p>
        <p>Tel: {{ getContactInfo('phone')->translationByLanguage()->first()->value }}</p>
        <p>Facebook: {{ getContactInfo('facebook')->translationByLanguage()->first()->value }}</p>
    </body>
</html>
