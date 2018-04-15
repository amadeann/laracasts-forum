<template>
    <div :id="'reply'+id" class="card my-2">
        <div class="card-header" :class="isBest ? 'bg-success' : 'bg-default'">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+data.owner.name" 
                        v-text="data.owner.name">
                    </a> said <span>{{ ago }}</span>...
                </h5>
                <div>
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form @submit.prevent="update">
                    <div class="form-group">
                        <textarea class="form-control" rows="3" v-model="body" @keydown.enter.prevent @keyup.enter="update" required></textarea>
                    </div>
                    <button class="btn btn-sm btn-primary" type="submit">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>
        
        <div class="card-footer level">
            <div v-if="authorize('updateReply', reply)">
                <button class="btn btn-sm mr-3" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger mr-3" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-sm ml-auto" @click="markBestReply" v-show="! isBest">Best Reply?</button>
        </div>
    </div>
</template>


<script>
    import Favorite from "./Favorite.vue";
    import moment from "moment";

    export default {
        props: ["data"],
        components: { Favorite },
        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                isBest: this.data.isBest,
                reply: this.data
            };
        },
        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
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
                    .patch("/replies/" + this.data.id, {
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
                axios.delete("/replies/" + this.data.id);

                this.$emit("deleted", this.id);
            },
            markBestReply() {
                axios.post('/replies/' + this.data.id + '/best');

                window.events.$emit('best-reply-selected', this.data.id);
            }
        }
    };
</script>

<style scoped>

</style>
