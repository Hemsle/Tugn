<!--routes/exercises/+page.svelte-->
<script>
    import Library from "$lib/components/Library.svelte";
    import Searched from "$lib/components/Searched.svelte";
    import Exercise from "$lib/components/Exercise.svelte";
    import {
        searched,
        filteredExercises,
        selectedExercise,
        selectedExercises,
        addExercises,
        showLibrary,
    } from "$lib/stores/exerciseStore";

    filteredExercises.set([]);
    selectedExercise.set(null);
    addExercises.set(false);
    searched.set(false);
    showLibrary.set(false);
    selectedExercises.set([]);

    let { data } = $props(); //från +layout.server.js

</script>

<div class="content">
    <section id="exercise-info">
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
    section {
        background-color: white;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        border-bottom: 0.3rem solid rgb(214, 214, 214);
        width: 100%;
        max-height: 90rem;
    }

    #search {
        min-width: 28rem;
        width: 28rem;
    }
</style>
