

try {

    window.$ = window.jQuery = require('jquery');
    window.Vue = require('vue');

    require('bootstrap');

} catch (e) {
    console.error(e);
}
