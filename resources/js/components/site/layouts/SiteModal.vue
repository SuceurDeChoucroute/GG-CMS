<template>
    <div class="modal fade" :id="id" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ header }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                    
                    <button type="button" class="btn btn-success" data-dismiss="modal" @click="clickButton()">
                        {{ confirmButton }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'id',
        'header',
        'confirmButton'
    ],

    methods: {
        clickButton() {
            this.$emit('clicked')
        }
    }
}
</script>

<style>

</style>
