<!--routes/exercises/+page.svelte-->
<script>
    import Library from '$lib/components/Library.svelte';
    export let data;
</script>

<section>
    <Library {data} />
</section>

<style lang="scss">
    section {
        position: absolute;
        top: 3rem;
        left: 75%;
        background-color: white;
        width: 28rem;
        height: 93.8%;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
    }
</style>