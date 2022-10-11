<template>
    <nav class="navbar navbar-expand-lg navbar-light py-4 px-2 justify-content-between  bg-purple sidebar"
         style="border-radius: 0">
        <div class="d-flex">
            <Link class="mx-2 m-auto  text-decoration-none text-white fs-4" href="/"><img class="img-small" :src="image">
            </Link>
        </div>
        <div>
            <label for="check" class="bar">
                <input v-model="isPanelOpen" id="check" type="checkbox">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
            </label>
        </div>
    </nav>
    <Sidebar :is-panel-open="isPanelOpen" :img="image">
        <NavLink class="mx-2" href="/" :active="$page.component === 'Home'" @click="isPanelOpen = !isPanelOpen">Home
        </NavLink>
        <NavLink class="mx-2" v-if="$page.props.auth.user.id" :href="`/users/${$page.props.auth.user.id}/show`"
                 @click="isPanelOpen = !isPanelOpen"
                 :active="$page.component === 'Users/Show'">Profile
        </NavLink>
        <NavLink class="mx-2" v-if="$page.props.auth.user.id" :href="`/tickets`"
                 @click="isPanelOpen = !isPanelOpen"
                 :active="$page.component === 'Tickets/View'">Tickets
        </NavLink>
        <NavLink v-if="$page.props.auth.user.id" class="mx-2" href="/users"
                 @click="isPanelOpen = !isPanelOpen"
                 :active="$page.component === 'Users/View'">Users
        </NavLink>
        <NavLink v-if="$page.props.auth.user.id" class="mx-2" href="/backups"
                 @click="isPanelOpen = !isPanelOpen"
                 :active="$page.component === 'Backups/View'">Backups
        </NavLink>
        <NavLink  class="mx-2" href="/documentation"
                 @click="isPanelOpen = !isPanelOpen"
                 :active="$page.component === 'Documents/View'">Documentation
        </NavLink>
        <NavLink  class="mx-2" href="/flights"
                 @click="isPanelOpen = !isPanelOpen"
                 :active="$page.component === 'Flights/View'">Flights
        </NavLink>
        <NavLink  class="mx-2" href="/hotels"
                 @click="isPanelOpen = !isPanelOpen"
                 :active="$page.component === 'Hotels/View'">Hotels
        </NavLink>
        <NavLink  class="mx-2" href="/packages"
                 @click="isPanelOpen = !isPanelOpen"
                 :active="$page.component === 'Packages/View'">Packages
        </NavLink>
        <NavLink v-if="$page.props.auth.user.id" class="mx-2 border-top mt-2" method="post" as="button" href="/logout">
            Logout
        </NavLink>
        <NavLink @click="isPanelOpen = !isPanelOpen" v-if="!$page.props.auth.user.id" class="mx-2 border-top mt-2"
                 href="/login">Login
        </NavLink>
    </Sidebar>
    <div class="sidebar-backdrop" @click="isPanelOpen = !isPanelOpen" v-if="isPanelOpen"></div>

</template>

<script setup>
import image from "../../../public/images/logo-white.png"
import NavLink from './NavLink';
import {usePage} from '@inertiajs/inertia-vue3'
import {computed, ref} from 'vue'
import Sidebar from "../Components/Sidebar";

let isPanelOpen = ref(false);
const username = computed(() => {
    return usePage().props.value.auth.user.username
});


</script>

