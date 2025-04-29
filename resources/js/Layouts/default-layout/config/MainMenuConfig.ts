import type {MenuItem} from "@/Layouts/default-layout/config/types";
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const sidebarMenuConfig: Array<MenuItem> = [
    {
        pages: [
            {
                heading: t('sidebarMenu.dashboard'),
                route: "/dashboard",
                keenthemesIcon: "element-11",
                bootstrapIcon: "bi-app-indicator",
            }
        ],
    },

    {
        heading: t('sidebarMenu.admin'),
        route: "/configurations",
        headingRoutes: ["/configurations", "/roles", "/users", "/companies", "/subscription-plans"],
        headingPermissions: ["can-view-configuration", "can-view-role", "can-view-user", "can-view-company", "can-view-subscription-plan"],
        pages: [
            {
                heading: t('sidebarMenu.configuration.menu'),
                route: "/configurations",
                routePermissions: ["can-view-configuration"],
                keenthemesIcon: "setting-2",
                bootstrapIcon: "bi-archive",
            },

            {
                sectionTitle: t('sidebarMenu.userManagement.menu'),
                route: "/users",
                keenthemesIcon: "profile-user",
                bootstrapIcon: "bi-archive",
                routeArray: ["/roles", "/users"],
                routePermissions: ["can-view-role", "can-view-user"],
                sub: [
                    {
                        heading: t('sidebarMenu.userManagement.submenu.roles'),
                        route: "/roles",
                        permission: "can-view-role",
                    },
                    {
                        heading: t('sidebarMenu.userManagement.submenu.users'),
                        route: "/users",
                        permission: "can-view-user",
                    },
                ],
            },
            {
                heading: 'Companies',
                route: "/companies",
                routePermissions: ["can-view-company"],
                keenthemesIcon: "bank",
                bootstrapIcon: "bi-archive",
            },
            {
                sectionTitle: 'Subscription',
                route: "/subscription-plans",
                keenthemesIcon: "price-tag",
                bootstrapIcon: "bi-archive",
                routeArray: ["/subscription-plans", "/subscription-plan-features"],
                routePermissions: ["can-view-subscription-plan", "can-view-subscription-plan-feature"],
                sub: [
                    {
                        heading: 'Subscription Plans',
                        route: "/subscription-plans",
                        permission: "can-view-subscription-plan"
                    },
                    {
                        heading: 'Subscription Plan Features',
                        route: "/subscription-plan-features",
                        permission: "can-view-subscription-plan-feature"
                    }
                ],
            },
            {
                heading: 'Email Provider',
                route: "/email-providers",
                routePermissions: ["can-view-email-provider"],
                keenthemesIcon: "send",
                bootstrapIcon: "bi-archive",
            },
        ],
    },
];

export default sidebarMenuConfig;
