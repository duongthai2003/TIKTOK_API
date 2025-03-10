// import Echo from "laravel-echo";

// window.Pusher = require("pusher-js");
window._ = require("lodash");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: "your_pusher_key",
//     wsHost: "127.0.0.1",
//     wsPort: 6001,
//     forceTLS: false,
//     disableStats: true,
//     authEndpoint: "/broadcasting/auth",
//     cluster: "mt1",
//     auth: {
//         headers: {
//             Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNzI1ZmZiODY3MDAwNzJhMGI1OTkyNzZiM2Q0ZDAzZWYxMWYwODcyYWFhNGUzMWMwZWY3YWNmZTYyYzY5MzhlY2U1ODQ4MGIyNmZmODFlMjgiLCJpYXQiOjE3NDEyNDA4NDYuMzUyNjMzLCJuYmYiOjE3NDEyNDA4NDYuMzUyNjM1LCJleHAiOjE3NzI3NzY4NDYuMzQ2ODM1LCJzdWIiOiI1Iiwic2NvcGVzIjpbXX0.yStesfxdIg8VJZkIEoAzhlrjbzitk5e6XUA3L727ytg4HQnkFV8LZTJ2LsPqlpXhQs83APYwcdbaU1LoJoB7cCkEfh3U6MPcO6bhnOWlTzQN7Po1sIaI-jl6UoeaXNVjeW9t7zKMdYOlJFPzy0emMsiyln5mtKLvwPI8HCRdrtfHDsA1IiAXxiYZmZbLtU0Siaytc6mIyFOpZpH0flLS3NCGd5q6QwN_vVEq_wFtlbvn_tUZgIeZsO0AErC2Qya6pBSKLwVJYSKG-a3lMNXWnIiCuAe5wipwdJmmilaBTaidI8mdqpmhuRbHN_i4ckDtne7quojO6RdfP8JUdwFORE5NMWqzOlSYpY-9h89inIGondVmudHYa5PXa8ACQNtBHNDrUAMrUVl6lU2pNTLuYnLAT8zP6-jCZHKw3pkgVYyFes0i8lXeFu-YhI35PaZbyz-DAr8cxtWWkdyz49sscnh6kAnU05eIoNNHbGlpOkFdEbH_ZCeXUAP96YVmg4PCAdX0LE3x8Z90Vc5N6hVigdcue7JsE0ihi4S00PRDZ5B051WeXZru-oj1pAU_kjJICK9Mo2oS1KNpGUeBVNYwW7WJOR3j4VkLcnA0JYR6PeoeldTYVH3wgfAoCv2M6buukgcb8Bm_MmeFd7iEuuReVji0WmrN7elE73EmBdoMJcQ`, // Token xác thực nếu cần
//         },
//     },
// });
