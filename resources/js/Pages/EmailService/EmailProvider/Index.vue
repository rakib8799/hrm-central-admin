<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" placeholder="Search email providers" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                        <!-- Start: Filter -->
                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-filter fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Filter
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->

                            <!--begin::Content-->
                            <div class="px-7 py-5" data-kt-user-table-filter="form">
                                <!-- Start: Status filter -->
                                <div class="mb-10">
                                    <label class="form-label fs-6 fw-semibold">Status:</label>
                                    <Multiselect
                                        placeholder = "Select Status"
                                        v-model=selectedStatus
                                        :searchable="true"
                                        :options="allStatus"
                                    />
                                </div>
                                <!-- End: Status filter -->

                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset" @click="applyReset()">{{ $t('buttonValue.reset') }}</button>
                                    <button class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter" @click="applyFilter()">{{ $t('buttonValue.apply') }}</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--End: Filter-->

                        <!--begin::Add Email Providers-->
                         <Link v-if="checkPermission('can-create-email-provider')" :href="route('email-providers.create')" class="btn btn-primary">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                                Add Email Provider
                        </Link>
                        <!--end::Add Email Providers -->

                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>
            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- Name -->
                    <template v-slot:name="{ row: emailProvider }">
                         {{ emailProvider.name }}
                    </template>

                    <!-- Slug -->
                    <template v-slot:slug="{ row: emailProvider }">
                         {{ emailProvider.slug }}
                    </template>

                    <!-- From Email -->
                    <template v-slot:from_email="{ row: emailProvider }">
                         {{ emailProvider.from_email }}
                    </template>

                    <!-- Status -->
                    <template v-slot:is_active="{ row: emailProvider }">
                        <div class = "badge" :class="{'badge-success': emailProvider?.is_active, 'badge-danger': !emailProvider?.is_active}">{{ emailProvider?.is_active ? 'Active' : 'Inactive' }}</div>
                    </template>

                    <!-- Actions -->
                    <template  v-if="checkPermission('can-edit-email-provider')" v-slot:actions="{ row: emailProvider }">
                        <div class="d-flex align-items-center justify-content-end">
                            <!-- Active Status -->
                            <div class="form-check form-check-solid form-switch">
                                <ChangeStatusButton  :obj="emailProvider" confirmRoute="email-providers.changeStatus" cancelRoute="email-providers.index" />
                            </div>
                            <!-- Edit -->
                            <Link :href="route('email-providers.edit', emailProvider.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                                <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                            </Link>
                        </div>
                    </template>
                    <template v-slot:actions="{ row: emailProvider }" v-else>
                        {{ $t('confirmation.permissionDenied') }}
                    </template>
                </Datatable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted,defineProps } from 'vue';
import Datatable from "@/Components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/Components/kt-datatable/table-partials/Models";
import { MenuComponent } from "@/Assets/ts/components";
import arraySort from "array-sort";
import { Link } from '@inertiajs/vue3';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import Multiselect from '@vueform/multiselect';
import { checkPermission } from "@/Core/helpers/Permission";
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';

const props = defineProps({
    emailProviders: Object as() => IEmailProvider[] | undefined,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

const selectedStatus = ref<string>('');

interface IEmailProvider {
    id: number;
    name: string;
    slug: string;
    from_email: string;
    is_active: string;
}

const tableHeader = ref([{
        columnName: "Name",
        columnLabel: "name",
        sortEnabled: true,
        columnWidth: 130
    },
    {
        columnName: "Slug",
        columnLabel: "slug",
        sortEnabled: true,
        columnWidth: 130
    },
    {
        columnName: "From Email",
        columnLabel: "from_email",
        sortEnabled: true,
        columnWidth: 130
    },
    {
        columnName: "Status",
        columnLabel: "is_active",
        sortEnabled: true,
        columnWidth: 130
    },
    {
        columnName: "Actions",
        columnLabel: "actions",
        sortEnabled: false,
        columnWidth: 100
    }
]);

const tableData = ref < IEmailProvider[] > ([]);
const initEmailProviders = ref < IEmailProvider[] > ([]);

onMounted(() => {
    if (props.emailProviders) {
        initEmailProviders.value = props.emailProviders.map(emailProvider => ({
            id: emailProvider.id,
            name: emailProvider.name,
            slug: emailProvider.slug,
            from_email: emailProvider.from_email,
            is_active: emailProvider.is_active
        }));
        tableData.value = initEmailProviders.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initEmailProviders.value];
    if (search.value !== "") {
        tableData.value = tableData.value.filter(item => searchingFunc(item, search.value));
    }
    MenuComponent.reinitialization();
};

const searchingFunc = (obj: any, value: string): boolean => {
    for (let key in obj) {
        if (!Number.isInteger(obj[key]) && !(typeof obj[key] === "object")) {
            if (obj[key] && obj[key].includes && obj[key].includes(value)) {
                return true;
            }
        }
    }
    return false;
};

// all Status
const allStatus = ['Active', 'Inactive'];

const applyFilter = () => {
    const statusFilter = selectedStatus.value;
    // Filter emailProviders based on selected status
    const isActive = statusFilter == 'Active' ? "1" : "0";
    tableData.value = initEmailProviders.value.filter(emailProvider => {
        return emailProvider.is_active == isActive;
    });
};

const applyReset = () => {
    selectedStatus.value = '';
    tableData.value = initEmailProviders.value;
}

const sortData = (sort: Sort) => {
    const reverse: boolean = sort.order === "asc";
    if (sort.label) {
        arraySort(tableData.value, sort.label, {
            reverse
        });
    }
};
</script>
