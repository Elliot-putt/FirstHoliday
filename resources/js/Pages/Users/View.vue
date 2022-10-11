<template>
    <Head>
        <title>Users</title>
        <meta type="description" content="Information about my app" head-key="description">
    </Head>

    <TitleLayout title="Users"
                 description="This page allows you to search Users. If you Believe you should have more access please contact test@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <DefaultButtons/>
        <Link href="/users/create" class=" my-auto mx-2 btn btn-purple">Create a new User +
        </Link>
    </div>
    <div class="card shadow mb-4 mx-2">
        <div class=" card-body">
            <div class="d-flex mx-2">
                <label class="me-2 my-auto">Name Filter:</label>
                <input type="text" class="border rounded p-2" v-model="search" placeholder="Search.....">
            </div>
            <table class="table table-striped  table-hover table-responsive">
                <thead>
                <tr>
                    <th scope="col" class="text-purple">Name</th>
                    <th scope="col" class="text-purple d-none d-md-table-cell">Email</th>
                    <th scope="col" class="text-purple d-none d-md-table-cell">Username</th>
                    <th scope="col" class="text-end text-purple">Options</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users.data" :key="user.id">
                    <td v-text="user.name"></td>
                    <td class="d-none d-md-table-cell" v-text="user.email"></td>
                    <td class="d-none d-md-table-cell" v-text="user.username"></td>
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
                                <Link  class="dropdown-item" :href="`/users/${user.id}/show`">
                                    View
                                </Link>
                                <Link  class="dropdown-item" :href="`/users/${user.id}/edit`">
                                    Edit
                                </Link>
                                <Link  class="dropdown-item" @click="options(user.id)">
                                    Delete
                                </Link>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <Pagination :links="users.links"/>
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
    users: Object,
    filters: Object,
    can: Object
});
let search = ref(props.filters.search);

watch(search, throttle(function (value) {
    Inertia.get('/users', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));

let options = (id) => {
    Swal.fire({
        title: 'User Options',
        text: "All changes are permanent",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#db5461',
        cancelButtonColor: '#a2abab',
        confirmButtonText: 'Yes, delete this user!'
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(`/users/${id}/delete`);
            //delete users inertia.delete
            Swal.fire(
                'Deleted!',
                'This user has been deleted.',
                'success'
            )
        }
    })
}
</script>
