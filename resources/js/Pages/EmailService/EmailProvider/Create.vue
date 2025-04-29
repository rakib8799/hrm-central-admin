<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ props.emailProvider?.id ? 'Edit Email Provider' : 'Add Email Provider' }}</h3>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Name and Slug-->
                        <div class="row mb-5 g-4">
                            <!-- Email Provider Name -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Name</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Name" name="name" v-model="formData.name"/>
                                <ErrorMessage :errorMessage="formData.errors.name" />
                            </div>

                            <!-- Email Provider Slug -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">Slug</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Slug" name="slug" v-model="formData.slug"/>
                                <ErrorMessage :errorMessage="formData.errors.slug" />
                            </div>
                        </div>

                        <!-- API Key-->
                        <div class="row mb-5 g-4">
                            <div class="col-md-12 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">API Key</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="API Key" name="api_key" v-model="formData.api_key"/>
                                <ErrorMessage :errorMessage="formData.errors.api_key" />
                            </div>
                        </div>
                        
                        <!-- Username and Password-->
                        <div class="row mb-5 g-4">
                            <!-- Email Provider Username -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">User Name</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="User Name" name="username" v-model="formData.username"/>
                                <ErrorMessage :errorMessage="formData.errors.username" />
                            </div>

                            <!-- Email Provider Password -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Password</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Password" name="password" v-model="formData.password"/>
                                <ErrorMessage :errorMessage="formData.errors.password" />
                            </div>
                        </div>

                        <!-- Base Url and From Email-->
                        <div class="row mb-5 g-4">
                            <!-- Email Provider Base Url -->
                            <div class="col-md-6 fv-row">
                                <label class="fs-5 fw-semibold mb-2">Base Url</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Base Url" name="base_url" v-model="formData.base_url"/>
                                <ErrorMessage :errorMessage="formData.errors.base_url" />
                            </div>

                            <!-- Email Provider From Email -->
                            <div class="col-md-6 fv-row">
                                <label class="required fs-5 fw-semibold mb-2">From Email</label>
                                <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="From Email" name="from_email" v-model="formData.from_email"/>
                                <ErrorMessage :errorMessage="formData.errors.from_email" />
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton :id="props.emailProvider?.id" />
                    </div>
                </VForm>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script lang="ts" setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Field, Form as VForm } from "vee-validate";
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";

const props = defineProps({
    emailProvider: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

const formData = useForm({
    name: props.emailProvider?.name || '',
    slug: props.emailProvider?.slug || '',
    api_key: props.emailProvider?.api_key || '',
    username: props.emailProvider?.username || '',
    password: props.emailProvider?.password || '',
    base_url: props.emailProvider?.base_url || '',
    from_email: props.emailProvider?.from_email || ''
});

const submit = () => {
    if(props.emailProvider?.id) {
        // for updating emailProvider
        formData.patch(route('email-providers.update', props.emailProvider?.id), {
            preserveScroll: true,
        });
    } else {
        // for adding emailProvider
            formData.post(route('email-providers.store'), {
            preserveScroll: true,
        });
    }
};
</script>

