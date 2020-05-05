<?php
return [
    'auth' => '_common/auth',
    '<controller:(users-tools|users-gii)><action:(/.*|)>' => 'admin/users/<controller><action>'
];