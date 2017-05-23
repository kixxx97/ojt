<template>
    <div class="input-group">
        <input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">
        
        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </span>
    </div>
</template>

<script>    
    export default {
        props: ['user','recipient'],

        data() {
            return {
                newMessage: ''
            }
        },

        methods: {
            sendMessage() {
                if(this.user.roles == 'agent')
                {
                this.$emit('messagesent', {
                    user: this.user,
                    message: this.newMessage,
                 });
                }
                else{
                    this.$emit('messagesent', {
                    user: this.user,
                    message: this.newMessage,
                    recipient: this.recipient.id
                });
                }


                this.newMessage = ''
            }
        }    
    }
</script>
