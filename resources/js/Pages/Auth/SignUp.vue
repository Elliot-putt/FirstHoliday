<template>
    <Head>
        <title>Sign Up</title>
        <meta type="description" content="Logging into My App" head-key="description">
    </Head>
    <main class="font-sans text-gray-900 antialiased bg-login container-fluid vh-100 mx-auto d-md-flex  justify-content-around">
        <div class="my-auto justify-content-around" style="margin-top: 20px;">
            <div class="card-body">
                <form @submit.prevent="submit" class="d-block d-md-flex">
                    <div class="my-auto">
                        <img class="img" :src="imageSmall">
                        <p class="text-center text-white">Online packages holiday</p>
                    </div>
                    <div class="col-md-6 mx-auto text-center bg-white  shadow mt-5 p-4 rounded" style="min-width: 300px">
                        <div>
                            <h3>Sign Up</h3>
                        </div>
                        <div class="mb-4 mt-4 d-flex flex-column input-group">
                            <div class="d-flex">
                                <label for="email" class="form-label fw-bold">Enter a Name<span class="text-red">*</span></label>
                                <div v-if="form.errors.name" v-text="' - ' + form.errors.name"
                                     class="text-danger fs-6 mx-2"></div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="name" class="form-control input-flow mx-auto" required
                                       :class="form.errors.name ? 'border-danger' : '' " id="name" placeholder="Name"
                                       v-model="form.name">
                            </div>
                        </div>
                        <div class="mb-4 mt-4 d-flex flex-column input-group">
                            <div class="d-flex">
                                <label for="email" class="form-label fw-bold">Enter a Email<span class="text-red">*</span></label>
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
                                <label for="password" class="form-label fw-bold">Enter a Password<span class="text-red">*</span></label>
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
                                    <span class="text">Create Account</span>
                                    <span class="bottom-key-1"></span>
                                    <span class="bottom-key-2"></span>
                                </button>
                            </div>
                            <p class="text-center fs-5 mt-2 mx-3 my-3 d-none d-md-block">&#8592;</p>
                            <p class="text-center fs-5 mt-2 mx-3 my-3 d-none d-md-block">&#8594;</p>
                            <div>
                                <Link as="a" class="fancy my-3 my-md-0" href="/login" >
                                    <span class="top-key"></span>
                                    <span class="text ">Log In</span>
                                    <span class="bottom-key-1"></span>
                                    <span class="bottom-key-2"></span>
                                </Link>
                            </div>

                        </div>
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
    name: '',
});
let submit = () => {

    form.post('/signup', {
        onSuccess: () =>  flash('success', 'This form has been successful.') ,
        onError: () => flash('Oops', 'This form has not submitted correctly please try again.', 'error') ,
    });

}

</script>
<script>
import GuestLayout from "../../Shared/Guest-Layout";

export default {
    layout: GuestLayout,
}
</script>

