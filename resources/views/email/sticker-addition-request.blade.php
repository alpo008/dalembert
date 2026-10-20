<?php use Illuminate\Support\Arr; ?>
<html>
    <head>
        <meta charset="utf-8" />
    </head>
    <body>
        <div>
            <?= __('From'); ?> : <?=Arr::get($stickerData, 'sender_name');?>,
            <br />
            Email: <?=Arr::get($stickerData, 'sender_email');?>,
            <br />
            @if ($sender_additional_info = Arr::get($stickerData, 'sender_additional_info'))
            <?= __('Additional information') . ': ' . $sender_additional_info ?>
            <br />
            @endif
            <hr />
            <?= __('General text'); ?> : <?=Arr::get($stickerData, 'venue');?>,
            <br />
            <?= __('Date of beginning'); ?> : <?=Arr::get($stickerData, 'doi');?>,
            <br />
            <?= __('Date of expire'); ?> : <?=Arr::get($stickerData, 'valid_until');?>,
            <br />
            @if ($sponsor_email = Arr::get($stickerData, 'sponsor_email'))
            <?= __('Sponsor email') . ': ' . $sponsor_email . ',' ?>
            <br />
            @endif
            @if ($sponsor_phone = Arr::get($stickerData, 'sponsor_phone'))
            <?= __('Sponsor phone') . ': ' . $sponsor_phone . ',' ?>
            <br />
            @endif
            @if ($link_address = Arr::get($stickerData, 'link_address'))
            <?= __('Reference to the source') . ': ' . $link_address ?>
            <br />
            @endif
        </div>
    </body>
</html>