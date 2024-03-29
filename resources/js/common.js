import axios from "axios";
var headers = {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
};
var mulipartHeaders = {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    "content-type": "multipart/form-data",
};
export default {
    methods: {
        log(tag, message) {
            if (message) {
                console.log(tag, message)
            } else {
                console.log(tag)
            }
        },
        callApi(method, url, data, head = headers) {
            let h = head != null ? head : headers;
            if (head == "multipart") {
                h = mulipartHeaders;
            } else if (head == "headers") {
                h = headers;
            }


            try {
                return axios({
                    method: method,
                    url: url,
                    data: data,
                    headers: h,
                });
            } catch (e) {
                return e.response;
            }
        },
        randomColor() {
            var red = Math.floor(Math.random() * (200 - 50 + 1)) + 50;
            var green = Math.floor(Math.random() * (200 - 50 + 1)) + 50;
            var blue = Math.floor(Math.random() * (200 - 50 + 1)) + 50;
            return `rgba(${red}, ${green}, ${blue}, 0.6)`;
        },
        isNumberOnly(e) {
            if (
                e.which != 8 &&
                e.which != 9 &&
                e.which != 13 &&
                e.which != 46 &&
                (e.which < 37 || e.which > 40) &&
                (e.which < 48 || e.which > 57) &&
                (e.which < 96 || e.which > 105)
            )
                return false;
            return true;
        },
    },
};
