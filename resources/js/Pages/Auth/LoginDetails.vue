<template>
    <Head>
        <title>Login</title>
        <meta type="description" content="Logging into My App" head-key="description">
    </Head>
    <main
        class="font-sans text-gray-900 antialiased bg-login container-fluid vh-100 mx-auto d-md-flex  justify-content-around">
        <div class="my-auto justify-content-around" style="margin-top: 20px;">
            <div class="card-body">
                <form @submit.prevent="submit" class="d-block d-md-flex">
                    <div class="my-auto">
                        <img class="img" :src="imageSmall">
                        <p class="text-center text-white">Holiday Made Simple</p>
                    </div>
                    <div class="col-md-6 mx-auto text-center bg-white  shadow mt-5 p-4 rounded"
                         style="min-width: 300px">
                        <div>
                            <h3>Login</h3>
                        </div>
                        <div class="mb-4 mt-4 d-flex flex-column input-group">
                            <div class="d-flex">
                                <!--                                <label for="email" class="form-label fw-bold">Email</label>-->
                                <div v-if="form.errors.email" v-text="' - ' + form.errors.email"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control input-flow mx-auto" required
                                       :class="form.errors.email ? 'border-danger' : '' " id="email" placeholder="Email"
                                       v-model="form.email">
                            </div>
                        </div>
                        <div class="mb-4 d-flex flex-column input-group">
                            <div class="d-flex">
                                <!--                                <label for="password" class="form-label fw-bold">Password</label>-->
                                <div v-if="form.errors.password" v-text="' - ' + form.errors.password"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="password" required class="form-control input-flow mx-auto"
                                       :class="form.errors.password ? 'border-danger' : '' " id="password"
                                       placeholder="Password" v-model="form.password">
                            </div>
                        </div>
                        <div class="d-block  d-md-flex justify-content-center px-5">
                            <div class="text-center">
                                <button class="fancy my-3 my-md-0" type="submit">
                                    <span class="top-key"></span>
                                    <span class="text">Login</span>
                                    <span class="bottom-key-1"></span>
                                    <span class="bottom-key-2"></span>
                                </button>
                            </div>
                        </div>
                        <Link as="a" href="/signup" class=" text-end text-black-50 opacity-75">Create an account</Link>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>

<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import imageSmall from "../../../../public/images/logo-white.png"
import Swal from "sweetalert2";
import {Inertia} from "@inertiajs/inertia";
import {useFlash} from "../../Composables/useFlash";
let {flash} = useFlash();

let form = useForm({
    email: '',
    password: '',
});
let submit = () => {
//username and password login
    form.post('/login', {
        onSuccess: () => Toast.fire({
            icon: 'success',
            title: 'Signing you in!'
        }),
        onError: () => flash('Oops', 'This form has not submitted correctly please try again.', 'error'),
    });

}
let login = () => {
    //office login
    Toast.fire({
        icon: 'success',
        title: 'Signing you in!'
    });
}


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})


</script>
<script>
import GuestLayout from "../../Shared/Guest-Layout";

export default {
    layout: GuestLayout,
}
</script>

