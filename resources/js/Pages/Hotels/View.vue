<template>
    <Head>
        <title>Hotels</title>
        <meta type="description" content="Information about my Hotels" head-key="description">
    </Head>

    <TitleLayout title="Hotels"
                 description="This page allows you to search Hotels. If you Believe you should have more access please contact firstholiday@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <DefaultButtons/>
    </div>
    <div class="card shadow mb-4 mx-2">
        <div class=" card-body">
            <div class="d-flex mx-2">
                <label class="me-2 my-auto">Hotel Filter:</label>
                <input type="text" class="border rounded p-2" v-model="search" placeholder="Search.....">
            </div>
            <div class="row my-4">
                <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-4" v-for="hotel in hotels.data">
                    <div class="card shadow h-100 pb-2">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 fs-4 font-weight-bold text-purple"
                                 v-text="hotel.name + ' Hotel'"></h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle text-secondary" href="#" role="button" id="dropdownMenuLink"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-secondary"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                     aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item">View</a>
                                    <a class="dropdown-item">Edit</a>
                                    <a class="dropdown-item">Delete</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="row no-gutters">
                                    <div class="col mr-2">
                                        <div class="mb-1">
                                            <Strong>{{ hotel.name }}</strong> <br>
                                            <Strong>City:{{ hotel.city }}</strong> <br>
                                            <p class="text-success">£{{hotel.pricePerNight}} - per night</p>
                                            <p>{{ hotel.address }}<br>
                                                Country:{{ hotel.country }}<br>
                                                {{ hotel.postcode }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class=" ms-4 ">
                                    <img alt="hotel image" src="https://loremflickr.com/g/190/140/paris"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <Pagination :links="hotels.links"/>
        </div>
    </div>
</template>
<script setup>
import Pagination from "../../Shared/Pagination"
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";
import throttle from "lodash/throttle"
import TitleLayout from "../../Shared/TitleLayout";
import imageSmall from "../../../../public/images/logo-white - orange.png"
import Swal from "sweetalert2";
import DefaultButtons from "../../Shared/DefaultButtons";


let props = defineProps({
    hotels: Object,
    filters: Object,
});

let search = ref(props.filters.search);

watch(search, throttle(function (value) {
    Inertia.get('/hotels', {search: value}, {
        preserveState: true,
        replace: true
    });
}, 500));


</script>
