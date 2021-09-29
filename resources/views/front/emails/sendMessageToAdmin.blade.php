<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <p>Email to admin New order</p>
        <p>New order from {{ getContactInfo('site')->translationByLanguage()->first()->value }} </p>

        <p>Hello, {{ getContactInfo('adminname')->translationByLanguage()->first()->value }}</p>
        <p>New order details:</p>
        <p>Products: {{ implode(',', $products) }}</p>

        <p>Date: {{ date('d m Y H:i:s', strtotime($order->created_at)) }}</p>
        <p>Order amount: {{ $order->amount }} lei</p>
        <p>Client email: {{ $order->userLogged->first()->email }}</p>

        <p>Success!</p>
    </body>
</html>
