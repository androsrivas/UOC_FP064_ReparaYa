<?php

return [
    'roles' => [
        'admin' => [
            'name' => 'Administrador',
            'layout' => 'sidebar',
            'sidebar-width' => 'w-64',
            'theme' => [
                'bg' => 'bg-slate-900',
                'text' => 'text-slate-300',
                'accent' => 'text-blue-400',
                'border' => 'border-slate-800',
                'active' => 'bg-blue-600 text-white',
                'icon' => 'shield-check',
            ]
        ],

        'tecnico' => [
            'name' => 'Servicio Técnico',
            'layout' => 'sidebar-compact',
            'sidebar-width' => 'w-72',
            'theme' => [
                'bg' => 'bg-indigo-900',
                'text' => 'text-indigo-300',
                'accent' => 'text-yellow-400',
                'border' => 'border-indigo-800',
                'active' => 'bg-yellow-400 text-indigo-950',
                'icon' => 'screwdriver-wrench',
            ]
        ],

        'particular' => [
            'name' => 'Cliente Particular',
            'layout' => 'centered-app',
            'theme' => [
                'bg' => 'bg-white',
                'text' => 'text-slate-600',
                'accent' => 'text-sky-600',
                'border' => 'border-slate-200',
                'active' => 'text-sky-600 font-bold',
                'icon' => 'user',
            ]
        ],

        'gestora' => [
            'name' => 'Empresa Gestora',
            'layout' => 'top-nav',
            'theme' => [
                'bg' => 'bg-emerald-900',
                'text' => 'text-emerald-100',
                'accent' => 'text-emerald-400',
                'border' => 'border-emerald-800',
                'active' => 'border-b-2 border-emerald-400 text-white',
                'icon' => 'building-office',
            ]
        ],
    ],
];