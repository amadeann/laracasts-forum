<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <wysiwyg name="body" v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
            </div>
            <button 
                type="submit" 
                class="btn btn-primary"
                @click="addReply"
                >Post</button>
        </div>
        <div class="alert alert-info" role="alert" v-else>
            Please <a href="/login">sign in</a> to participate in this discussion.
        </div>
    </div>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';

    export default {
        data() {
            return {
                body: "",
                completed: false
            };
        },
        methods: {
            addReply() {
                axios
                    .post(location.pathname + "/replies", { body: this.body })
                    .catch(error => {
                        flash(error.response.data, "danger");
                    })
                    .then(({ data }) => {
                        this.body = "";
                        this.completed = true;

                        flash("Your reply has been posted.");

                        this.$emit("created", data);
                    });
            }
        },
        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function (query, callback) {
                        // console.log('called');
                        $.getJSON("/api/users", {
                            name: query
                        }, function (usernames) {
                            callback(usernames)
                        });
                    }
                }
            });
        }
    };
</script>