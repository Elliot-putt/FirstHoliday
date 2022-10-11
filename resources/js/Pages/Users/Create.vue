<template>
    <Head>
        <title>Create User</title>
        <meta type="description" content="Creating a user in my app" head-key="description">
    </Head>
    <TitleLayout title="Create a User"
                 description=" fill in the details below to create a user. If you Believe you should have more access  contact test@gmail.com"/>
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
                                    :src="PlaceHolder"
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
                        <div class="col-12 col-md-6">
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
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <label for="password" class="form-label fw-bold">Password <span
                                    class="text-danger">*</span></label>
                                <div v-if="form.errors.password" v-text="' - ' + form.errors.password"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control"
                                       :class="form.errors.password ? 'border-danger' : '' " id="password"
                                       placeholder="Please enter a Password" v-model="form.password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</template>

<script setup>
import {useForm, usePage} from "@inertiajs/inertia-vue3"
import PlaceHolder from "../../../../public/images/placeholder.jpg"
import {useFlash} from "../../Composables/useFlash";
import TitleLayout from "../../Shared/TitleLayout";
import {ref} from "vue";
import DefaultButtons from "../../Shared/DefaultButtons";


let form = useForm({
    file: null,
    name: '',
    username: '',
    email: '',
    password: '',

});
let page = usePage().props.value;
let {flash} = useFlash();

let submit = () => {
    //do for all form posts
    form.post('/users', {
        onSuccess: () => flash('success', 'This form has been successful.'),
        onError: () => flash('Oops', 'This form has not submitted correctly please try again.', 'error'),
    });
}

</script>
