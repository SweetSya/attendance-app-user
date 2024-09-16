// set the drawer menu element
const logoutDrawer = document.getElementById("logout-confirmation");

// options with default values
const logoutDrawerOptions = {
    placement: "bottom",
    backdrop: true,
    bodyScrolling: false,
    edge: false,
    edgeOffset: "",
    backdropClasses: "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-30",
};

// instance options object
const logoutInstanceOptions = {
    id: "logout-confirmation",
    override: true,
};

const LogoutConfirmationDrawer = new Drawer(
    logoutDrawer,
    logoutDrawerOptions,
    logoutInstanceOptions
);
