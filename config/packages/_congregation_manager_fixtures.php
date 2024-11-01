<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use CongregationManager\Locale;

return static function (ContainerConfigurator $containerConfigurator) {
    $containerConfigurator->extension('congregation_manager_fixtures', [
        'admins' => [
            [
                'email' => 'superadmin@email.com',
                'password' => 'superadmin',
                'locale' => Locale::Italian->value,
                'super_admin' => true,
            ],
            [
                'email' => 'admin@email.com',
                'password' => 'adminadmin',
                'locale' => Locale::Italian->value,
                'super_admin' => false,
            ],
        ],
        'congregations' => [
            [
                'name' => 'Carrollton',
            ],
        ],
        'brothers' => [
            [
                'first_name' => 'John',
                'middle_name' => null,
                'last_name' => 'Barr',
                'is_male' => true,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1954-04-07',
                'baptism_date' => '1969-06-18',
                'user' => [
                    'email' => 'jbarr@email.com',
                    'password' => 'password',
                    'locale' => Locale::Italian->value,
                ],
            ],
            [
                'first_name' => 'Brendon',
                'middle_name' => null,
                'last_name' => 'Walker',
                'is_male' => true,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1950-10-08',
                'baptism_date' => '1967-04-05',
                'user' => [
                    'email' => 'bwalker@email.com',
                    'password' => 'password',
                    'locale' => Locale::Italian->value,
                ],
            ],
            [
                'first_name' => 'Eleanor',
                'middle_name' => null,
                'last_name' => 'Walker',
                'is_male' => false,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1955-01-28',
                'baptism_date' => '1970-11-07',
            ],
            [
                'first_name' => 'Owen',
                'middle_name' => 'Junior',
                'last_name' => 'Carter',
                'is_male' => true,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1973-05-04',
                'baptism_date' => '1988-08-06',
                'user' => [
                    'email' => 'ocarter@email.com',
                    'password' => 'password',
                    'locale' => Locale::Italian->value,
                ],
            ],
            [
                'first_name' => 'Abigail',
                'middle_name' => null,
                'last_name' => 'Carter',
                'is_male' => false,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1974-03-31',
                'baptism_date' => '1982-06-01',
                'user' => [
                    'email' => 'acarter@email.com',
                    'password' => 'password',
                    'locale' => Locale::Italian->value,
                ],
            ],
            [
                'first_name' => 'Dylan',
                'middle_name' => null,
                'last_name' => 'Martinez',
                'is_male' => true,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1996-07-20',
                'baptism_date' => '2012-05-05',
                'user' => [
                    'email' => 'dmartinez@email.com',
                    'password' => 'password',
                    'locale' => Locale::Italian->value,
                ],
            ],
            [
                'first_name' => 'Christian',
                'middle_name' => null,
                'last_name' => 'Martinez',
                'is_male' => true,
                'congregation_name' => 'Carrollton',
                'birth_date' => '2006-02-04',
                'baptism_date' => null,
                'user' => [
                    'email' => 'cmartinez@email.com',
                    'password' => 'password',
                    'locale' => Locale::Italian->value,
                ],
            ],
            [
                'first_name' => 'Luke',
                'middle_name' => null,
                'last_name' => 'Martin',
                'is_male' => true,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1990-10-17',
                'baptism_date' => '2012-02-14',
                'user' => [
                    'email' => 'lmartin@email.com',
                    'password' => 'password',
                    'locale' => Locale::Italian->value,
                ],
            ],
            [
                'first_name' => 'Ava',
                'middle_name' => null,
                'last_name' => 'Adams',
                'is_male' => false,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1954-03-07',
                'baptism_date' => '1965-07-17',
                'user' => [
                    'email' => 'aadams@email.com',
                    'password' => 'password',
                    'locale' => Locale::Italian->value,
                ],
            ],
            [
                'first_name' => 'Victoria',
                'middle_name' => 'Elisabeth',
                'last_name' => 'Clark',
                'is_male' => false,
                'congregation_name' => 'Carrollton',
                'birth_date' => '1947-07-30',
                'baptism_date' => '1959-10-01',
            ],
        ],
    ]);
};
