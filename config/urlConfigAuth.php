<?php
return [
    'GET registration' => '_common/auth/register-form-show',
    'POST registration' => '_common/auth/register',
    'auth' => '_common/auth',
    '<controller:(users-tools|users-gii)><action:(/.*|)>' => 'admin/users/<controller><action>'
];