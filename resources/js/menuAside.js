import {
    mdiAccountCircle,
    mdiMonitor,
    mdiGithub,
    mdiLock,
    mdiAlertCircle,
    mdiSquareEditOutline,
    mdiTable,
    mdiViewList,
    mdiTelevisionGuide,
    mdiResponsive,
    mdiPalette,
    mdiReact,
} from "@mdi/js";

export default [
    {
        route: "dashboard",
        icon: mdiMonitor,
        label: "Dashboard",
    },
    {
        route: "tables",
        label: "Tables",
        icon: mdiTable,
    },
    {
        route: "games.index",
        label: "Games",
        icon: mdiTable,
    },
    {
        route: "users.index",
        label: "Users",
        icon: mdiTable,
    },
    {
        route: "roles.index",
        label: "Roles",
        icon: mdiTable,
    },
    {
        route: "shifts.index",
        label: "Shifts",
        icon: mdiTable,
    },
    {
        route: "jalurs.index",
        label: "Jalurs",
        icon: mdiTable,
    },
    {
        route: "prodis.index",
        label: "Prodis",
        icon: mdiTable,
    },
      {
        route: "tahuns.index",
        label: "Tahun",
        icon: mdiTable,
    },
    {
        route: "forms",
        label: "Forms",
        icon: mdiSquareEditOutline,
    },
    {
        route: "ui",
        label: "UI",
        icon: mdiTelevisionGuide,
    },
    {
        route: "responsive",
        label: "Responsive",
        icon: mdiResponsive,
    },
    {
        route: "styles",
        label: "Styles",
        icon: mdiPalette,
    },
    {
        route: "profilez",
        label: "Profilez",
        icon: mdiAccountCircle,
    },
    {
        route: "login",
        label: "Login",
        icon: mdiLock,
    },
    {
        route: "error",
        label: "Error",
        icon: mdiAlertCircle,
    },
    {
        label: "Dropdown",
        icon: mdiViewList,
        menu: [
            {
                label: "Item One",
            },
            {
                label: "Item Two",
            },
        ],
    },
    {
        href: "https://github.com/justboil/admin-one-vue-tailwind",
        label: "GitHub",
        icon: mdiGithub,
        target: "_blank",
    },
    {
        href: "https://github.com/justboil/admin-one-react-tailwind",
        label: "React version",
        icon: mdiReact,
        target: "_blank",
    },
];
