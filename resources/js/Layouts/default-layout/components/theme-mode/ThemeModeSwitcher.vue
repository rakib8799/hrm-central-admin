<template>
    <!--begin::Menu-->
    <div
      class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-muted menu-active-bg menu-state-primary fw-semibold py-4 fs-base w-175px"
      data-kt-menu="true"
      data-kt-element="theme-mode-menu"
    >
      <!--begin::Menu item-->
      <div class="menu-item px-3 my-0">
        <router-link
          :to="path"
          :class="{ active: themeMode === 'light' }"
          class="menu-link px-3 py-2"
          @click="setMode('light')"
        >
          <span class="menu-icon" data-kt-element="icon">
            <KTIcon icon-name="night-day" icon-class="fs-2" />
          </span>
          <span class="menu-title">{{ $t('themeMode.light') }}</span>
        </router-link>
      </div>
      <!--end::Menu item-->
      <!--begin::Menu item-->
      <div class="menu-item px-3 my-0">
        <router-link
          :to="path"
          :class="{ active: themeMode === 'dark' }"
          class="menu-link px-3 py-2"
          @click="setMode('dark')"
        >
          <span class="menu-icon" data-kt-element="icon">
            <KTIcon icon-name="moon" icon-class="fs-2" />
          </span>
          <span class="menu-title">{{ $t('themeMode.dark') }}</span>
        </router-link>
      </div>
      <!--end::Menu item-->
      <!--begin::Menu item-->
      <div class="menu-item px-3 my-0">
        <router-link
          :to="path"
          :class="{ active: themeMode === 'system' }"
          class="menu-link px-3 py-2"
          @click="setMode('system')"
        >
          <span class="menu-icon" data-kt-element="icon">
            <KTIcon icon-name="screen" icon-class="fs-2" />
          </span>
          <span class="menu-title">{{ $t('themeMode.system') }}</span>
        </router-link>
      </div>
      <!--end::Menu item-->
    </div>
    <!--end::Menu-->
  </template>

  <script lang="ts">
  import { getAssetPath } from "@/Core/helpers/Assets";
  import { computed, defineComponent } from "vue";
  import { useThemeStore } from "@/Stores/theme";
  import { useConfigStore } from "@/Stores/config";
  import { useRoute } from "vue-router";
  import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";

  export default defineComponent({
    name: "kt-theme-switcher",
    component: {},
    setup() {
      const storeTheme = useThemeStore();
      const storeConfig = useConfigStore();
      const route = useRoute();

      const themeMode = computed(() => {
        return storeTheme.mode;
      });

      const path = computed(() => route ? route.path : '');

      const setMode = (mode: "dark" | "light" | "system") => {
        let configMode = mode;

        storeConfig.setLayoutConfigProperty("general.mode", configMode);

        storeTheme.setThemeMode(configMode);
      };

      return {
        themeMode,
        setMode,
        path,
        getAssetPath,
      };
    },
  });
  </script>
