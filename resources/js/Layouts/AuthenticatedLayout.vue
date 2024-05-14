<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <div>
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Navigation Links -->
                        <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink :href="route('dashboard.usuarios')" :active="route().current('dashboard.usuarios')">
                                Usuarios
                            </NavLink>
                        </div>

                        <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink :href="route('dashboard.tareas')" :active="route().current('dashboard.tareas')">
                                Tareas
                            </NavLink>
                        </div>

                    </div>
                </div>
            </div>

        </nav>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
