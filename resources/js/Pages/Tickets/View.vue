<template>
    <Head>
        <title>Tickets</title>
        <meta type="description" content="Information about my Tickets" head-key="description">
    </Head>

    <TitleLayout title="Tickets"
                 description="This page allows you to search Tickets. If you Believe you should have more access please contact test@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <DefaultButtons/>
    </div>
    <div class="card shadow mb-4 mx-2">
        <div class=" card-body">
            <div class="d-flex mx-2">
                <label class="me-2 my-auto">Ticket Filter:</label>
                <input type="text" class="border rounded p-2" v-model="search" placeholder="Search.....">
            </div>
            <table class="table table-striped  table-hover table-responsive">
                <thead>
                <tr>
                    <th scope="col" class="text-purple">ref</th>
                    <th scope="col" class="text-purple d-none d-md-table-cell">Email</th>
                    <th scope="col" class="text-purple d-none d-md-table-cell">message</th>
                    <th scope="col" class="text-end text-purple">Options</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="ticket in tickets.data" :key="tickets.id">
                    <td v-text="ticket.ref"></td>
                    <td class="d-none d-md-table-cell" v-text="ticket.email"></td>
                    <td class="d-none d-md-table-cell" v-text="ticket.message"></td>
                    <td class="text-end">
                        <div class="dropdown no-arrow">
                            <a class="btn btn-purple dropdown-toggle" href="#" role="button"
                               id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu text-right dropdown-menu-right shadow animated--fade-in"
                                 aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header text-left">Options:</div>
                                <Link class="dropdown-item" :href="`/tickets/${ticket.id}`">
                                    View
                                </Link>
                                <Link class="dropdown-item" :href="`/tickets/${ticket.id}/edit`">
                                    Edit
                                </Link>
                                <Link class="dropdown-item">
                                    Delete
                                </Link>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <Pagination :links="tickets.links"/>
        </div>
    </div>
</template>
<script setup>
import Pagination from "../../Shared/Pagination"
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import throttle from "lodash/throttle"
import TitleLayout from "../../Shared/TitleLayout";
import Swal from "sweetalert2";
import DefaultButtons from "../../Shared/DefaultButtons";


let props = defineProps({
    tickets: Object,
    filters: Object,
});
let search = ref(props.filters.search);

watch(search, throttle(function (value) {
    Inertia.get('/tickets', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));

</script>
