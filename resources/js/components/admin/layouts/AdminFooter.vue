<template>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {{ version }}
        </div>
        <strong>
            Copyright &copy;
            <a href="https://github.com/Tenebreizh/">
                Tenebreizh
            </a>.
        </strong> All rights reserved.
    </footer>
</template>

<script>
export default {
    props: [
        'version',
    ]

}
</script>

<style>

</style>
