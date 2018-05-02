<template>
    <div :id="'reply'+id" class="card my-2">
        <div class="card-header" :class="isBest ? 'bg-success' : 'bg-default'">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+reply.owner.name" 
                        v-text="reply.owner.name">
                    </a> said <span>{{ ago }}</span>...
                </h5>
                <div>
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form @submit.prevent="update">
                    <div class="form-group">
                        <wysiwyg v-model="body"></wysiwyg>
                    </div>
                    <button class="btn btn-sm btn-primary" type="submit">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>
        
        <div class="card-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-sm mr-2" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger mr-3" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-sm ml-auto" @click="markBestReply" v-if="authorize('owns', reply.thread)">Best Reply?</button>
        </div>
    </div>
</template>


<script>
    import Favorite from "./Favorite.vue";
    import moment from "moment";

    export default {
        props: ["reply"],
        components: { Favorite },
        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },
        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow();
            }
        },
        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },
        methods: {
            update() {
                axios
                    .patch("/replies/" + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data.message, "danger");
                    })
                    .then(({ }) => {
                        flash("Updated!");
                    });

                this.editing = false;
            },
            destroy() {
                axios.delete("/replies/" + this.id);

                this.$emit("deleted", this.id);
            },
            markBestReply() {
                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    };
</script>

<style scoped>

</style>
