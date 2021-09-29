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

        <p>Pentru a vedea statutul comenzii, invoice-ul generat, detaliile serviciului comandat si alte detalii, va invitam sa intrati in Client Area:</p>

        <p><a href="http://itmall.land/platform/clientarea.php">GO TO CLIENT AREA</a></p>

        <p>Enter coupon code {{ $promocode->name }}, when you make your next purchase of {{ $promocode->treshold }} euro or more before {{ $promocode->valid_to }} and enjoy {{ $promocode->discount }}% off.

        <p>Va multumim!</p>

        <p>{{ getContactInfo('adminname')->translationByLanguage()->first()->value }}</p>
        <p>{{ getContactInfo('emailadmin')->translationByLanguage()->first()->value }}</p>
        <p>Tel: {{ getContactInfo('phone')->translationByLanguage()->first()->value }}</p>
        <p>Facebook: {{ getContactInfo('facebook')->translationByLanguage()->first()->value }}</p>
    </body>
</html>
