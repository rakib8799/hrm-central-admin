<template>
  <div>
    <!--begin::Items-->
    <div class="scroll-y mh-200px mh-lg-325px">
      <!--begin::Category title-->
      <h3 class="fs-5 text-muted m-0 pb-5">Users</h3>
      <!--end::Category title-->

      <!--begin::Item-->
      <a
        href="#"
        class="d-flex text-gray-900 text-hover-primary align-items-center mb-5"
      >
        <!--begin::Symbol-->
        <div class="symbol symbol-40px symbol-circle me-4">
          <img :src="getAssetPath('/media/avatars/300-14.jpg')" alt="" />
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column justify-content-start fw-semibold">
          <span class="fs-6 fw-semibold">Nick Pitola</span>
          <span class="fs-7 fw-semibold text-muted">Art Director</span>
        </div>
        <!--end::Title-->
      </a>
      <!--end::Item-->
      <!--begin::Item-->
      <a
        href="#"
        class="d-flex text-gray-900 text-hover-primary align-items-center mb-5"
      >
        <!--begin::Symbol-->
        <div class="symbol symbol-40px symbol-circle me-4">
          <img :src="getAssetPath('/media/avatars/300-11.jpg')" alt="" />
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column justify-content-start fw-semibold">
          <span class="fs-6 fw-semibold">Edward Kulnic</span>
          <span class="fs-7 fw-semibold text-muted">System Administrator</span>
        </div>
        <!--end::Title-->
      </a>
      <!--end::Item-->
      <!--begin::Category title-->
      <h3 class="fs-5 text-muted m-0 pt-5 pb-5">Customers</h3>
      <!--end::Category title-->

      <!--begin::Item-->
      <a
        href="#"
        class="d-flex text-gray-900 text-hover-primary align-items-center mb-5"
      >
        <!--begin::Symbol-->
        <div class="symbol symbol-40px symbol-circle me-4">
          <span class="symbol-label bg-light">
            <img
              class="w-20px h-20px"
              :src="getAssetPath('/media/svg/brand-logos/leaf.svg')"
              alt=""
            />
          </span>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column justify-content-start fw-semibold">
          <span class="fs-6 fw-semibold">EcoLeaf App Launch</span>
          <span class="fs-7 fw-semibold text-muted">Marketing</span>
        </div>
        <!--end::Title-->
      </a>
      <!--end::Item-->
      <!--begin::Item-->
      <a
        href="#"
        class="d-flex text-gray-900 text-hover-primary align-items-center mb-5"
      >
        <!--begin::Symbol-->
        <div class="symbol symbol-40px symbol-circle me-4">
          <span class="symbol-label bg-light">
            <img
              class="w-20px h-20px"
              :src="getAssetPath('/media/svg/brand-logos/tower.svg')"
              alt=""
            />
          </span>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column justify-content-start fw-semibold">
          <span class="fs-6 fw-semibold">Tower Group Website</span>
          <span class="fs-7 fw-semibold text-muted">Google Adwords</span>
        </div>
        <!--end::Title-->
      </a>
      <!--end::Item-->
      <!--begin::Category title-->
      <h3 class="fs-5 text-muted m-0 pt-5 pb-5">Projects</h3>
      <!--end::Category title-->
      <!--begin::Item-->
      <a
        href="#"
        class="d-flex text-gray-900 text-hover-primary align-items-center mb-5"
      >
        <!--begin::Symbol-->
        <div class="symbol symbol-40px symbol-circle me-4">
          <span class="symbol-label bg-light">
            <KTIcon icon-name="message-text-2" icon-class="fs-2 text-primary" />
          </span>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column">
          <span class="fs-6 fw-semibold"
            >Finance Monitoring SAAS Discussion</span
          >
          <span class="fs-7 fw-semibold text-muted">#21090</span>
        </div>
        <!--end::Title-->
      </a>
      <!--end::Item-->
      <!--begin::Item-->
      <a
        href="#"
        class="d-flex text-gray-900 text-hover-primary align-items-center mb-5"
      >
        <!--begin::Symbol-->
        <div class="symbol symbol-40px symbol-circle me-4">
          <span class="symbol-label bg-light">
            <KTIcon icon-name="profile-circle" icon-class="fs-2 text-primary" />
          </span>
        </div>
        <!--end::Symbol-->
        <!--begin::Title-->
        <div class="d-flex flex-column">
          <span class="fs-6 fw-semibold">Dashboard Analitics Launch</span>
          <span class="fs-7 fw-semibold text-muted">#34560</span>
        </div>
        <!--end::Title-->
      </a>
      <!--end::Item-->
    </div>
    <!--end::Items-->
  </div>
</template>

<script lang="ts">
import { getAssetPath } from "@/Core/helpers/Assets";
import { defineComponent } from "vue";

export default defineComponent({
  name: "kt-results",
  components: {},
  setup() {
    return {
      getAssetPath,
    };
  },
});
</script>
