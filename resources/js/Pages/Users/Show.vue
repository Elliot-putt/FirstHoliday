<template>
    <main class='mt-3 container'>
        <TitleLayout :title="user.name + `'s `+ ' profile' "
                     description="This Page allows you to view a users details. If you have any queries please contact the web development team on sc@clpt.co.uk."/>
        <div class="d-flex justify-content-end m-4">
            <DefaultButtons/>
            <Link :href="`/users/${user.id}/edit`" class="my-auto mx-2 btn btn-yellow"><i class="fa-solid fa-edit me-2 "></i>Edit</Link>
        </div>
        <div class='card shadow mb-4'>
            <div class='card-body row justify-content-evenly'>
                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Profile Picture</p>
                        </div>
                        <div
                            class="p-2 px-5 border-top border-secondary border-2 h-100 d-flex justify-content-center align-items-center flex-column">
                            <img
                                :src="user.photo || PlaceHolder"
                                class="rounded border border-secondary mb-4 img-thumbnail"
                                alt="profile image">
                        </div>
                    </div>
                </div>

                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Information</p>
                        </div>
                        <div
                            class="bg-light p-4 border-top border-secondary border-2 min-box text-center d-flex justify-content-center align-items-center flex-column">

                            <div class="mb-4">
                                <h4>{{ user.name }}</h4>
                                <div class="model_title text-center h4 mb-1">
                                    <span class="opacity-75 fs-5">({{ user.username }})</span>
                                </div>
                           <a href="mailto:{{user.email}}" class="my-3 btn btn-grey">{{ user.email }}</a>
                            </div>
                            <div class="mb-4">
                                <h4 class="mb-3">Account Information</h4>
                                <p class="opacity-75 fs-5">Created: {{ user.date }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-12 col-md-4'>
                    <div class="box bg-light">
                        <div class="bg-white p-1 m-0">
                            <p class='text-center'>Quick Links</p>
                        </div>
                        <div class="bg-light p-4 border-top border-secondary border-2 min-box text-center d-flex justify-content-center align-items-center flex-column">
                            <Link href="/" class="btn btn-grey m-2" as="button"><i class="fa-solid fa-house me-2"></i>Home</Link>
                            <Link href="/" class="btn btn-grey m-2" as="button"><i class="fa-solid fa-briefcase me-2"></i>Chatbot</Link>
                            <Link href="/" class="btn btn-grey m-2" as="button"><i class="fa-solid fa-clipboard-user me-2"></i>Holidays</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</template>

<script setup>
import TitleLayout from "../../Shared/TitleLayout";
import PlaceHolder from "../../../../public/images/placeholder.jpg"
import {computed} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import Pagination from "../../Shared/Pagination"
import DefaultButtons from "../../Shared/DefaultButtons";


defineProps({
    user: Object,
    companies: Object,
});

</script>


