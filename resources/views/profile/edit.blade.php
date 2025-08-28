<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Header del perfil -->
                <div class="bg-blue-600 dark:bg-blue-800 text-white px-6 py-8 text-center">
                    <div class="mx-auto w-32 h-32 rounded-full bg-white dark:bg-gray-700 flex items-center justify-center text-4xl font-bold text-blue-600 dark:text-blue-300 mb-4">
                        {{ strtoupper(substr($user['nombre'], 0, 1)) }}{{ strtoupper(substr($user['apellido'], 0, 1)) }}
                    </div>
                    <h1 class="text-2xl font-bold">{{ $user['nombre'] }} {{ $user['apellido'] }}</h1>
                    <p class="opacity-90">{{ $user['cargo'] }}</p>
                </div>
                
                <!-- Cuerpo del perfil -->
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Sección Información Personal -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            Información Personal
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Cédula:</span>
                                <span>{{ $user['cedula'] }}</span>
                            </div>
                            
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Email:</span>
                                <span>{{ $user['email'] }}</span>
                            </div>
                            
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Estado:</span>
                                <span class="{{ $user['activo'] ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $user['activo'] ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sección Información Laboral -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            Información Laboral
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Cargo:</span>
                                <span>{{ $user['cargo'] }}</span>
                            </div>
                            
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Nivel:</span>
                                <span>{{ $user['nivel'] }}</span>
                            </div>
                            
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Departamento:</span>
                                <span>{{ $user['departamento'] }}</span>
                            </div>
                            
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Tipo de Nómina:</span>
                                <span>{{ $user['nomina'] }}</span>
                            </div>
                            
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Estado de Pagos:</span>
                                <span class="px-2 py-1 text-xs rounded {{ $user['bloqueo_pagos'] === 'OPERATIVO' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $user['bloqueo_pagos'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sección Información Bancaria -->
                    <div>
                        <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            Información Bancaria
                        </h2>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Tipo de Cuenta:</span>
                                <span>{{ $user['tipo_de_cuenta'] === 'C' ? 'Corriente' : 'Ahorros' }}</span>
                            </div>
                            
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Número de Cuenta:</span>
                                <span>•••• •••• •••• •••• {{ substr($user['numero_cuenta'], -4) }}</span>
                            </div>
                            
                            <div class="flex">
                                <span class="font-medium text-gray-500 dark:text-gray-400 w-40">Banco:</span>
                                <span>{{ $user['banco'] ?? 'No especificado' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>