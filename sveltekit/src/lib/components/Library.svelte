<!--$lib/components/Library.svelte-->
<script>
    import Selection from "./Selection.svelte";
    import ExerciseItem from "./ExerciseItem.svelte";
    import {
        selectedExercise,
        selectedExercises,
        searched,
        addExercises,
        exerciseArray,
        filteredExercises,
        showLibrary,
    } from "$lib/stores/exerciseStore.js";

    let { data } = $props();

    const exercises = data.exercises || [];

    function toggleLibrary() {
        showLibrary.set(false);
        selectedExercise.set(null);
        filteredExercises.set([]);
        searched.set(false);
        selectedExercises.set([]);
    }
</script>

<div id="library">
    <h1>
        Library
        {#if $showLibrary}
            <button id="close-library" onclick={toggleLibrary}>close</button>
        {/if}
    </h1>
    <Selection {data} />
    <h2>All Exercises</h2>
</div>

<div class="library-list">
    {#each exercises as exercise}
        <ExerciseItem {exercise} />
    {/each}
</div>

<style lang="scss">
    #library {
        display: flex;
        height: 20%;
        margin: 2rem;
        flex-direction: column;
        flex-wrap: nowrap;
        justify-content: flex-end;
        h1 {
            display: flex;
            justify-content: space-between;
        }
    }

    .library-list {
        overflow-x: auto;
        max-height: 63rem;
        height: 100%;
        margin: 2rem;
        padding: 1rem;
        padding-top: 1rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
    }
</style>
