<template>
    <Head>
        <title>Login</title>
        <meta type="description" content="Logging into My App" head-key="description">
    </Head>
    <main class="custom-blue">
    <div class="vw-100 vh-100 d-flex justify-content-center align-items-center flex-column flex-md-row">
        <div class="col-10 col-md-4 mb-5 mb-md-0 me-md-4 p-4">
            <img :src="imageSmall" alt="Central Record" class="login-logo">
        </div>
        <div class="col-10 col-md-4 card p-4" id="loginContent">
            <div class="py-4 d-flex justify-content-center align-items-center flex-column">
                <h2 class="text-center my-4">Sign in to your account</h2>
                <a href='/login/microsoft' class="btn btn-purple w-lg-50 rounded-1 p-2 mt-2 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" style="height: 45px"
                         id="svg">
                        <g id="surface1">
                            <path style="fill: #6768AB"
                                  d="M 7 12 L 29 4 L 41 7 L 41 41 L 29 44 L 7 36 L 29 39 L 29 10 L 15 13 L 15 33 L 7 36 Z "/>
                        </g>
                    </svg>
                    Office 365
                </a>
                <p class="my-4 text-center text-muted">If you require assistance please contact webdev@clpt.co.uk</p>
            </div>
        </div>
    </div>
    </main>
</template>

<script setup>
import imageSmall from "../../../../public/images/logo-white.png"
import Swal from "sweetalert2";


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

