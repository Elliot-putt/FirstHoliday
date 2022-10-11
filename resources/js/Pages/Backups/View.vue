<template>
    <Head>
        <title>Backups</title>
        <meta type="description" content="Information about my Backups" head-key="description">
    </Head>
    <TitleLayout title="Backups"
                 description="This page allows you to View your all your Backups. If you Believe you should have more access please contact test@gmail.com"/>
    <div class="d-flex justify-content-end m-4">
        <DefaultButtons/>
        <Link as="button" href="/backups/database" @click="flash('Backup Successful!' , 'Your backup has been created!')" class="btn btn-purple mx-2"><i class="fa-solid fa-rotate me-2" ></i>Backup Database</Link>
        <Link as="button" href="/backups/fullbackup"  @click="flash('Backup Successful!' , 'Your backup has been created!')" class="btn btn-purple mx-2"><i class="fa-solid fa-rotate me-2"></i>Backup Application</Link>
        <Link as="button" href="/backups/destroy" @click="flash('Backups Deleted!' , 'Your backups have been deleted!' , 'error')"  class="btn btn-red mx-2"><i class="fa-solid fa-times me-2"></i>Clear Backups</Link>
    </div>

    <div class="row justify-content-center mx-3" v-if="files">
        <div class="card shadow mb-4 ">
            <div class=" card-body row justify-content-start">
                <div v-for="file in files" :key="file.name" class=" col-md-3 ">
                    <div class="d-flex flex-column m-2">
                        <a class="cursor-click text-center text-decoration-none text-black" target="_blank"
                           :href="file.url">
                            <i class="fa-solid mx-auto fa-file-zipper"
                               style="font-size:80px"></i>
                        </a>
                        <div class="d-flex mx-auto ">
                            <p class="text-secondary text-center fs-4 mx-2 my-auto" v-text="file.name"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center m-4" v-if="files.length < 1">
                <div class="d-flex flex-column col-4">
                    <h3 class="text-secondary text-center">No Items within the Folder click create a backup folder.</h3>
                    <Link href="/backups"
                          class="fa-solid fa-arrows-rotate text-center text-purple text-decoration-none"
                          style="font-size: 70px"></Link>
                </div>
            </div>
        </div>
        </div>
</template>

<script setup>
import TitleLayout from "../../Shared/TitleLayout";
import DefaultButtons from "../../Shared/DefaultButtons";

import {useFlash} from "../../Composables/useFlash";

defineProps({
    files: Object,
});
let {flash} = useFlash();

</script>
