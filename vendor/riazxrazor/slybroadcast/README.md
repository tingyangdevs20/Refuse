# Slybroadcast 
Laravel wrapper for Slybroadcast api integration voice messaging for business.

# Api Documentation
For documentation on the api please refer to https://www.mobile-sphere.com/vmb2/MobileSphere_slybroadcast_API_v2.0.pdf
for register and login visit http://www.slybroadcast.com/

## Installation

Open `composer.json` and add this line below.

```json
{
    "require": {
        "riazxrazor/slybroadcast": "^1.0.0"
    }
}
```

Or you can run this command from your project directory.

```console
composer require riazxrazor/slybroadcast
```

## Configuration

Open the `config/app.php` and add this line in `providers` section.

```php
Riazxrazor\Slybroadcast\SlybroadcastServiceProvider::class,
```

add this line in the `aliases` section.

```php
'Slybroadcast' => Riazxrazor\Slybroadcast\SlybroadcastFacade::class

```

get the `config` by running this command.

```console
php artisan vendor:publish --tag=config
```

config option can be found `app/slybroadcast.php`

```
    'USER_EMAIL' => '',

    'PASSWORD' => '',

    'DEBUG' => FALSE
```

## Basic Usage

You can use the function like this.

```php


\Slybroadcast::sendVoiceMail([
                                'c_phone' => "5104007646,5104007647,5104007648",
                                'c_url' =>"https://ia802508.us.archive.org/5/items/testmp3testfile/mpthreetest.mp3",
                                'c_record_audio' => '',
                                'c_date' => 'now',
                                'c_audio' => 'Mp3',
                                'c_callerID' => "18442305060",
                                'mobile_only' => 1,
                                'c_dispo_url' => 'https://2e2fe124.ngrok.io/voicepostback'
                               ])->getResponse();
                               
\Slybroadcast::pause($session_id)->getResponse();

\Slybroadcast::resume($session_id)->getResponse();
 
\Slybroadcast::accountMessageBalance()->getResponse();

\Slybroadcast::listAudioFiles()->getResponse();

// if you wana user different credentials for api call
\Slybroadcast::setCredentials($user_email,$password);                               
                                                                     


```