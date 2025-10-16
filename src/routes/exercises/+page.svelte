<!--routes/exercises/+page.svelte-->
<script>
    import Library from "$lib/components/Library.svelte";
    import Searched from "$lib/components/Searched.svelte"; 
    import Exercise from "$lib/components/Exercise.svelte";
    import { searched } from "../../lib/stores/exerciseStore"
    export let data;
</script>

<section id="exerciseInfo">
    {#if $searched === true}
    <Searched />
    {:else}
    <Exercise {data}/>
    {/if}
</section>

<section id="search">
    <Library {data} />
</section>

<style lang="scss">
    section {
        position: absolute;
        background-color: white;
        top: 3rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
    }

    #search {
            height: 93.8%;
            left: 75%;
            width: 28rem;
    }

    #exerciseInfo {
            height: 70%;
            left: 25%;
            width: 45%;
    }
</style>
