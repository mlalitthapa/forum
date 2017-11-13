<script>
    export default {
        props: ['attributes'],

        data() {
            return {
                editing: false,
                body: this.attributes.body
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Reply updated.');
            },

            destroy() {
                axios.delete('/replies/' + this.attributes.id);
                $(this.$el).fadeOut(() => {
                    flash('Your reply has been deleted.');
                });
            }
        }
    }
</script>