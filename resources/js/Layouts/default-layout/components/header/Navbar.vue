<template>
    <!--begin::Navbar-->
    <div class="app-navbar flex-shrink-0">
        <div class="app-navbar-item">
          <Translate/>
        </div>
      <!--begin::Theme mode-->
      <div class="app-navbar-item ms-1 ms-md-3">
        <!--begin::Menu toggle-->
        <a
          href="#"
          class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px"
          data-kt-menu-trigger="{default:'click', lg: 'hover'}"
          data-kt-menu-attach="parent"
          data-kt-menu-placement="bottom-end"
        >
          <KTIcon
            v-if="themeMode === 'light'"
            icon-name="night-day"
            icon-class="fs-2"
          />
          <KTIcon v-else icon-name="moon" icon-class="fs-2" />
        </a>
        <!--begin::Menu toggle-->
        <KTThemeModeSwitcher />
      </div>
      <!--end::Theme mode-->
      <!--begin::User menu-->
      <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div
          class="cursor-pointer symbol symbol-35px"
          data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
          data-kt-menu-attach="parent"
          data-kt-menu-placement="bottom-end"
        >
          <!-- <img
            :src="getAssetPath('media/avatars/300-3.jpg')"
            class="rounded-3"
            alt="user"
          /> -->
          <div class="symbol-label fs-3 bg-light-danger text-danger">{{ getInitials(user) }}</div>
        </div>
        <KTUserMenu />
        <!--end::Menu wrapper-->
      </div>
      <!--end::User menu-->
      <!--begin::Header menu toggle-->
      <div
        class="app-navbar-item d-lg-none ms-2 me-n2"
        v-tooltip
        title="Show header menu"
      >
        <div
          class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px"
          id="kt_app_header_menu_toggle"
        >
          <KTIcon icon-name="element-4" icon-class="fs-2" />
        </div>
      </div>
      <!--end::Header menu toggle-->
    </div>
    <!--end::Navbar-->
  </template>

  <script lang="ts">
  import { getAssetPath } from "@/Core/helpers/Assets";
  import { computed, defineComponent } from "vue";
  import KTSearch from "@/Layouts/default-layout/components/search/Search.vue";
  import KTNotificationMenu from "@/Layouts/default-layout/components/menus/NotificationsMenu.vue";
  import KTUserMenu from "@/Layouts/default-layout/components/menus/UserAccountMenu.vue";
  import KTThemeModeSwitcher from "@/Layouts/default-layout/components/theme-mode/ThemeModeSwitcher.vue";
  import { ThemeModeComponent } from "@/Assets/ts/layout";
  import { useThemeStore } from "@/Stores/theme";
  import { usePage } from '@inertiajs/vue3';
  import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
  import { getInitials } from '@/Core/helpers/Helper';
  import Translate from '@/Components/Translate.vue';

  export default defineComponent({
    name: "header-navbar",
    components: {
        KTIcon,
      KTSearch,
      KTNotificationMenu,
      KTUserMenu,
      KTThemeModeSwitcher,
      Translate
    },
    setup() {
      const store = useThemeStore();
      const user = usePage().props.auth.user;

      const themeMode = computed(() => {
        if (store.mode === "system") {
          return ThemeModeComponent.getSystemMode();
        }
        return store.mode;
      });

      return {
        themeMode,
        getAssetPath,
        user,
        getInitials
      };
    },
  });
  </script>
