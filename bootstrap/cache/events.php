<?php return array (
  'App\\Providers\\EventServiceProvider' => 
  array (
    'Illuminate\\Auth\\Events\\Registered' => 
    array (
      0 => 'Illuminate\\Auth\\Listeners\\SendEmailVerificationNotification',
    ),
    'App\\Events\\SendBulkSMSEvent' => 
    array (
      0 => 'App\\Listeners\\SendBulkSMSListener',
    ),
  ),
);