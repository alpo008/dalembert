<?php use Illuminate\Support\Arr; ?>
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <p>
            Заявка от: <?=Arr::get($customerData, 'name');?>,
            <br />
            Место: <?=Arr::get($customerData, 'address');?>,
            <br />
            Телефон: <?=Arr::get($customerData, 'phone');?>,
            <br />
            Почта <?=Arr::get($customerData, 'email');?>,
        </p>
    </body>
</html>