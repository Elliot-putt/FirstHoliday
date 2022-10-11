<template>
    <Head>
        <title>Edit User</title>
        <meta type="description" content="Editing a user" head-key="description">
    </Head>
    <TitleLayout title="Edit a User"
                 description="fill in the details below to edit a user. If you Believe you should have more access  contact test@gmail.com"/>
    <form @submit.prevent="submit">
        <div class="d-flex justify-content-end m-4">
            <DefaultButtons/>
            <button class="btn btn-green" :disabled="form.processing"><i class="fa-solid fa-floppy-disk me-2"></i>Submit
            </button>
        </div>
        <div class="row justify-content-center">

            <div class="col-10" id="page1">
                <div class="card shadow mt-4">
                    <div class="card-body row justify-content-center">
                        <div class="col-md-12 text-center">
                            <p class="mb-2 fw-bold">Profile Image: </p>
                            <label for="file">
                                <img
                                    :src="user.photo || PlaceHolder"
                                    class="rounded border border-secondary mb-4 img-small"
                                    alt="profile image">
                            </label>
                            <input id="file" hidden type="file" @input="form.file = $event.target.files[0]"
                                   class="form-control" name="file[]"
                                   accept="file_extension|audio/*|video/*|image/*|media_type">
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <label for="name" class="form-label fw-bold">Name <span
                                    class="text-danger">*</span></label>
                                <div v-if="form.errors.name" v-text="' - ' + form.errors.name"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" name="name" class="form-control"
                                       :class="form.errors.name ? 'border-danger' : '' " id="name"
                                       placeholder="Please enter a name" v-model="form.name">

                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <label for="email" class="form-label fw-bold">Email <span
                                    class="text-danger">*</span></label>
                                <div v-if="form.errors.email" v-text="' - ' + form.errors.email"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control"
                                       :class="form.errors.email ? 'border-danger' : '' " id="email"
                                       placeholder="Please enter a valid email" v-model="form.email">
                            </div>
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="d-flex">
                                <label for="username" class="form-label fw-bold">Username </label>
                                <div v-if="form.errors.username" v-text="' - ' + form.errors.username"
                                     class=" text-danger fs-6 mx-2"></div>
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" name="username" class="form-control"
                                       :class="form.errors.username ? 'border-danger' : '' " id="username"
                                       placeholder="Please enter a username" v-model="form.username">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import {useForm} from "@inertiajs/inertia-vue3"
import PlaceHolder from "../../../../public/images/placeholder.jpg"
import {usePage} from "@inertiajs/inertia-vue3";
import {useFlash} from "../../Composables/useFlash";
import {ref} from "vue";
import DefaultButtons from "../../Shared/DefaultButtons";
import TitleLayout from "../../Shared/TitleLayout";


defineProps({
    user: Object,
});
let {flash} = useFlash();
let page = usePage().props.value;

let form = useForm({
    file: null,
    name: page.user.name,
    username: page.user.username,
    email: page.user.email,
});


let submit = () => {
    form.post(`/users/${page.user.id}/update`, {
        onSuccess: () => flash('success', 'This form has been successful.'),
        onError: () => flash('Oops', 'This form has not submitted correctly please try again.', 'error'),
    })
}

</script>

