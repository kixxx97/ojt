
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to 
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));
Vue.component('private-messages', require('./components/PrivateMessages.vue'));
Vue.component('private-form', require('./components/PrivateForm.vue'));



const app = new Vue({
    el: '#app',
    
    data: {
        messages: []   
    },

    created() {
        this.fetchMessages();

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                console.log(e);
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });

        
    },

    methods: {
        fetchMessages() {
            axios.get('messages').then(response => {
                this.messages = response.data;
            });
        },
        
        addMessage(message) {
            // console.log(message);   
            this.messages.push(message);

            axios.post('messages', message).then(response => {
                console.log(response);
            });
        }


        
    }
});


// console.log(vueData);


const app2 = new Vue({
    el: '#app2',
    
    data: {
        messages: [],
        room: vueData
    },

    created() {
        this.fetchMessages();
         
        Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });

        
    },

    methods: {
        fetchMessages() {
            axios.get('messages', this.recipient).then(response => {
                this.messages = response.data;
            });
        },
        
        addMessage(message) {
            this.messages.push(message);

            axios.post('messages', message).then(response => {
                // console.log(response);
            });
        }


        
    }
});

