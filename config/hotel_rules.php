<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Hotel Rose Palace — House Rules & Information Configuration
    |--------------------------------------------------------------------------
    |
    | Structured configuration for all public hotel policies and house rules.
    | Maintaining rules in configuration keeps content separated from Blade
    | presentation and ensures stable anchor slugs for tab navigation & scroll-spy.
    |
    */

    'heading' => 'House Rules & Information',
    'subtitle' => 'Please review our property guidelines and stay requirements to ensure a seamless experience.',

    'categories' => [
        [
            'id' => 'must-read-rules',
            'tab_title' => 'MUST READ RULES',
            'heading' => 'Must Read Rules',
            'icon' => 'fas fa-exclamation-circle',
            'rules' => [
                'Primary Guest should be at least 18 years of age.',
                'Guests below 18 years of age must be accompanied by a parent or legally authorised guardian at check-in. The hotel may request appropriate identification to verify the accompanying adult\'s identity and authority.',
                'Stag groups and larger groups consisting exclusively of male guests may not be accommodated at the property. Individual business travellers and two corporate guests may be accepted subject to hotel verification and applicable property rules. The hotel reserves the right to verify guest details at check-in.',
                'Passport, Aadhaar, Driving License and Govt. ID are accepted as ID proof(s).',
                'Pets are not allowed.',
                'Smoking within the premises is not allowed.',
            ],
        ],
        [
            'id' => 'guest-profile',
            'tab_title' => 'GUEST PROFILE',
            'heading' => 'Guest Profile',
            'icon' => 'fas fa-user-friends',
            'rules' => [
                'Unmarried couples are not allowed.',
                'Primary guest should be at least 18 years of age.',
                'Guests below 18 years of age must be accompanied by a parent or legally authorised guardian at check-in. The hotel may request appropriate identification to verify the accompanying adult\'s identity and authority.',
                'Stag groups and larger groups consisting exclusively of male guests may not be accommodated at the property. Individual business travellers and two corporate guests may be accepted subject to hotel verification and applicable property rules. The hotel reserves the right to verify guest details at check-in.',
            ],
        ],
        [
            'id' => 'id-proof-related',
            'tab_title' => 'ID PROOF RELATED',
            'heading' => 'ID Proof Related',
            'icon' => 'fas fa-id-card',
            'rules' => [
                'Passport, Aadhaar, Driving License and Govt. ID are accepted as ID proof(s).',
                'Local IDs are not allowed.',
            ],
        ],
        [
            'id' => 'smoking-alcohol-consumption-rules',
            'tab_title' => 'SMOKING/ALCOHOL CONSUMPTION RULES',
            'heading' => 'Smoking/Alcohol consumption Rules',
            'icon' => 'fas fa-ban-smoking',
            'rules' => [
                'There are no restrictions on alcohol consumption.',
                'Smoking within the premises is not allowed.',
            ],
        ],
        [
            'id' => 'food-arrangement',
            'tab_title' => 'FOOD ARRANGEMENT',
            'heading' => 'Food Arrangement',
            'icon' => 'fas fa-utensils',
            'rules' => [
                'Non-veg food is allowed.',
                'Outside food is allowed.',
                'Food delivery is available.',
                'Food delivery available from Zomato, Swiggy and local restaurants.',
                'In-room dining available.',
            ],
        ],
        [
            'id' => 'property-accessibility',
            'tab_title' => 'PROPERTY ACCESSIBILITY',
            'heading' => 'Property Accessibility',
            'icon' => 'fas fa-wheelchair',
            'rules' => [
                'This property is not accessible to guests who use a wheelchair. Please make arrangements accordingly.',
            ],
        ],
        [
            'id' => 'pets-related',
            'tab_title' => 'PET(S) RELATED',
            'heading' => 'Pet(s) Related',
            'icon' => 'fas fa-paw',
            'rules' => [
                'Pets are not allowed.',
                'There are no pets living on the property.',
            ],
        ],
        [
            'id' => 'other-rules',
            'tab_title' => 'OTHER RULES',
            'heading' => 'Other Rules',
            'icon' => 'fas fa-clipboard-list',
            'rules' => [
                'Does not allow private parties or events.',
                'Guests are requested not to invite outside visitors in the room during their stay.',
            ],
        ],
        [
            'id' => 'child-extra-bed-policy',
            'tab_title' => 'CHILD & EXTRA BED POLICY',
            'heading' => 'Child & Extra Bed Policy',
            'icon' => 'fas fa-bed',
            'rules' => [
                'No extra bed will be provided to accommodate any child included in the booking.',
                'No extra bed will be provided to accommodate any additional guest included in the booking.',
            ],
        ],
    ],
];
