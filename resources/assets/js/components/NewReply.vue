<template>
    <div>

        <div v-if="signedIn">
            <div class="form-group">
                <textarea
                        name="body"
                        id="body"
                        class="form-control"
                        rows="5"
                        placeholder="Enter your reply..."
                        required
                        v-model="body"
                >
                </textarea>
            </div>
            <button
                    class="btn btn-default"
                    type="submit"
                    @click="addReply"
            >Post
            </button>
        </div>

        <p class="text-center" v-else>
            Please <a href="/login">sign in</a> to participate in this thread.
        </p>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                body: ''
            }
        },

        computed: {
            signedIn(){
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {

                axios.post(location.pathname + '/replies', {body: this.body})
                    .then(response => {
                        this.body = '';

                        flash('Your reply has been posted.');

                        this.$emit('created', response.data);
                    });

            }
        }
    }
</script>