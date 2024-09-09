// set the drawer menu element
const propertiesDrawer = document.getElementById("drawer-hamburger");

// options with default values
const options = {
    placement: "right",
    backdrop: true,
    bodyScrolling: false,
    edge: false,
    edgeOffset: "",
    backdropClasses: "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-30",
    onHide: () => {
        dispatchEvent(new CustomEvent("toggle_hamburger"));
    },
    onShow: () => {
        dispatchEvent(new CustomEvent("toggle_hamburger"));
    },
};

// instance options object
const instanceOptions = {
    id: "drawer-hamburger",
    override: true,
};

const hamburgerDrawer = new Drawer(propertiesDrawer, options, instanceOptions);
