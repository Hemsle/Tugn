<!--routes/exercises/+page.svelte-->
<script>
    import Library from "$lib/components/Library.svelte";
    import Searched from "$lib/components/Searched.svelte";
    import Exercise from "$lib/components/Exercise.svelte";

    import {
        searched,
        filteredExercises,
        selectedExercise,
        addExercises,
    } from "$lib/stores/exerciseStore";
    filteredExercises.set([]);
    selectedExercise.set(null);
    addExercises.set(false);
    searched.set(false);

    let { data } = $props(); //från +layout.server.js

    console.log(data);
</script>

<div id="content">
    <section id="exerciseInfo">
        {#if $searched === true}
            <Searched />
        {:else}
            <Exercise />
        {/if}
    </section>

    <section id="search">
        <Library {data} />
    </section>
</div>

<style lang="scss">
    #content {
        display: flex;
        -webkit-box-pack: center;
        max-width: 100rem;
        width: 100%;
        padding: 24px;
        gap: 24px;
        align-items: flex-start;
        flex-direction: row;
        justify-content: flex-end;
    }
    section {
        background-color: white;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        border-bottom: 0.3rem solid rgb(214, 214, 214);
        max-width: 63rem;
        width: 100%;
    }

    #search {
        height: 99.8%;
        width: 26rem;
    }

    /*
    #exerciseInfo {
        height: 70%;
        left: 25%;
        width: 45%;
    }
    */
</style>
