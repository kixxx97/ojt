
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

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
        messages: [],
        user: userData,
        recipient: recipient
    },
    
    created() {
        this.fetchMessages();
        console.log(recipient);
        Echo.join('chat.'+recipient)
            .listen('MessageSent', (e) => {
                if(e.message.user_id == this.user.id || e.message.recipient_id == this.user.id)
                {
                console.log(e); 
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                    });
                }
                if(this.user.roles == 'IT' && e.message.user_id == recipient)
                {
                console.log(e);
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
                }
            });

        
    },

    methods: {
        fetchMessages() {
            var msg = { 
                user_id : this.recipient
            }
            console.log(msg.user_id);
            axios.post('messages/public', msg).then(response => {
                this.messages = response.data;
            });
        },
        
        addMessage(message) {
            // console.log(message);   
            this.messages.push(message);

            axios.post('messages', message).then(response => {

            });
        }


        
    }
});



const app2 = new Vue({
    el: '#app2',
    
    data: {
        messages: [],
        room: vueData
    },

    created() {
        this.fetchMessages();   
        

        Echo.private('chatroom.'+this.room.id)
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });

        
    },

    methods: {
        fetchMessages() {
            var room = { 
                room : this.room.id
            }

            axios.post('messages/private', room).then(response => {
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