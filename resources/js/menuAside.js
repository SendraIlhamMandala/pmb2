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
    // {
    //     route: "tables",
    //     label: "Tables",
    //     icon: mdiTable,
    // },
    // {
    //     route: "games.index",
    //     label: "Games",
    //     icon: mdiTable,
    // },
    {
        route: "users.index",
        label: "User",
        icon: mdiTable,
    },
        {
        route: "user-pendaftar",
        label: "User pendaftar",
        icon: mdiTable,
    },
    {
        route: "verifikasiPembayaranUserIndex",
        label: "Verifikasi Pembayaran",
        icon: mdiTable,
    },
    {
        route: "roles.index",
        label: "Role",
        icon: mdiTable,
    },
    {
        route: "shifts.index",
        label: "Shift",
        icon: mdiTable,
    },
    {
        route: "articles.index",
        label: "Article",
        icon: mdiTable,
    },
    {
        route: "jalurs.index",
        label: "Jalur",
        icon: mdiTable,
    },
    {
        route: "prodis.index",
        label: "Prodi",
        icon: mdiTable,
    },
      {
        route: "tahuns.index",
        label: "Tahun",
        icon: mdiTable,
    },
    // {
    //     route: "forms",
    //     label: "Forms",
    //     icon: mdiSquareEditOutline,
    // },
    // {
    //     route: "ui",
    //     label: "UI",
    //     icon: mdiTelevisionGuide,
    // },
    // {
    //     route: "responsive",
    //     label: "Responsive",
    //     icon: mdiResponsive,
    // },
    // {
    //     route: "styles",
    //     label: "Styles",
    //     icon: mdiPalette,
    // },
    // {
    //     route: "profilez",
    //     label: "Profilez",
    //     icon: mdiAccountCircle,
    // },
    // {
    //     route: "login",
    //     label: "Login",
    //     icon: mdiLock,
    // },
    // {
    //     route: "error",
    //     label: "Error",
    //     icon: mdiAlertCircle,
    // },
    {
        label: "Verifikasi",
        icon: mdiViewList,
        menu: [
            {
                label: "User",
            },
            {
                label: "Pembayaran",
                route: "verifikasiPembayaranUserIndex",

            },
        ],
    },
    {
        label: "Artikel",
        icon: mdiViewList,
        menu: [
            {
                label: "Jadwal",
                href: "/articles/Jadwal%20Pendaftaran/edit",

            },
            {
                label: "Pengumuman",
                href: "/pengumumans",

            },

            {
                label: "Jalur Seleksi",
                href: "/articles/Jalur%20Seleksi%20Pendaftaran/edit",

            },   
            {
                label: "Beasiswa",
                href: "/articles/beasiswa/edit",

            },
            {
                label: "Program Studi",
                href: "/articles/Program%20Studi/edit",

            },
            {
                label: "Petunjuk Pendaftaran",
                href: "/articles/Petunjuk/edit",

            },
            

            
        ],
    },
    // {
    //     href: "https://github.com/justboil/admin-one-vue-tailwind",
    //     label: "GitHub",
    //     icon: mdiGithub,
    //     target: "_blank",
    // },
    // {
    //     href: "https://github.com/justboil/admin-one-react-tailwind",
    //     label: "React version",
    //     icon: mdiReact,
    //     target: "_blank",
    // },
];
