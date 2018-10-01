window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

if(localStorage.getItem('user-token')!=undefined && axios.defaults.headers.common['Authorization']==undefined){
	axios.defaults.headers.common['Authorization'] = 'Bearer '+localStorage.getItem('user-token');
}

if(document.head.querySelector('meta[name="csrf-token"]')){
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;
}
else{
    console.error('CSRF token is needed');
}