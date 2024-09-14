const Alpinextra = {
    getData: (selector) => {
        el = document.querySelector(selector);
        console.log(Alpine.version);
        return el.__x.get();
    },
};
